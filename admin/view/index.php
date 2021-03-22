<?php

    
    ob_start();

    session_start();

    $pageTitle= "Admin login";
    $navbar= false;

    include "../helper/init.php";
    include "../controller/userController.php";


    //To check whether user is logged in or not.
    //If user is logged in he will be directed to dashboard page
    if(isset($_SESSION['userName'])){
        header("Location:dashboard.php");
    }


?>
    <div class="body-container">
        <div class="form-outer-container">
            <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" class="form-inner-container">
                <h2>Mange All Contents</h2>
                <h3>Movies, Tv shows, and more.</h3>
                <div class="inputs-container">
                    <input type="email" name="userEmail" placeholder="Email"/>
                    <input type="password" name="userPassword" placeholder="Password"/>
                    <button type="submit" name="submit">Sign in</button>
                </div>
                <?php


                //If the page is POST we will check from database if user is exist or not
                if($_SERVER['REQUEST_METHOD']==='POST'){
                    $userEmail= filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
                    $userPassword= $_POST['userPassword'];

                    //The function from controller
                    $result = signInHandler($userEmail, $userPassword);

                    if(empty($result)){
                        $msg= "User not found! please try agin";
                        redirectUser($msg);
                    }else{
                        $_SESSION['userName']= $result['userName'];
                        $_SESSION['uid']= $result['uid'];
                        header("Location:dashboard.php");
                    }
                }


                ?>
            </form>
        </div>
    </div>







<?php


    include "../reusable/footer.php";

    ob_end_flush();
?>