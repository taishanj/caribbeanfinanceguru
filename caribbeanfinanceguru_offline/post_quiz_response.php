<?php
session_start();
require_once(dirname(__FILE__) . '/db_connection/dbconn.php');
/*Successfully adds lines to DB but <p> element causes problem*/
$replaceable = ["Over","%"];
$replacement = ["",""];
    //var_dump($test);
   if(isset($_POST['fin_health_resp_ip_addr']))
   {
      $_SESSION['user_ip'] = $_POST['fin_health_resp_ip_addr'];
      $fin_health_resp_ip_addr = $_POST['fin_health_resp_ip_addr'];
      $fin_health_resp_gender = ($_POST['fin_health_resp_gender'] == 'male') ? 'M':'F';
      $fin_health_resp_age = str_replace("Over ","",$_POST['fin_health_resp_age']);
      $fin_health_resp_getapi_country = $_POST['fin_health_resp_getapi_country'];
      $fin_health_resp_country = $_POST['fin_health_resp_country'];
      $fin_health_resp_married =($_POST['fin_health_resp_married'] == 'yes') ? 'M' : 'S';
      $fin_health_resp_children_count =  ($_POST['fin_health_resp_children_count'] == "no children or dependents" || $_POST['fin_health_resp_children_count'] == "none") ? 0 : $_POST['fin_health_resp_children_count'];
      $fin_health_resp_youngest = ($_POST['fin_health_resp_youngest'] == "no children or dependents" || $_POST['fin_health_resp_youngest'] == "none") ? 0 : str_replace("Over ","",$_POST['fin_health_resp_youngest']);
      $fin_health_resp_profession = $_POST['fin_health_resp_profession'];
      $fin_health_resp_profession_time = str_replace("Over","",$_POST['fin_health_resp_profession_time']);
      $fin_health_resp_salary = str_replace("Over $","",$_POST['fin_health_resp_salary']);
      $fin_health_resp_other_income =($_POST['fin_health_resp_other_income'] == "none") ? 0 : str_replace("Over $","",$_POST['fin_health_resp_other_income']);
      $fin_health_resp_mortgage =  ($_POST['fin_health_resp_mortgage'] == "none") ? 0 : str_replace("Over $","",$_POST['fin_health_resp_mortgage']);
      $fin_health_resp_savings = str_replace("Over $","",$_POST['fin_health_resp_savings']);
      $fin_health_resp_investment_ratio = ($_POST['fin_health_resp_investment_ratio']  == "none") ? 0 : str_replace($replaceable,$replacement,$_POST['fin_health_resp_investment_ratio']);
      $fin_health_resp_credit_card_debt  = ($_POST['fin_health_resp_credit_card_debt'] == "none") ? 0 : str_replace("Over $","",$_POST['fin_health_resp_credit_card_debt']);
      $fin_health_resp_other_debt = ($_POST['fin_health_resp_other_debt'] == "none") ? 0 : str_replace("Over $","",$_POST['fin_health_resp_other_debt']);
      $fin_health_resp_insurance  = ($_POST['fin_health_resp_insurance'] == "none")  ? 0 : str_replace("Over $","",$_POST['fin_health_resp_insurance']);

      //special
      $fin_health_resp_investment_ratio = str_replace("%","",$fin_health_resp_investment_ratio);
      //Is new user?
      $fin_health_resp_user_check = $conn->prepare("SELECT fin_health_resp_ip_addr FROM fin_health_test_resp WHERE fin_health_resp_ip_addr='$fin_health_resp_ip_addr'");
      $fin_health_resp_user_check->execute();
      $fin_health_resp_user_check_result = $fin_health_resp_user_check->rowCount();

      //If IP address already exists in database
      if($fin_health_resp_user_check_result)
      {
         //PDO update site visit count based on IP address (Unregistered users)
         $sql_update =
          "UPDATE fin_health_test_resp
             SET fin_health_resp_gender = '$fin_health_resp_gender',
                 fin_health_resp_age = '$fin_health_resp_age',
                 fin_health_resp_getapi_country = '$fin_health_resp_getapi_country',
                 fin_health_resp_country = '$fin_health_resp_country',
                 fin_health_resp_married = '$fin_health_resp_married',
                 fin_health_resp_children_count = '$fin_health_resp_children_count',
                 fin_health_resp_youngest = '$fin_health_resp_youngest',
                 fin_health_resp_profession = '$fin_health_resp_profession',
                 fin_health_resp_profession_time = '$fin_health_resp_profession_time',
                 fin_health_resp_salary = '$fin_health_resp_salary',
                 fin_health_resp_other_income = '$fin_health_resp_other_income',
                 fin_health_resp_mortgage  = '$fin_health_resp_mortgage',
                 fin_health_resp_savings = '$fin_health_resp_savings',
                 fin_health_resp_investment_ratio = '$fin_health_resp_investment_ratio',
                 fin_health_resp_credit_card_debt = '$fin_health_resp_credit_card_debt',
                 fin_health_resp_other_debt = '$fin_health_resp_other_debt',
                 fin_health_resp_insurance = '$fin_health_resp_insurance'
            WHERE fin_health_resp_ip_addr = '$fin_health_resp_ip_addr'";
         $sql_update_stmt = $conn->prepare($sql_update);
         $sql_update_stmt->execute();
      }//end inner if
      else{

         $sql_insert = "INSERT INTO fin_health_test_resp
                           (
                             fin_health_resp_ip_addr,
                             fin_health_resp_gender,
                             fin_health_resp_age,
                             fin_health_resp_getapi_country,
                             fin_health_resp_country,
                             fin_health_resp_married,
                             fin_health_resp_children_count,
                             fin_health_resp_youngest,
                             fin_health_resp_profession,
                             fin_health_resp_profession_time,
                             fin_health_resp_salary,
                             fin_health_resp_other_income,
                             fin_health_resp_mortgage,
                             fin_health_resp_savings,
                             fin_health_resp_investment_ratio,
                             fin_health_resp_credit_card_debt,
                             fin_health_resp_other_debt,
                             fin_health_resp_insurance
                           )
                           VALUES
                           (
                             '$fin_health_resp_ip_addr',
                             '$fin_health_resp_gender',
                             '$fin_health_resp_age',
                             '$fin_health_resp_getapi_country',
                             '$fin_health_resp_country',
                             '$fin_health_resp_married',
                             '$fin_health_resp_children_count',
                             '$fin_health_resp_youngest',
                             '$fin_health_resp_profession',
                             '$fin_health_resp_profession_time',
                             '$fin_health_resp_salary',
                             '$fin_health_resp_other_income',
                             '$fin_health_resp_mortgage',
                             '$fin_health_resp_savings',
                             '$fin_health_resp_investment_ratio',
                             '$fin_health_resp_credit_card_debt',
                             '$fin_health_resp_other_debt',
                             '$fin_health_resp_insurance'
                           )";

         $result = $conn->exec($sql_insert);
      }//end else
}//end outer if
 $conn = null;
 header('Location: finanalysis.php');exit();
 ?>
