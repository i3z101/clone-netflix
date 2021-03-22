<?php



/**
 * * Get title function
 */

 function getPageTitle(){
     global $pageTitle;
     return $pageTitle;
 }


 /**
  * * function to show error message
  * * Redirect user to a specific page
  */

  function redirectUser($msg, $class= null, $url= null, $sec=3){
      $toPage= 'index.php';
      if($url!==null){
          $toPage= $_SERVER['HTTP_REFERER'];
      }
      echo "<div class= 'error $class'>";
        echo "<p>" . $msg . "</p>";
      echo "</div>";
      header("REFRESH:$sec; URL=$toPage");
      exit();
  }