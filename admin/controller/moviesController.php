<?php

    if(isset($mode) && $mode=='user'){
        include "../admin/model/movies.php";
    }else{
        include "../model/movies.php";
    }

    //To create a new category
    function createMovie($movieName, $movieDesc, $movieDuration,$movieStatus, $ratingGuide ,$category, $movieCreator,$movieTrialer=null, $moviePoster=null){
        $movie= new Movie($movieName, $movieDesc, $movieDuration,$movieStatus, $ratingGuide ,$category, $movieCreator);
        if($movieTrialer!=null){
            $movie->movieTrialer= $movieTrialer;
        }
        if($moviePoster!=null){
            $movie->moviePoster= $moviePoster;
        }
        $checkMovie= $movie->checkExistMovie();
        if($checkMovie > 0){
            return -1;
        }else{
            return $movie->createMovie();
        }
    }

    //To get movies fields [FOR ADMIN ONLY]
    function getMoviesData($extraInfo, $query){
        return Movie::getMoviesData($extraInfo,$query);
    }

    //To get movies record [FOR ADMIN ONLY]
    function getMoviesCount(){
        return Movie::getMoviesRecords();
    }

    //To get movie data by ID [FOR ADMIN ONLY]
    function findMovieById($movieId){
        return Movie::findMovieById($movieId);
    }

    //to get movie by ID and update it [FOR ADDMIN ONLY]
    function findMovieByIdAndUpdate($movieName, $movieDesc, $movieDuration,$movieStatus, $ratingGuide ,$category, $movieCreator, $movieId, $movieTrailer=null){
        return Movie::findMovieByIdAndUpdate($movieName, $movieDesc, $movieDuration,$movieStatus, $ratingGuide ,$category, $movieCreator, $movieId, $movieTrailer);
    }

    //To get movie field by ID and delete it [FOR ADMIN ONLY]
    function findMovieByIdAndDelete($movieId){
        return Movie::findMovieByIdAndDelete($movieId);
    }

      //To get movie field by ID and approve it [FOR ADMIN ONLY]
    function findMovieByIdAndApprove($movieId){
        return Movie::findMovieByIdAndApprove($movieId);
    }


?> 