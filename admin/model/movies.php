<?php

include "../helper/DBConfig.php";


class Movie{
    public $movieId= null;
    public $movieName;
    public $movieDesc;
    public $movieDuration;
    public $movieStatus;
    public $ratingGuide;
    public $addDate;
    public $movieTrialer=null;
    public $moviePoster=null;
    public $category;
    public $movieCreator;


    //Initiate a movie
    public function __construct($movieName, $movieDesc, $movieDuration,$movieStatus, $ratingGuide ,$category, $movieCreator)
    {
        $this->movieName= $movieName;
        $this->movieDesc= $movieDesc;
        $this->movieDuration= $movieDuration;
        $this->movieStatus= $movieStatus;
        $this->ratingGuide= $ratingGuide;
        $this->category= $category;
        $this->movieCreator= $movieCreator;
    }

    //To create a new movie field
    public function createMovie(){
        global $con;
        $queryCat= $con->prepare("INSERT INTO movies (movieName, movieDesc, movieDuration, movieStatus ,ratingGuide, addDate, movieTrailer, moviePoster, category, movieCreator) VALUES ('$this->movieName', '$this->movieDesc', '$this->movieDuration', '$this->movieStatus', '$this->ratingGuide',now(), '$this->movieTrialer', '$this->moviePoster' ,'$this->category', '$this->movieCreator')");
        $queryCat->execute();
        $result= $queryCat->rowCount();
        return $result;
    }


     //To check if category is exist or not
     public function checkExistMovie(){
         global $con;
         $movieName= $this->movieName;
         $queryCat= $con->prepare("SELECT movies from movies WHERE movieName = '$movieName' ");
         $queryCat->execute();
         $result= $queryCat->rowCount();
         return $result;
     }

     //To get movies fields [FOR ADMIN ONLY]
     public static function getMoviesData($extraInfo,$query){
        global $con;
        $queryMov= $con->prepare("SELECT movies.* $extraInfo FROM movies $query");
        $queryMov->execute();
        $result= $queryMov->fetchAll();
        return $result;
     }

    //To get movies records [FOR ADMIN ONLY]
    public static function getMoviesRecords(){ 
        global $con;
        $queryMovie= $con->prepare("SELECT movieId FROM Movies");
        $queryMovie->execute();
        $result= $queryMovie->rowCount();
        return $result;
    }

    //To get movie field By ID [FOR ADMIN ONLY]
    public static function findMovieById($movieId){
        global $con;
        $queryCat= $con->prepare("SELECT movies.*, users.uid, users.userName, categories.categoryId, categories.categoryName FROM movies INNER JOIN users ON users.uid = movies.movieCreator INNER JOIN categories ON categories.categoryId = movies.category WHERE movieId= '$movieId'");
        $queryCat->execute();
        $result= $queryCat->fetch();
        return $result;
    }

    //To get movie field by ID and update it [FOR ADMIN ONLY]
    public static function findMovieByIdAndUpdate($movieName, $movieDesc, $movieDuration,$movieStatus, $ratingGuide ,$category, $movieCreator, $movieId, $movieTrailer=null){
        global $con;
        $queryMov= $con->prepare("UPDATE movies SET movieName= '$movieName', movieDesc= '$movieDesc', movieDuration= '$movieDuration',movieStatus= '$movieStatus', ratingGuide='$ratingGuide', movieTrailer='$movieTrailer' ,category='$category', movieCreator= '$movieCreator' WHERE movieId = '$movieId' ");
        $queryMov->execute();
        $result= $queryMov->rowCount();
        return $result;
    }

    //To get movie field by ID and delete it [FOR ADMIN ONLY]
    public static function findMovieByIdAndDelete($movieId){
        global $con;
        $queryCat= $con->prepare("DELETE FROM movies WHERE movieId = '$movieId' ");
        $queryCat->execute();
        $result= $queryCat->rowCount();
        return $result;
    } 

    //To get movie field by ID and approve it [FOR ADMIN ONLY]
    public static function findMovieByIdAndApprove($movieId){
        global $con;
        $queryCat= $con->prepare("UPDATE movies SET movieStatus = 0 WHERE movieId = '$movieId'");
        $queryCat->execute();
        $result= $queryCat->rowCount();
        return $result;
    }

}

?>