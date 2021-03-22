<?php

ob_start();
session_start();
$navbar= true;
$showLogo= false;
$pageTitle= "Categories";
$page="category";
include "../helper/init.php";

$action= isset($_GET['action'])? $_GET['action'] : 'view';
$categoryId= $_GET['catId'];

$movies= getMoviesData(",users.userName, categories.categoryName, categories.categoryAdmin", "INNER JOIN users ON users.uid = movies.movieCreator INNER JOIN categories ON categories.categoryId = movies.category WHERE movies.category= $categoryId ");
$category= getCategoriesData(", users.userName", "INNER JOIN users ON users.uid = categories.categoryAdmin WHERE categories.categoryId= $categoryId ");

if($action=='view'){
    ?>
     <small class="admin-name">Mange by: <?php echo $category[0]['userName'] ?> </small>
    <div class="close-drawer">
   
    <div class="content">
    <?php
    foreach($movies as $movie){
        ?> 
        <div class="movie">
            <img src="../helper/imgs/<?php echo $movie['moviePoster'] ?>" class="img-cat" width="<?php if(count($movies)>3){echo "55%";}else{echo "10%"; } ?>" height="1%" />
            <div class="movie-detail">
                <h1><a href="?action=detail&mid=<?php echo $movie['movieId']?>"><?php echo $movie['movieName']?></a></h1>
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
            
        </div>
     <?php
        }
           
           ?>
       
    </div>
   
</div>
<?php
}elseif($action=='detail'){
    
    $movieId= isset($_GET['mid']) && is_numeric($_GET['mid']) ? intval($_GET['mid']) : 0;

    $movieData = findMovieById($movieId);
    ?>

    <div class="close-drawer">
   
    <div class="movie-detail-container">
        <div class="movie-data">
            <div class="poster-container">
                <a href="<?php echo $movieData['movieTrailer']?>"  target='_blank'  > <img src="../helper/imgs/<?php echo $movieData['moviePoster'] ?>" /></a>
                <a href="<?php echo $movieData['movieTrailer']?>"  target='_blank' ><i class="fas fa-play fa-5x large play-btn"></i></a>
            </div>
            <div class="movie-detail">
                <h1><?php echo $movieData['movieName']?></h1>
                <p><?php echo $movieData['movieDesc']?></p>
                <div class="rating-guide">
                    <span><?php echo $movieData['movieDuration']?></span>
                    <span>
                        <?php
                        if($movieData['ratingGuide']==0){
                            echo "G";
                        }elseif($movieData['ratingGuide']==1){
                            echo "PG";
                        }elseif($movieData['ratingGuide']==2){
                            echo "PG-13";
                        }elseif($movieData['ratingGuide']==3){
                            echo "R";
                        }elseif($movieData['ratingGuide']==4){
                            echo "NC-17";
                        }
                        
                        ?>

                    </span>
                    <div class="rating">
                        <?php
                        for($i=1; $i<=$movieData['rating']; $i++){
                            ?>
                            <span><i class="fas fa-star fa-3x"></i></span>
                        <?php    
                        }
                        
                        ?>
                    </div>
                </div>
                
            </div>
            
        </div>
       
    </div>
   
</div>

<?php
}

?>







<?php

include "../reusable/footer.php";

?>