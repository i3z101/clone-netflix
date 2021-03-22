

<nav>
    <a href="../view/index.php"><img src="../../helper/imgs/netflix-logo.png" width="15%" height="15%"/></a>
    <ul>
    <?php 
    if(isset($_SESSION['userName'])){
        echo "<li>";
            echo $_SESSION['userName'];
        echo "</li>";
    }  
    ?>
        <li>
            <a href="../view/logout.php">logout</a>
        </li>
    </ul>
</nav>