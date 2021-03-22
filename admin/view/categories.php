<?php



ob_start();
    session_start();

    $pageTitle= "members";
    $navbar= true;

    include "../helper/init.php";
    include "../controller/categoriesController.php";
    include "../controller/userController.php";

    $page= isset($_GET['page']) && !is_numeric($_GET['page']) ? $_GET['page'] : 'manage';


    if($page==='manage'){
        
        $categoryData= getCategoriesData(",users.userName", "INNER JOIN users ON users.uid = categoryAdmin ");
        ?>
        <div class="manage-container">
            <div class="title-container">
                <span class="title">Categories</span>
                <span><a href="?page=add">Add More!</a></span>
            </div>
            <?php
                if(empty($categoryData)){
                    ?>
                    <h1 style="text-align: center;" >No more categories start <a href="?page=add">Adding</a></h1>
                <?php
                }else{
                    ?>
                    <div class="grid-users">
                        <?php
                        foreach($categoryData as $category){
                            ?> 
                            <div class="category-container">
                                
                                <div class="user-inner-container">
                                    <div class="flex id-birthday">
                                        <div>
                                            <small>ID</small>
                                            <p class="uid"><?php echo $category['categoryId'] ?> </p>
                                        </div>
                                        <div>
                                            <small>Name</small>
                                            <p class="bd"><?php echo $category['categoryName'] ?></p>
                                        </div>
                                        <div>
                                            <small>Admin</small>
                                            <p class="cat-admin"><?php echo $category['userName'] ?></p>
                                        </div>
                                    </div>
                                    <div class="flex name-email">
                                        <div>
                                            <small>Description</small>
                                            <p class="desc"><?php echo $category['categoryDesc'] ?></p>
                                        </div>
                                        <div>
                                            <small>Add date</small>
                                            <p class="add-date"><?php echo $category['addDate'] ?></p>
                                        </div>
                                      
                                    </div>
                                    <div class="type">
                                    <?php 
                                    if($category['categoryStatus']==0){
                                        echo "<p> Viewable </p>";
                                    }elseif($category['categoryStatus']==1){
                                        echo "<p> Hidden </p>";
                                    }
                                    ?>
                                    </div>
                                </div>
                                <div class="edit-delete">
                                    <a class="edit" href="?page=edit&cid=<?php echo $category['categoryId'] ?>"><i class="fas fa-edit"></i> Edit</a>
                                        
                                    <a class="delete" name="categories" title="<?php echo $category['categoryName'] ?>" href="?page=delete&cid=<?php echo $category['categoryId'] ?>"><i class="fas fa-times"></i> Delete</a>
                                </div>
                            </div>
                        <?php    
                        }
                }
          
                ?>
            </div>
        
        </div>

    <?php
    }elseif($page==='add'){
        ?>
        <!-- Form to create a new user -->
        <div class="container-form">
            <form action="<?php $_SERVER['PHP_SELF']?>?page=insert" method="POST" class="form-inner-container">
                <div class="inputs-container cat-movie">
                    <input type="text" name="categoryName" required placeholder="Category Name"/><span class="required">*</span>
                </div>
                <div class="inputs-container cat-movie">
                    <textarea type="text" name="categoryDesc" required placeholder="Category Description"></textarea><span class="required">*</span>
                </div>
                <div class="inputs-container">
                    <select name="categoryStatus" class="selectCat"> 
                        <option disabled selected value="-1">Select Status</option>
                        <option value="0">Viewable</option>
                        <option value="1">Hidden</option>
                    </select> <span class="required">*</span>
                    <select name="categoryAdmin" class="selectCat"> 
                        <option disabled selected value="-1">Select Admin</option>
                        <?php
                            $userData= getUserData("WHERE userType = 2");
                            foreach($userData as $user){
                                ?>
                                <option value="<?php echo $user['uid']?>" ><?php echo $user['userName'] ?></option>
                            <?php
                            }
                        ?>
                    </select> <span class="required">*</span>
                </div>
                <button type="submit" name="submit">Add Category</button>
            </form>
        </div>
    <?php
    }elseif($page==='insert'){
        //If user enters the page without any data
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            redirectUser("Your not authorized to enter this page", "errord");
        }
        //To store error messages
        $formsError= array();
        $categoryName= filter_var($_POST['categoryName'], FILTER_SANITIZE_STRING);
        $categoryDesc= strtolower(trim(filter_var($_POST['categoryDesc'], FILTER_SANITIZE_STRING)));
        $categoryStatus= $_POST['categoryStatus'];
        $categoryAdmin= $_POST['categoryAdmin'];

        if(empty($categoryName)){
            array_push($formsError, "Category name can't be empty");
        }
        if(empty($categoryDesc)){
            array_push($formsError, "Category description can't be empty");
        }
        if($categoryStatus < 0){
            array_push($formsError, "Category status can't be empty");
        }
            
        if($categoryAdmin < 0){
            array_push($formsError, "Category admin can't be empty");
        }

        if(!empty($formsError)){
            foreach($formsError as $error){
                echo "<div class='errord'>";
                    echo "<p>" . $error . "</p>";
                echo "</div>";
            }
            header("REFRESH:2; URL={$_SERVER['HTTP_REFERER']}");
            exit();
        }

        $response= createCategory($categoryName, $categoryDesc, $categoryStatus, $categoryAdmin);
        

        if($response<0){
            //If < 0  means user is exist
            redirectUser("Category is already exist", "errord", "back");
        }elseif($response==0){
            // if ==0 means user not created successfully and there is an error
            redirectUser("Category NOT created successfully", "errord");
        }else{
            // means everything is correct
            redirectUser("Category created successfully", "success");
        }


        ?>
    <?php
    }elseif($page==='edit'){
        
        $categoryId= isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;

        $categoryData = findCategoryById($categoryId);

        if(empty($categoryData)){
            redirectUser("Category not found!", "errord", "back");
        }   
        ?>
       <div class="container-form">
            <form action="<?php $_SERVER['PHP_SELF']?>?page=update" method="POST" class="form-inner-container">
                <div class="inputs-container">
                    <input type="text" name="categoryName" value="<?php echo $categoryData['categoryName'] ?>" required placeholder="Category Name"/><span class="required">*</span>
                </div>
                <div class="inputs-container">
                    <textarea type="text" name="categoryDesc" required placeholder="Category Description"><?php echo ltrim($categoryData['categoryDesc']) ?></textarea><span class="required">*</span>
                </div>
                <div class="inputs-container">
                    <select name="categoryStatus" class="selectCat"> 
                        <option disabled selected value="-1">Select Status</option>
                        <option value="0" <?php if($categoryData['categoryStatus']==0) {echo "selected"; } ?> >Viewable</option>
                        <option value="1" <?php if($categoryData['categoryStatus']==1) {echo "selected"; } ?>>Hidden</option>
                    </select> <span class="required">*</span>
                    <select name="categoryAdmin" class="selectCat"> 
                        <option disabled selected value="-1">Select Admin</option>
                        <?php
                            $userData= getUserData("WHERE userType = 2");
                            foreach($userData as $user){
                                ?>
                                <option value="<?php echo $user['uid']?>" <?php if($categoryData['categoryId']==$user['uid']) {echo "selected"; } ?> ><?php echo $user['userName'] ?></option>
                            <?php
                            }
                        ?>
                    </select> <span class="required">*</span>
                </div>
                <input type="hidden" name="categoryId" value="<?php echo $categoryData['categoryId'] ?>"/>
                <button type="submit" name="submit">Update Category</button>
            </form>
        </div>
      
    <?php
    }elseif($page==='update'){
        //If user enters the page without any data
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            redirectUser("Your not authorized to enter this page", "errord");
        }
        //To store error messages
        $formsError= array();
        $categoryId= $_POST['categoryId'];
        $categoryName= filter_var($_POST['categoryName'], FILTER_SANITIZE_STRING);
        $categoryDesc= strtolower(trim(filter_var($_POST['categoryDesc'], FILTER_SANITIZE_STRING)));
        $categoryStatus= $_POST['categoryStatus'];
        $categoryAdmin= $_POST['categoryAdmin'];

        if(empty($categoryName)){
            array_push($formsError, "Category name can't be empty");
        }
        if(empty($categoryDesc)){
            array_push($formsError, "Category description can't be empty");
        }
        if($categoryStatus < 0){
            array_push($formsError, "Category status can't be empty");
        }
            
        if($categoryAdmin < 0){
            array_push($formsError, "Category admin can't be empty");
        }

        if(!empty($formsError)){
            foreach($formsError as $error){
                echo "<div class='errord'>";
                    echo "<p>" . $error . "</p>";
                echo "</div>";
            }
            header("REFRESH:2; URL={$_SERVER['HTTP_REFERER']}");
            exit();
        }

        $response= findCategoryByIdAndUpdate($categoryName, $categoryDesc, $categoryStatus, $categoryAdmin, $categoryId);

        if($response<=0){
            // if ==0 means user not created successfully and there is an error
            redirectUser("Category NOT updated successfully, You may not edit some fields", "errord", "back");
        }else{
            // means everything is correct
            redirectUser("Category updated successfully", "success");
        }
        ?>
    <?php
    }elseif($page==='delete'){
        //If user enters the page without any data
       
        $categoryId= isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;

        $response= findCategoryByIdAndDelete($categoryId);
            
    
        if($response<=0){
             redirectUser("Category NOT deleted successfully", "back");
         }else{
             redirectUser("Category Deleted successfully", "success");
         }

        ?>
    <?php
    }else{
        header("Location:users.php");
    }






    include "../reusable/footer.php";

    ob_end_flush();
?>


