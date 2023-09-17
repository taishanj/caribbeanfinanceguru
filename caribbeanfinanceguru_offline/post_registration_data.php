<?php
function post_registered_user($user_name, $user_email){

  $host =  "localhost";
  $dbname = "u519725748_financeguru_pr";
  $username = "u519725748_prod_admin";
  $password = "f1n@nc3guRuPr0d";
  
  $conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
  $conn ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  if($user_name  != 'guest' && $user_name != null){
      $visit_user_name = $user_name;
      $visit_user_email = $user_email;
      $visit_datetime = date_default_timezone_get();

      $site_visitor_check = $conn->prepare("SELECT registered_user_name FROM registered_user WHERE registered_user_name ='$user_name'");
      $site_visitor_check->execute();
      $site_visitor_check_result = $site_visitor_check->rowCount();

      //If IP address already exists in database
      if(!$site_visitor_check_result)
      {
        //PDO Php site visitor metadata insert
        $sql_insert = "INSERT INTO registered_user(registered_user_name,registered_user_email,registered_user_register_date)
                        VALUES ('$visit_user_name','$visit_user_email','$visit_datetime')";
        $result = $conn->exec($sql_insert);
      }//end inner if
  }

}//end function post_registered_user
?>
