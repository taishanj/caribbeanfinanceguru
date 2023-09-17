<?php
session_start();
require_once(dirname(__FILE__) . '/db_connection/dbconn.php');
if(isset($_POST['visit_ip_addr']))
{
  $visit_ip_addr=$_POST['visit_ip_addr'];
  $visit_country=$_POST['visit_country'];
  //site visitors to be used to figure out bounce rate
  $site_visitor_check = $conn->prepare("SELECT visit_ip_addr FROM site_visitor WHERE visit_ip_addr='$visit_ip_addr'");
  $site_visitor_check->execute();
  $site_visitor_check_result = $site_visitor_check->rowCount();

  //If IP address already exists in database
  if($site_visitor_check_result)
  {
    //PDO update site visit count based on IP address (Unregistered users)
    $sql_update = "UPDATE site_visitor SET visit_count=visit_count + 1  WHERE visit_ip_addr = '$visit_ip_addr'";
    // Prepare statement
    $sql_update_stmt = $conn->prepare($sql_update);
    // execute the query
    $sql_update_stmt->execute();
  }//end inner if
  else{
    //PDO Php site visitor metadata insert
    $sql_insert = "INSERT INTO site_visitor(visit_ip_addr,visit_country,visit_count)
                    VALUES ('$visit_ip_addr','$visit_country','1')";
    $result = $conn->exec($sql_insert);
  }//end inner else

}//end if
 //End database connection
 $conn = null;

 ?>
