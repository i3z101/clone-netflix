<?php

include "../helper/DBConfig.php";

class User {
    public $userId= null;
    public $userName;
    public $userEmail;
    private $userPassword;
    public $userType;
    public $accountType=0;
    public $phoneNumber;
    public $userBirthDay;

    //Initiate a user
    public function __construct($username, $userEmail, $userPassword, $phoneNumber,$userType ,$userBirthDay)
    {
        $this->userName     = $username;
        $this->userEmail    = $userEmail;
        $this->userPassword = $userPassword;
        $this->userType     = $userType;
        $this->phoneNumber  = $phoneNumber;
        $this->userBirthDay = $userBirthDay;
    }

    //Check wether user is exist or not before do some actions
    public function checkExistUser(){
        global $con;
        $email= $this->userEmail;
        $queryUser= $con->prepare("SELECT userEmail FROM users WHERE userEmail= '$email' ");
        $queryUser->execute();
        $result= $queryUser->rowCount();
        return $result;
    }

    //Create a new user
    public function createUser(){
        global $con;
        $queryUser= $con->prepare("INSERT INTO users (userName, userEmail ,userPassword, userType, accountType, phoneNumber, userBirthDay, regDate) VALUES ('$this->userName', '$this->userEmail', '$this->userPassword', '$this->userType', '$this->accountType' , '$this->phoneNumber', '$this->userBirthDay', now())");
        $queryUser->execute();
        $result= $queryUser->rowCount();
        return $result;
    }

    //For regular user sign in 
    public static function userLogin($data, $password){
        global $con;
        if(is_numeric($data)){
            $queryUser= $con->prepare("SELECT * FROM users WHERE  phoneNumber= '$data' AND userPassword = '$password' ");
        }else{
            $queryUser= $con->prepare("SELECT * FROM users WHERE  userEmail= '$data' AND userPassword = '$password' ");
        }
        $queryUser->execute();
        $result= $queryUser->fetch();
        return $result;
    }

    //FOR SIGN IN ADMIN ONLY [FOR ADMIN ONLY]
    public static function getAdminByEmail($email, $password){
        global $con;
        $queryUser= $con->prepare("SELECT * FROM users WHERE userEmail= '$email' AND userPassword = '$password' AND userType= 2 ");
        $queryUser->execute();
        $result= $queryUser->fetch();
        return $result;
    }

    //To get how many records [FOR ADMIN ONLY]
    public static function getUserRecords(){
        global $con;
        $queryUser= $con->prepare("SELECT uid FROM users WHERE userType != 2");
        $queryUser->execute();
        $result= $queryUser->rowCount();
        return $result;
    }

    //To fetch user data [FOR ADMIN ONLY]
    public static function getUsersData($query){
        global $con;
        $queryUser= $con->prepare("SELECT * FROM users $query");
        $queryUser->execute();
        $result= $queryUser->fetchAll();
        return $result;
    }

    public static function findUserById($uid){
        global $con;
        $queryUser= $con->prepare("SELECT * FROM users WHERE uid= '$uid'");
        $queryUser->execute();
        $result= $queryUser->fetch();
        return $result;
    }

    public static function findUserByIdAndUpdate($userName, $userEmail, $password, $phoneNumber,$userType ,$userBirthDay,$uid){
        global $con;
        $queryUser= $con->prepare("UPDATE users SET userName= '$userName', userEmail= '$userEmail', userPassword= '$password', userType='$userType', phoneNumber= '$phoneNumber', userBirthDay='$userBirthDay' WHERE uid= '$uid'");
        $queryUser->execute();
        $result= $queryUser->rowCount();
        return $result;
    }

    public static function findUserByIdAndDelete($uid){
        global $con;
        $queryUser= $con->prepare("DELETE FROM users WHERE uid= '$uid'");
        $queryUser->execute();
        $result= $queryUser->rowCount();
        return $result;
    }
}