<?php

ob_start();
session_start();
$navbar= true;
$showLogo= false;
$pageTitle= "Home";
$page="home";
include "../helper/init.php";

if(!isset($_SESSION['uName'])){
   header("Location:index.php");
}

if(isset($_SESSION['userType'])){
    header("Location:movieCreator.php");
}

$movies= getMoviesData(",users.userName, categories.categoryName, categories.categoryId ,categories.categoryAdmin", "INNER JOIN users ON users.uid = movies.movieCreator INNER JOIN categories ON categories.categoryId = movies.category");


?>

<div class="close-drawer">
   
    <div class="content">
    <?php
    foreach($movies as $movie){
        ?> 
        <div class="movie">
        <img src="../helper/imgs/<?php echo $movie['moviePoster'] ?>" class="img-home"/>
            <div class="movie-detail">
                <h1><a href="categories.php?action=detail&mid=<?php echo $movie['movieId']?>"><?php echo $movie['movieName']?></a></h1>
                <p><?php echo $movie['movieDesc']?></p>
            </div>
            <p class="cat-link"><a href="categories.php?catId=<?php echo $movie['categoryId']?>"><?php echo $movie['categoryName']?></a></p>
        </div>
     <?php
        }
           
           ?>
       
    </div>
   
</div>





<?php

include "../reusable/footer.php";

?>