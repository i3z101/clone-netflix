<?php

$mode= "user";
include "../admin/controller/categoriesController.php";
include "../admin/controller/moviesController.php";

?>

<nav>
    <?php
    if(!isset($showLogo)){
        ?>
        <a href="../view/index.php"><img src="../helper/imgs/netflix-logo.png" width="15%" height="15%"/></a>
    <?php    
    }else{
        ?>
       <i class="fas fa-bars fa-2x menu" style="cursor: pointer;"></i>
    <?php
    }
    ?>
  
    <ul>
    <?php 
    if(isset($_SESSION['uName'])){
        echo "<li>";
            echo $_SESSION['uName'];
        echo "</li>";
    }  
    ?>
    <?php 
        if(isset($_SESSION['uName'])){
            echo "<li>";
                echo '<a href="../view/logout.php">logout</a>';
            echo "</li>";
        }else{
            echo "<li>";
                echo '<a href="../view/auth.php?page=login" class="auth">Sign in</a>';
            echo "</li>";
        }
    ?>
            
    </ul>
</nav>
<div class="drawer">
       
        <ul class="ul">
        <a href="<?php if(!isset($_SESSION['userType'])){echo "../view/home.php";}else{echo "../view/movieCreator.php";} ?>"><img src="../helper/imgs/netflix-logo.png" width="80%" height="80%"/></a>
           <?php
            $categories= getCategoriesData("", "");
            foreach($categories as $category){
                ?>
                <li class="li"><a href="categories.php?catId= <?php echo $category['categoryId'] ?>" class="a"> <?php echo $category['categoryName'] ?> </a></li>
            <?php  
            }
           ?>
        </ul>
</div>
