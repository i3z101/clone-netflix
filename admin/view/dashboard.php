<?php


ob_start();

session_start();

$pageTitle= "dashboard";
$navbar= true;

include "../helper/init.php";
include "../controller/userController.php";
include "../controller/categoriesController.php";
include "../controller/moviesController.php";


if(!isset($_SESSION['userName'])){
    redirectUser("You are not authorized to enter this page", "errord");
}

// echo "welcome " . $_SESSION['userName'] . " with id " . $_SESSION['uid'] . "";

// echo "<script>setTimeout(()=>{
//     window.location.href='logout.php';
// },500)</script>";

?>

    <div class="outer-container">

        <div class="container container1">
            <p><a href='users.php'>MEMBERS</a></p>
            <p><?php echo getUserCount();?></p>
        </div>

        <div class="container container2">
            <p><a href='categories.php'>CATEGORIES</a></p>
            <p><?php echo getCatCount();?></p>
        </div>

        <div class="container container3">
            <p><a href='movies.php'>MOVIES</a></p>
            <p><?php echo getMoviesCount();?></p>
        </div>


    </div>





<?php


    include "../reusable/footer.php";

    ob_end_flush();
?>


