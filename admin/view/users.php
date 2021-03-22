<?php



ob_start();
    session_start();

    $pageTitle= "members";
    $navbar= true;

    include "../helper/init.php";
    include "../controller/userController.php";

    $page= isset($_GET['page']) && !is_numeric($_GET['page']) ? $_GET['page'] : 'manage';


    if($page==='manage'){
        $userData= getUserData("WHERE userType !=2 ");
        ?>
        <div class="manage-container">
            <div class="title-container">
                <span class="title">Users</span>
                <span><a href="?page=add">Add More!</a></span>
            </div>
            <?php
                if(empty($userData)){
                    ?>
                    <h1 style="text-align: center;" >No more users start <a href="?page=add">Adding</a></h1>
                <?php
                }else{
                    ?>
                    <div class="grid-users">
                        <?php
                        foreach($userData as $user){
                            ?> 
                            <div class="user-container">
                                
                                <div class="user-inner-container">
                                    <div class="flex id-birthday">
                                        <div>
                                            <small>ID</small>
                                            <p class="uid"><?php echo $user['uid'] ?> </p>
                                        </div>
                                        <div>
                                            <small>Birthday</small>
                                            <p class="bd"><?php echo $user['userBirthDay'] ?></p>
                                        </div>
                                    </div>
                                    <div class="flex name-email">
                                        <div>
                                            <small>Uname</small>
                                            <p class="name"><?php echo $user['userName'] ?></p>
                                        </div>
                                        <div>
                                            <small>Email</small>
                                            <p class="email"><?php echo $user['userEmail'] ?></p>
                                        </div>
                                    </div>
                                    <div class="flex phone-regDate">
                                        <div>
                                            <small>Phone</small>
                                            <p class="phone"><?php echo $user['phoneNumber'] ?></p>
                                        </div>
                                        <div>
                                            <small>Reg date</small>
                                            <p class="reg"><?php echo $user['regDate'] ?></p>
                                        </div>
                                    </div>
                                    <div class="type">
                                    <?php 
                                    if($user['userType']==0){
                                        echo "<p> Regular </p>";
                                    }elseif($user['userType']==1){
                                        echo "<p> Movie Creator </p>";
                                    }
                                    ?>
                                    </div>
                                </div>
                                <div class="edit-delete">
                                    <a class="edit" href="?page=edit&uid=<?php echo $user['uid'] ?>"><i class="fas fa-edit"></i> Edit</a>
                                        
                                    <a class="delete" name="users" title="<?php echo $user['userName'] ?>" href="?page=delete&uid=<?php echo $user['uid'] ?>"><i class="fas fa-times"></i> Delete</a>
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
                <div class="inputs-container">
                    <input type="email" name="userEmail" required placeholder="Email"/><span class="required">*</span>
                    <input type="password" name="userPassword" required placeholder="Password"/><span class="required">*</span>
                </div>
                <div class="inputs-container">
                    <input type="text" name="userName" placeholder="Username"/><span class="required">*</span>
                    <select name="userType"> 
                        <option disabled selected value="-1">Select type</option>
                        <option value="0">Regular</option>
                        <option value="1">Movie creator</option>
                        <option value="2">Admin</option>
                    </select> <span class="required">*</span>
                </div>
                <div class="inputs-container">
                    <input type="text" pattern="[0-9]{10}" name="phoneNumber" required placeholder="Phone number"/><span class="required">*</span>
                    <label>Date of birth</label>
                    <input type="date" name="userBirthDay" required placeholder="Birthday"/><span class="required">*</span>
                </div>
                <button type="submit" name="submit">Register user</button>
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
        $userEmail= trim(filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL));
        $userPassword= trim(sha1($_POST['userPassword']));
        $userName= strtolower(trim(filter_var($_POST['userName'], FILTER_SANITIZE_STRING)));
        $userType= $_POST['userType'];
        $phoneNumber= trim(filter_var($_POST['phoneNumber'], FILTER_SANITIZE_STRING));
        $userBirthDay=  $_POST['userBirthDay'];

        // print_r( $hhh);

        if(empty($userEmail)){
            array_push($formsError, "Email can't be empty");
        }
        if(empty($userPassword)){
            array_push($formsError, "Password can't be empty");
        }
        if(empty($userName)){
            array_push($formsError, "User name can't be empty");
        }
        if(strlen($userName) < 3){
            array_push($formsError, "User name can't be less than 4 characters");
        }
            
        if(empty($phoneNumber)){
            array_push($formsError, "Phone number can't be empty");
        }
        if(empty($userBirthDay)){
            array_push($formsError, "Birthday can't be empty");
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

        $response= createUser($userName, $userEmail, $userPassword, $phoneNumber,$userType, 0 ,$userBirthDay);
        

        if($response<0){
            //If < 0  means user is exist
            redirectUser("User is already registered", "errord", "back");
        }elseif($response==0){
            // if ==0 means user not created successfully and there is an error
            redirectUser("User NOT created successfully", "errord");
        }else{
            // means everything is correct
            redirectUser("User created successfully", "success");
        }


        ?>
    <?php
    }elseif($page==='edit'){
        
        $uid= isset($_GET['uid']) && is_numeric($_GET['uid']) ? intval($_GET['uid']) : 0;

        $userData = findUserById($uid);

        if(empty($userData)){
            redirectUser("User not found!", "errord");
        }   

        ?>
        <div class="container-form">
            <form action="<?php $_SERVER['PHP_SELF']?>?page=update" method="POST" class="form-inner-container">
                <div class="inputs-container">
                    <input type="email" name="userEmail" value="<?php echo $userData['userEmail'] ?>" required placeholder="Email"/><span class="required">*</span>
                    <input type="password" name="userNewPassword" placeholder="Password"/><span style="color: white;" >*</span>
                    <input type="password" hidden value="<?php echo $userData['userPassword'] ?>" name="userOldPassword" required placeholder="Password"/>
                </div>
                <div class="inputs-container">
                    <input type="text" name="userName" value="<?php echo $userData['userName'] ?>" placeholder="Username"/><span class="required">*</span>
                    <select name="userType"> 
                        <option disabled value="-1">Select type</option>
                        <option value="0" <?php if($userData['userType']==0){echo "selected";} ?>>Regular</option>
                        <option value="1" <?php if($userData['userType']==1){echo "selected";} ?>>Movie creator</option>
                        <option value="2" <?php if($userData['userType']==2){echo "selected";} ?> >Admin</option>
                    </select> <span class="required">*</span>
                </div>
                <div class="inputs-container">
                    <input type="text" pattern="[0-9]{10}" value="0<?php echo $userData['phoneNumber'] ?>" name="phoneNumber" required placeholder="Phone number"/><span class="required">*</span>
                    <label>Date of birth</label>
                    <input type="date" name="userBirthDay" value="<?php echo $userData['userBirthDay'] ?>" required placeholder="Birthday"/><span class="required">*</span>
                </div>
                <div class="inputs-container">
                    <input type="text" name="userName" placeholder="Username"/><span class="required">*</span>
                    <select name="accountType" required> 
                        <option disabled selected value="-1">Select Account type</option>
                        <option value="0"  <?php if($userData['accountType']==0){echo "selected";} ?> >Basic</option>
                        <option value="1" <?php if($userData['accountType']==1){echo "selected";} ?>  >Standard</option>
                        <option value="2" <?php if($userData['accountType']==3){echo "selected";} ?>  >Premium</option>
                    </select> <span class="required">*</span>
                </div>
                <input type="hidden" name="uid"  value="<?php echo $userData['uid'] ?>"/>
                <button type="submit" name="submit">Register user</button>
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
            $uid= $_POST['uid'];
            $userEmail= trim(filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL));
            $userOldPassword= trim($_POST['userOldPassword']);
            $userNewPassword= trim($_POST['userNewPassword']);
            $userName= strtolower(trim(filter_var($_POST['userName'], FILTER_SANITIZE_STRING)));
            $userType= $_POST['userType'];
            $phoneNumber= trim(filter_var($_POST['phoneNumber'], FILTER_SANITIZE_STRING));
            $userBirthDay=  $_POST['userBirthDay'];
            $accountType= $_POST['accountType'];
            $password= null;

            if(empty($userNewPassword)){
                $password= $userOldPassword;
            }else{
                $password= sha1($userNewPassword);
            }
    
    
            if(empty($userEmail)){
                array_push($formsError, "Email can't be empty");
            }
            if(empty($password)){
                array_push($formsError, "Password can't be empty");
            }
            if(empty($userName)){
                array_push($formsError, "User name can't be empty");
            }
            if(strlen($userName) < 3){
                array_push($formsError, "User name can't be less than 4 characters");
            }
                
            if(empty($phoneNumber)){
                array_push($formsError, "Phone number can't be empty");
            }
            if(empty($userBirthDay)){
                array_push($formsError, "Birthday can't be empty");
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
    
            $response= findUserByIdAndUpdate($userName, $userEmail, $password, $phoneNumber,$userType, $accountType ,$userBirthDay,$uid);
            
    
           if($response<=0){
                // if ==0 means user not created successfully and there is an error
                redirectUser("User NOT updated successfully, You may not edit some fields", "errord", "back");
            }else{
                // means everything is correct
                redirectUser("User updated successfully", "success");
            }
        ?>
    <?php
    }elseif($page==='delete'){
        //If user enters the page without any data
       
        $uid= isset($_GET['uid']) && is_numeric($_GET['uid']) ? intval($_GET['uid']) : 0;

        $response= findUserByIdAndDelete($uid);
            
    
        if($response<=0){
             // if ==0 means user not created successfully and there is an error
             redirectUser("User NOT deleted successfully", "back");
         }else{
             // means everything is correct
             redirectUser("User Deleted successfully", "success");
         }

        ?>
    <?php
    }else{
        header("Location:users.php");
    }






    include "../reusable/footer.php";

    ob_end_flush();
?>


