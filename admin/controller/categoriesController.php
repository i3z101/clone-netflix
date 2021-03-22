<?php

if(isset($mode) && $mode=='user'){
    include "../admin/model/categories.php";
}else{
    include "../model/categories.php";
}




//To create a new category
function createCategory($categoryName, $categoryDesc, $categoryStatus, $categoryAdmin){
    $category= new Category($categoryName, $categoryDesc, $categoryStatus, $categoryAdmin);
    $checkCategory= $category->checkExistCategory();
    if($checkCategory > 0){
        return -1;
    }else{
        return $category->createCategory();
    }
}

//To get categories records [FOR ADMIN ONLY]
function getCatCount(){
    return Category::getCatRecords();
}

 //To get all categories fields [FOR ADMIN ONLY]
 function getCategoriesData($extraInfo,$query){
     return Category::getCategoriesData($extraInfo,$query);
 }

 //To get category field By ID [FOR ADMIN ONLY]
 function findCategoryById($categoryId){
     return Category::findCategoryById($categoryId);
 }

 //To get category field By ID and update it [FOR ADMIN ONLY] 
 function findCategoryByIdAndUpdate($categoryName, $categoryDesc, $categoryStatus, $categoryAdmin, $categoryId){
     return Category::findCategoryByIdAndUpdate($categoryName, $categoryDesc, $categoryStatus, $categoryAdmin,$categoryId);
 }

  //To get category field By ID and delete it [FOR ADMIN ONLY] 
  function findCategoryByIdAndDelete($categoryId){
      return Category::findCategoryByIdAndDelete($categoryId);
  }

?>