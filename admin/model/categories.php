<?php

include "../helper/DBConfig.php";

class Category {
    public $categoryId= null;
    public $categoryName;
    public $categoryDesc;
    public $categoryStatus;
    public $categoryAdmin;

    //Initiate a category
    public function __construct($categoryName, $categoryDesc, $categoryStatus, $categoryAdmin)
    {
        $this->categoryName= $categoryName;
        $this->categoryDesc= $categoryDesc;
        $this->categoryStatus= $categoryStatus;
        $this->categoryAdmin= $categoryAdmin;
    }
    

    //To create a new category field
    public function createCategory(){
        global $con;
        $queryCat= $con->prepare("INSERT INTO categories (categoryName, categoryDesc, categoryStatus, addDate ,categoryAdmin) VALUES ('$this->categoryName', '$this->categoryDesc', '$this->categoryStatus', now() ,'$this->categoryAdmin')");
        $queryCat->execute();
        $result= $queryCat->rowCount();
        return $result;
    }


     //To check if category is exist or not
     public function checkExistCategory(){
         global $con;
         $categoryName= $this->categoryName;
         $queryCat= $con->prepare("SELECT categoryName from categories WHERE categoryName = '$categoryName' ");
         $queryCat->execute();
         $result= $queryCat->rowCount();
         return $result;
     }

    //To get categories records [FOR ADMIN ONLY]
    public static function getCatRecords(){
        global $con;
        $queryCat= $con->prepare("SELECT categoryId FROM categories");
        $queryCat->execute();
        $result= $queryCat->rowCount();
        return $result;
    }

    //To get all categories fields [FOR ADMIN ONLY]
    public static function getCategoriesData($extraInfo, $query){
        global $con;
        $queryCat= $con->prepare("SELECT categories.* $extraInfo FROM categories $query");
        $queryCat->execute();
        $result= $queryCat->fetchAll();
        return $result;
    }

    //To get category field By ID [FOR ADMIN ONLY]
    public static function findCategoryById($categoryId){
        global $con;
        $queryCat= $con->prepare("SELECT categories.*, users.uid, users.userName FROM categories INNER JOIN users ON users.uid = categories.categoryAdmin WHERE categoryId= '$categoryId'");
        $queryCat->execute();
        $result= $queryCat->fetch();
        return $result;
    }

     //To get category field By ID and update it [FOR ADMIN ONLY] 
    public static function findCategoryByIdAndUpdate($categoryName, $categoryDesc, $categoryStatus, $categoryAdmin, $categoryId){
        global $con;
        $queryCat= $con->prepare("UPDATE categories SET categoryName= '$categoryName', categoryDesc= '$categoryDesc', categoryStatus= '$categoryStatus' , categoryAdmin= '$categoryAdmin' WHERE categoryId = '$categoryId' ");
        $queryCat->execute();
        $result= $queryCat->rowCount();
        return $result;
    }

     //To get category field By ID and delete it [FOR ADMIN ONLY] 
    public static function findCategoryByIdAndDelete($categoryId){
        global $con;
        $queryCat= $con->prepare("DELETE FROM categories WHERE categoryId = '$categoryId' ");
        $queryCat->execute();
        $result= $queryCat->rowCount();
        return $result;
    }


}





?>