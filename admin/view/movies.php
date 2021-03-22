<?php



ob_start();
    session_start();

    $pageTitle= "members";
    $navbar= true;

    include "../helper/init.php";
    include "../controller/categoriesController.php";
    include "../controller/userController.php";
    include "../controller/moviesController.php";

    $page= isset($_GET['page']) && !is_numeric($_GET['page']) ? $_GET['page'] : 'manage';


    if($page==='manage'){
        
        $moviesData= getMoviesData(",categories.categoryName, users.userName", "INNER JOIN categories categories ON categories.categoryId = movies.category INNER JOIN users users ON users.uid = movies.movieCreator ");
        ?>
        <div class="manage-container">
            <div class="title-container">
                <span class="title">Movies</span>
                <span><a href="?page=add">Add More!</a></span>
            </div>
            <?php
                if(empty($moviesData)){
                    ?>
                    <h1 style="text-align: center;" >No more movies. start <a href="?page=add">Adding</a></h1>
                <?php
                }else{
                    ?>
                    <div class="grid-users">
                        <?php
                        foreach($moviesData as $movie){
                            ?> 
                            <div class="category-container">
                                
                                <div class="user-inner-container">
                                    <div class="flex id-birthday">
                                        <div>
                                            <small>ID</small>
                                            <p class="uid">
                                            <?php 
                                            echo $movie['movieId'] 
                                            ?> 
                                            </p>
                                        </div>
                                        <div>
                                            <small>Name</small>
                                            <p class="bd"><?php 
                                            echo $movie['movieName'] 
                                            ?>
                                            </p>
                                        </div>
                                        <div>
                                            <small>Creator</small>
                                            <p class="cat-admin">
                                            <?php 
                                            echo $movie['userName'] 
                                            ?></p>
                                        </div>
                                    </div>
                                    <div class="flex name-email">
                                        <div>
                                            <small>Category</small>
                                            <p class="cat"><?php 
                                            echo $movie['categoryName'] 
                                            ?></p>
                                        </div>
                                        <div>
                                            <small>Add date</small>
                                            <p class="add-date"><?php 
                                            echo $movie['addDate'] 
                                            ?></p>
                                        </div>
                                        <div>
                                            <small>Duration</small>
                                            <p class="duration"><?php 
                                            echo $movie['movieDuration'] 
                                            ?></p>
                                        </div>
                                    </div>
                                    <div class="flex name-email">
                                        <div>
                                            <small>Story</small>
                                            <p class="desc"><?php 
                                            echo $movie['movieDesc']
                                                ?></p>
                                        </div>
                                        <div>
                                            <small>Guide</small>
                                            <p class="guide"><?php 
                                            if( $movie['ratingGuide']==0){
                                                echo "G";
                                            }elseif($movie['ratingGuide']==1){
                                                echo "PG";
                                            }elseif($movie['ratingGuide']==2){
                                                echo "PG-13";
                                            }elseif($movie['ratingGuide']==3){
                                                echo "R";
                                            }elseif($movie['ratingGuide']==4){
                                                echo "NC-17";
                                            }
                                            ?></p>
                                        </div>
                                    </div>
                                    <div class="type">
                                    <?php 
                                    if($movie['movieStatus']==0){
                                        echo "<p> Viewable </p>";
                                    }elseif($movie['movieStatus']==1){
                                        echo "<p> Not approved </p>";
                                    }
                                    ?>
                                    </div>
                                </div>
                                <div class="edit-delete">
                                     <?php
                                     if($movie['movieStatus']==1){
                                         ?>
                                    <a class="edit" href="?page=approve&mid=<?php 
                                    echo $movie['movieId']
                                     ?>"><i class="fas fa-check"></i> approve</a> 
                                     <?php
                                     }else{
                                         ?>
                                        <a class="edit" href="?page=edit&mid=<?php 
                                        echo $movie['movieId']
                                         ?>"><i class="fas fa-edit"></i> Edit</a>    
                                     <?php
                                     }
                                     
                                     ?>
                                        
                                    <a class="delete" name="categories" title="<?php 
                                    echo $movie['movieId']
                                    ?>" href="?page=delete&mid=<?php 
                                    echo $movie['movieId']
                                     ?>"><i class="fas fa-times"></i> Delete</a>
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
                    <input type="text" name="movieName"  placeholder="Movie Name"/><span class="required">*</span>
                </div>
                <div class="inputs-container cat-movie">
                    <textarea type="text" name="movieDesc"  placeholder="Movie Description"></textarea><span class="required">*</span>
                </div>
                <div class="inputs-container cat-movie">
                    <input type="text" maxlength="8" name="movieDuration" id="duration" required placeholder="Movie duration hh:mm:ss:"/><span class="required">*</span>
                </div>
                <div class="inputs-container">
                    <select name="movieStatus" class="selectCat"> 
                        <option disabled selected value="-1">Select Status</option>
                        <option value="0">Viewable</option>
                        <option value="1">Hidden</option>
                    </select> <span class="required">*</span>
                    <select name="ratingGuide" class="selectCat"> 
                        <option disabled selected value="-1">Select Rating Guide</option>
                        <option value="0">G</option>
                        <option value="1">PG</option>
                        <option value="2">PG-13</option>
                        <option value="3">R</option>
                        <option value="4">NC-17</option>
                    </select> <span class="required">*</span>
                </div>
                <div class="inputs-container">
                    <select name="category" class="selectCat"> 
                        <option disabled selected value="-1">Select Category</option>
                        <?php
                            $catData= getCategoriesData("","");
                            foreach($catData as $cat){
                                ?>
                                <option value="<?php echo $cat['categoryId']?>" ><?php echo $cat['categoryName'] ?></option>
                            <?php
                            }
                        ?>
                    </select> <span class="required">*</span>
                    <select name="movieCreator" class="selectCat"> 
                        <option disabled selected value="-1">Select Creator</option>
                        <?php
                            $userData= getUserData("WHERE userType = 1");
                            foreach($userData as $user){
                                ?>
                                <option value="<?php echo $user['uid']?>" ><?php echo $user['userName'] ?></option>
                            <?php
                            }
                        ?>
                    </select> <span class="required">*</span>
                </div>
                <button type="submit" name="submit">Add Movie</button>
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
        $movieName= filter_var($_POST['movieName'], FILTER_SANITIZE_STRING);
        $movieDesc= strtolower(ltrim(filter_var($_POST['movieDesc'], FILTER_SANITIZE_STRING)));
        $movieDuration= filter_var($_POST['movieDuration'], FILTER_SANITIZE_STRING);
        $movieStatus= $_POST['movieStatus'];
        $ratingGuide= $_POST['ratingGuide'];
        $category= $_POST['category'];
        $movieCreator= $_POST['movieCreator'];

        //To check wheteher [:] is exist or not;
        $movieDuration= explode(":", $movieDuration);
        
       
        if(count($movieDuration)<3){
            array_push($formsError, "error in writeing duration you may forgot [:]");
        }else{
            $movieDuration= implode(":", $movieDuration);
        }
 

        if(empty($movieName)){
            array_push($formsError, "Movie name can't be empty");
        }
        if(empty($movieDesc)){
            array_push($formsError, "Movie description can't be empty");
        }
        if($movieStatus < 0){
            array_push($formsError, "Movie status can't be empty");
        }
            
        if($ratingGuide < 0){
            array_push($formsError, "Movie rating guide can't be empty");
        }

        if($category < 0){
            array_push($formsError, "Movie category can't be empty");
        }

        if($movieCreator < 0){
            array_push($formsError, "Movie creator can't be empty");
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

        $response= createMovie($movieName, $movieDesc, $movieDuration,$movieStatus, $ratingGuide ,$category, $movieCreator);
        

        if($response<0){
            //If < 0  means user is exist
            redirectUser("Movie is already exist", "errord", "back");
        }elseif($response==0){
            // if ==0 means user not created successfully and there is an error
            redirectUser("Movie NOT created successfully", "errord");
        }else{
            // means everything is correct
            redirectUser("Movie created successfully", "success");
        }


        ?>
    <?php
    }elseif($page==='edit'){
        
        $movieId= isset($_GET['mid']) && is_numeric($_GET['mid']) ? intval($_GET['mid']) : 0;

        $movieData = findMovieById($movieId);

        if(empty($movieData)){
            redirectUser("Movie not found!", "errord", "back");
        }   
        ?>
        <div class="container-form">
            <form action="<?php $_SERVER['PHP_SELF']?>?page=update" method="POST" class="form-inner-container">
                <div class="inputs-container cat-movie">
                    <input type="text" name="movieName" value="<?php echo $movieData['movieName'] ?>"  placeholder="Movie Name"/><span class="required">*</span>
                </div>
                <div class="inputs-container cat-movie">
                    <textarea type="text" name="movieDesc"  placeholder="Movie Description"><?php echo ltrim($movieData['movieDesc']) ?></textarea><span class="required">*</span>
                </div>
                <div class="inputs-container cat-movie">
                    <input type="text" maxlength="8" value="<?php echo $movieData['movieDuration'] ?>" name="movieDuration" id="duration" required placeholder="Movie duration hh:mm:ss:"/><span class="required">*</span>
                </div>
                <div class="inputs-container">
                    <select name="movieStatus" class="selectCat"> 
                        <option disabled selected value="-1">Select Status</option>
                        <option value="0" <?php if($movieData['movieStatus']==0){echo "selected";}?> >Viewable</option>
                        <option value="1" <?php if($movieData['movieStatus']==1){echo "selected";}?> >Hidden</option>
                    </select> <span class="required">*</span>
                    <select name="ratingGuide" class="selectCat"> 
                        <option disabled selected value="-1">Select Rating Guide</option>
                        <option value="0" <?php if($movieData['ratingGuide']==0){echo "selected";}?> >G</option>
                        <option value="1" <?php if($movieData['ratingGuide']==1){echo "selected";}?> >PG</option>
                        <option value="2" <?php if($movieData['ratingGuide']==2){echo "selected";}?> >PG-13</option>
                        <option value="3" <?php if($movieData['ratingGuide']==3){echo "selected";}?> >R</option>
                        <option value="4" <?php if($movieData['ratingGuide']==4){echo "selected";}?> >NC-17</option>
                    </select> <span class="required">*</span>
                </div>
                <div class="inputs-container">
                    <select name="category" class="selectCat"> 
                        <option disabled selected value="-1">Select Category</option>
                        <?php
                            $catData= getCategoriesData("","");
                            foreach($catData as $cat){
                                ?>
                                <option value="<?php echo $cat['categoryId']?>" <?php if($movieData['category']==$cat['categoryId']){echo "selected";}?> ><?php echo $cat['categoryName'] ?></option>
                            <?php
                            }
                        ?>
                    </select> <span class="required">*</span>
                    <select name="movieCreator" class="selectCat"> 
                        <option disabled selected value="-1">Select Creator</option>
                        <?php
                            $userData= getUserData("WHERE userType = 1");
                            foreach($userData as $user){
                                ?>
                                <option value="<?php echo $user['uid']?>" <?php if($movieData['movieCreator']==$user['uid']){echo "selected";}?> ><?php echo $user['userName'] ?></option>
                            <?php
                            }
                        ?>
                    </select> <span class="required">*</span>
                </div>
                <input type="hidden" name="movieId" value="<?php echo $movieData['movieId'] ?>"/>
                <button type="submit" name="submit">Update Movie</button>
            </form>
        </div>
      
    <?php
    }elseif($page==='update'){
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            redirectUser("Your not authorized to enter this page", "errord");
        }
        //To store error messages
        $formsError= array();
        $movieId= $_POST['movieId'];
        $movieName= filter_var($_POST['movieName'], FILTER_SANITIZE_STRING);
        $movieDesc= strtolower(ltrim(filter_var($_POST['movieDesc'], FILTER_SANITIZE_STRING)));
        $movieDuration= filter_var($_POST['movieDuration'], FILTER_SANITIZE_STRING);
        $movieStatus= $_POST['movieStatus'];
        $ratingGuide= $_POST['ratingGuide'];
        $category= $_POST['category'];
        $movieCreator= $_POST['movieCreator'];

        //To check wheteher [:] is exist or not;
        $movieDuration= explode(":", $movieDuration);
        
       
        if(count($movieDuration)<3){
            array_push($formsError, "error in writeing duration you may forgot [:]");
        }else{
            $movieDuration= implode(":", $movieDuration);
        }
 

        if(empty($movieName)){
            array_push($formsError, "Movie name can't be empty");
        }
        if(empty($movieDesc)){
            array_push($formsError, "Movie description can't be empty");
        }
        if($movieStatus < 0){
            array_push($formsError, "Movie status can't be empty");
        }
            
        if($ratingGuide < 0){
            array_push($formsError, "Movie rating guide can't be empty");
        }

        if($category < 0){
            array_push($formsError, "Movie category can't be empty");
        }

        if($movieCreator < 0){
            array_push($formsError, "Movie creator can't be empty");
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

        $response= findMovieByIdAndUpdate($movieName, $movieDesc, $movieDuration,$movieStatus, $ratingGuide ,$category, $movieCreator, $movieId);
        

        if($response<0){
            //If < 0  means user is exist
            redirectUser("Movie is already exist", "errord", "back");
        }elseif($response==0){
            // if ==0 means user not created successfully and there is an error
            redirectUser("Movie NOT updated successfully", "errord");
        }else{
            // means everything is correct
            redirectUser("Movie updated successfully", "success");
        }
        ?>
    <?php
    }elseif($page==='delete'){
        //If user enters the page without any data
       
        $movieId= isset($_GET['mid']) && is_numeric($_GET['mid']) ? intval($_GET['mid']) : 0;

        $response= findMovieByIdAndDelete($movieId);
            
    
        if($response<=0){
             redirectUser("Movie NOT deleted successfully", "errord", "back");
         }else{
             redirectUser("Movie Deleted successfully", "success");
         }

        ?>
    <?php
    }elseif($page==='approve'){
        
        $movieId= isset($_GET['mid']) && is_numeric($_GET['mid']) ? intval($_GET['mid']) : 0;
        
        $response= findMovieByIdAndApprove($movieId);
            
    
        if($response<=0){
             redirectUser("Movie NOT approved successfully","errord" ,"back");
         }else{
             redirectUser("Movie approved successfully", "success");
         }

    }else{
        header("Location:users.php");
    }






    include "../reusable/footer.php";

    ob_end_flush();
?>


