<?php
ob_start();
session_start();
$navbar= true;
$pageTitle= "Auth";
$page= isset($_GET['page']) ? $_GET['page']: "";
include "../helper/init.php";
$mode= "user";
include "../admin/controller/userController.php";


if($page=='login'){
    ?>


    <div>
        <div class="auth-container">
        <h3>Sign In</h3>
        <form action="<?php $_SERVER['PHP_SELF']?>?page=postlogin" method="POST">
            <input type="text" placeholder="Email or Phone number" name="emailPhone" />
            <input type="password" placeholder="Password" name="password"/>
            <button type="submit">Sign In</button>
            <div class="rem-help">
                <div class="rem">
                    <input  type="checkbox" name="remember" id="remember"/>
                    <span for="remember">Remember me</span>
                </div>
                <div>
                    <span>Need help?</span>
                </div>
            </div>
        </form>
        <div class="second-section-auth">
            <p class="new-to-net">New to Netflix? <a href="index.php">Sign up now</a> </p>
        </div>
        </div>

        <section class="footer-section-auth" >
        <p class="call">Questions? Call <a href="tel:800-850-1262">800-850-1262</a></p>
        <div class="grid-footer">
            <div class="list">
                <p>FAQ</p>
                <p>Cookie Preferences</p>
            </div>
            <div class="list">
                <p>Help Center</p>
                <p>Cooperation Information</p>
            </div>
            <div class="list">
                <p>terms Of Use</p>
            </div>
            <div class="list">
                <p>Privacy</p>
            </div>
        </div>
    </section>
    

    </div>


    </div>
<?php
}elseif($page=='signup'){
    $email= $_POST['email'];
    if(!isset($email)){
        header("Location:index.php");
    }
    ?>
    </div>
    <div class="container-form">
            <form action="<?php $_SERVER['PHP_SELF']?>?page=insert" method="POST" class="form-inner-container">
                <div class="inputs-container">
                    <input type="text" name="userEmail" value="<?php echo $email ?>" required placeholder="Email"/><span class="required">*</span>
                    <input type="password" name="userPassword" required placeholder="Password"/><span class="required">*</span>
                </div>
                <div class="inputs-container">
                    <input type="text" name="userName" placeholder="Username"/><span class="required">*</span>
                    <select name="accountType" required> 
                        <option disabled selected value="-1">Select Account type</option>
                        <option value="0">Basic</option>
                        <option value="1">Standard</option>
                        <option value="2">Premium</option>
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
}elseif($page=='insert'){
    if($_SERVER['REQUEST_METHOD']!=='POST'){
        redirectUser("Enter valid user inputs", "errord");
    }
    $formsError= array();
    $userEmail= trim(filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL));
    $userPassword= trim(sha1($_POST['userPassword']));
    $userName= strtolower(trim(filter_var($_POST['userName'], FILTER_SANITIZE_STRING)));
    $accountType= $_POST['accountType'];
    $phoneNumber= trim(filter_var($_POST['phoneNumber'], FILTER_SANITIZE_STRING));
    $userBirthDay=  $_POST['userBirthDay'];
    $userType= 0;

    // print_r($_POST);

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

    $response= createUser($userName, $userEmail, $userPassword, $phoneNumber,$userType, $accountType ,$userBirthDay);
    

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
}elseif($page=='postlogin'){
    if($_SERVER['REQUEST_METHOD']!=='POST'){
        redirectUser("Enter valid user inputs", "errord");
    }
    $formsError= array();
    $data= '';
    if(is_numeric($_POST['emailPhone'])){
        $data= filter_var($_POST['emailPhone'], FILTER_SANITIZE_NUMBER_INT);
    }else{
        $data= filter_var($_POST['emailPhone'], FILTER_SANITIZE_STRING);
    }
    $password= $_POST['password'];

  
    if(empty($data)){
           array_push($formsError, "Email or Password can't be empty");
       }
       if(empty($password)){
           array_push($formsError, "Password can't be empty");
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
    $response= userLogin($data, $password);
    // print_r($response); 
    

    if(empty($response)){
        redirectUser("No data, please try again", "errord", "back");
    }else{
        $_SESSION['uName']= $response->userName;
        $_SESSION['uid']= $response->userId;
        if($response->userType==1){
            $_SESSION['userType']= $response->userType;
            header("Location:movieCreator.php");
        }else{
            header("Location:home.php");
        }
        
    }

}
?>














<?php

include "../reusable/footer.php";
ob_end_flush();

?>