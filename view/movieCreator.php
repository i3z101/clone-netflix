<?php

ob_start();
session_start();
$navbar= true;
$showLogo= false;
$pageTitle= "movie creator";
$page="movie creator";
include "../helper/init.php";

if(!isset($_SESSION['uName'])){
   header("Location:index.php");
}
$uid= $_SESSION['uid'];
$movies= getMoviesData(",users.userName, categories.categoryName, categories.categoryId ,categories.categoryAdmin", "INNER JOIN users ON users.uid = movies.movieCreator INNER JOIN categories ON categories.categoryId = movies.category WHERE users.uid= $uid");

$action= isset($_GET['action']) ? $_GET['action'] : 'manage';

if($action=='manage'){
    ?>
     <small class="admin-name"><a href="?action=add">Add a new movie</a> </small>
    <div class="close-drawer">
   
   <div class="content">
   <?php
   foreach($movies as $movie){
       ?> 
       <div class="movie">
           <img src="../helper/imgs/<?php echo $movie['moviePoster'];?>" width="<?php if(count($movies)>3){echo "55%";}else{echo "10%"; } ?>" height="1%" />
           <div class="movie-detail">
               <h1><?php echo $movie['movieName']?></h1>
               <p><?php echo $movie['movieDesc']?></p>
               <div class="rating-guide">
                   <span><?php echo $movie['movieDuration']?></span>
                   <h3>
                       <?php
                       if($movie['ratingGuide']==0){
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
                       
                       ?>

                   </h3>
               </div>
               
           </div>
           <small class="action"><a href="?action=edit&mid= <?php echo $movie['movieId']?> ">Edit</a></small>
           <small class="action"><a href="?action=delete&mid= <?php echo $movie['movieId']?> ">Delete</a></small>
       </div>
    <?php
       }
          
}elseif($action=='add'){
    ?>
    <!-- Form to create a new user -->
    <div class="container-form">
        <form action="<?php $_SERVER['PHP_SELF']?>?action=insert" method="POST" class="form-inner-container" enctype="multipart/form-data"  >
            <div class="inputs-container cat-movie">
                <input type="text" name="movieName"  placeholder="Movie Name"/><span class="required">*</span>
            </div>
            <div class="inputs-container cat-movie">
                <textarea type="text" name="movieDesc"  placeholder="Movie Description"></textarea><span class="required">*</span>
            </div>
            <div class="inputs-container cat-movie">
                <input type="text" maxlength="8" name="movieDuration" id="duration" required placeholder="Movie duration hh:mm:ss:"/><span class="required">*</span>
            </div>
            <div class="inputs-container cat-movie">
                <input type="text" name="movieTrailer"  required placeholder="Movie Trialer URL"/><span class="required">*</span>
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
                 <input type="file" accept=".png, .jpg, .jpeg" name="poster" /> </select> <span class="required">*</span>
            </div>
            <button type="submit" name="submit">Add Movie</button>
        </form>
    </div>
<?php
}elseif($action=='insert'){
    if($_SERVER['REQUEST_METHOD']!='POST'){
        redirectUser("You are not authorized", "errord");
    }
      //To store error messages
      $formsError= array();
      $movieName= filter_var($_POST['movieName'], FILTER_SANITIZE_STRING);
      $movieDesc= strtolower(ltrim(filter_var($_POST['movieDesc'], FILTER_SANITIZE_STRING)));
      $movieDuration= filter_var($_POST['movieDuration'], FILTER_SANITIZE_STRING);
      $movieStatus= $_POST['movieStatus'];
      $ratingGuide= $_POST['ratingGuide'];
      $category= $_POST['category'];
      $movieCreator= $_SESSION['uid'];
      $movieTrailer= $_POST['movieTrailer'];
      $poster= $_FILES['poster'];
      $posterName= $poster['name'];
      $posterTmpName= $poster['tmp_name'];
      //To check wheteher [:] is exist or not;
      $movieDuration= explode(":", $movieDuration);
      $posterFinalName= rand(0, 1000000) . "_" . $posterName;
     
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

 
      move_uploaded_file($posterTmpName, '..\helper\imgs\\'. $posterFinalName);

      $response= createMovie($movieName, $movieDesc, $movieDuration,$movieStatus, $ratingGuide ,$category, $movieCreator, $movieTrailer, $posterFinalName);
    //   print_r($response);

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

}elseif($action=='edit'){
    $movieId= isset($_GET['mid']) && is_numeric($_GET['mid']) ? intval($_GET['mid']) : 0;

    $movieData = findMovieById($movieId);

    if(empty($movieData)){
        redirectUser("Movie not found!", "errord", "back");
    } 
    if(empty($movieData)){
        redirectUser("Movie not found!", "errord", "back");
    }     
    ?>
    <div class="container-form">
        <form action="<?php $_SERVER['PHP_SELF']?>?action=update" method="POST" class="form-inner-container" enctype="multipart/form-data">
            <div class="inputs-container cat-movie">
                <input type="text" name="movieName" value="<?php echo $movieData['movieName'] ?>"  placeholder="Movie Name"/><span class="required">*</span>
            </div>
            <div class="inputs-container cat-movie">
                <textarea type="text" name="movieDesc"  placeholder="Movie Description"><?php echo ltrim($movieData['movieDesc']) ?></textarea><span class="required">*</span>
            </div>
            <div class="inputs-container cat-movie">
                <input type="text" maxlength="8" value="<?php echo $movieData['movieDuration'] ?>" name="movieDuration" id="duration" required placeholder="Movie duration hh:mm:ss:"/><span class="required">*</span>
            </div>
            <div class="inputs-container cat-movie">
                <input type="text" name="movieTrailer" value="<?php echo $movieData['movieTrailer'] ?>" required placeholder="Movie Trialer URL"/><span class="required">*</span>
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
            </div>
            <input type="hidden" name="movieId" value="<?php echo $movieData['movieId'] ?>"/>
            <button type="submit" name="submit">Update Movie</button>
        </form>
    </div>
  
<?php
}elseif($action=='update'){
    if($_SERVER['REQUEST_METHOD']!='POST'){
        redirectUser("You are not authorized", "errord");
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
     $movieCreator= $_SESSION['uid'];
     $movieTrailer= $_POST['movieTrailer'];

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

     $response= findMovieByIdAndUpdate($movieName, $movieDesc, $movieDuration,$movieStatus, $ratingGuide ,$category, $movieCreator, $movieId, $movieTrailer);
     

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
}elseif($action==='delete'){
    //If user enters the page without any data
   
    $movieId= isset($_GET['mid']) && is_numeric($_GET['mid']) ? intval($_GET['mid']) : 0;

    $response= findMovieByIdAndDelete($movieId);
        

    if($response<=0){
         redirectUser("Movie NOT deleted successfully", "errord", "back");
     }else{
         redirectUser("Movie Deleted successfully", "success", "back");
     }

    ?>
<?php
}else{
    header("Location:users.php");
}




include "../reusable/footer.php";

?>