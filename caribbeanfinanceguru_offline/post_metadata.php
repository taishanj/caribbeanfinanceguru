<?php
session_start();
require_once(dirname(__FILE__) . '/db_connection/dbconn.php');

if(isset($_POST['visit_ip_addr']))
{
  $visit_ip_addr=$_POST['visit_ip_addr'];
  $visit_country=$_POST['visit_country'];
  $visit_user_email = $_POST['visit_user_email'];
  $visit_site_section = $_POST['visit_site_section'];
  $visit_user_name = $_POST['visit_user_name'];
  $_SESSION['visit_user_email'] = $visit_user_email;
  $_SESSION['user_region'] = $visit_country;
  $_SESSION['visit_user_name'] = $visit_user_name;


  $site_visitor_check = $conn->prepare("SELECT visit_ip_addr FROM quiz_visitor WHERE visit_ip_addr ='$visit_ip_addr'");
  $site_visitor_check->execute();
  $site_visitor_check_result = $site_visitor_check->rowCount();

  //If IP address already exists in database
  if(!empty($visit_ip_addr))
  {
    //PDO Php site visitor metadata insert
    $sql_insert = "INSERT INTO quiz_visitor(visit_ip_addr,visit_country,visit_count,visit_site_section,visit_user_name,visit_user_email)
                    VALUES ('$visit_ip_addr','$visit_country','1','$visit_site_section','$visit_user_name','$visit_user_email')";
    $result = $conn->exec($sql_insert);
  }//end inner if
}//end outer if
$conn = null;
 ?>
