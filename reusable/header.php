
<?php

ob_start();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getPageTitle()?></title>
    <link rel="stylesheet" href="../helper/css/main.css?<?php echo time()?>">
    <link rel="stylesheet" href="../admin/helper/css/main.css?<?php echo time()?>">
    <link rel="stylesheet" href="../helper/css/dashboard.css?<?php echo time()?>">
    <link rel="stylesheet" href="../helper/css/navbar.css?<?php echo time()?>">
    <link rel="stylesheet" href="../helper/css/main2.css?<?php echo time()?>">
    <link rel="stylesheet" href="../helper/css/auth.css?<?php echo time()?>">
    <link rel="stylesheet" href="../helper/css/home.css?<?php echo time()?>">
    <link rel="stylesheet" href="../helper/css/single-movie.css?<?php echo time()?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
</head>
<body class="<?php if(isset($_SESSION['uName'])) {echo "body";} ?>">
    <div class="<?php if($page=='index' || $page == 'login'){echo "container";}elseif(!isset($_SESSION['uName'])){echo "signup";} ?>" >    
    
