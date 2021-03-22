<?php

    $dsn= 'mysql:host=remotemysql.com;dbname=UO0BJ5FPtR';
    $user= 'UO0BJ5FPtR';
    $password= '2As2gAwxhG';
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try{
        $con= new PDO($dsn, $user, $password, $option);
        $con->setAttribute(PDO::ATTR_AUTOCOMMIT, PDO::ERRMODE_EXCEPTION);
        
    }catch(PDOException $err){
        echo "Failed to connect to DB " . $err->getMessage();
    }
