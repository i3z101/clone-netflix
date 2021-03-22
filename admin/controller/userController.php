<?php

    //To avoid no such file or directory;
    //mode variable came from auth.php in user mode
    if(isset($mode) && $mode=='user'){
        include "../admin/model/users.php";
    }else{
        include "../model/users.php";
    }

    

    //To create a new user
    function createUser($userName, $userEmail, $userPassword, $phoneNumber,$userType, $accountType ,$userBirthDay){
         $user= new User($userName, $userEmail, $userPassword, $phoneNumber,$userType, $accountType ,$userBirthDay);
         if($accountType > 0){
             $user->accountType= $accountType;
         }
         //To check whether user is exist or not;
         $checked= $user->checkExistUser();
         if($checked>0){
             return -1;
         }else{
            return $user->createUser();
         }
         
    }

    //To sign in [FOR ADMIN ONLY]
    function signInHandler($userEmail, $password){
        $hashedPassword= sha1($password);
        $userData=  User::getAdminByEmail($userEmail, $hashedPassword);
        return $userData;
    }

    function userLogin($data, $password){
        $hashedPassword= sha1($password);
        $userData=  User::userLogin($data, $hashedPassword);
        $user= new User($userData['userName'], $userData['userEmail'],  "","",  $userData['userType'], "");
        $user->userId= $userData['uid'];
        return $user;
    }

    //To get user records [FOR ADMIN ONLY]
    function getUserCount(){
        return User::getUserRecords();
    }

    //To get user data [FOR ADMIN ONLY]
    function getUserData($query){
        return User::getUsersData($query);
    }

    //To get ONLY one user data by ID  [FOR ADMIN ONLY]
    function findUserById($uid){
        return User::findUserById($uid);
    }

    //To get ONLY one user data by ID and update it  [FOR ADMIN ONLY]
    function findUserByIdAndUpdate($userName, $userEmail, $password, $phoneNumber,$userType ,$userBirthDay,$uid){
        return User::findUserByIdAndUpdate($userName, $userEmail, $password, $phoneNumber,$userType ,$userBirthDay,$uid);
    }

    //To get ONLY one user data by ID and delete it [FOR ADMIN ONLY]
    function findUserByIdAndDelete($uid){
        return User::findUserByIdAndDelete($uid);
    }