<?php
//require_once(dirname(__FILE__) . '/db_connection/dbconn.php');
$host =  "localhost";
$dbname = "u519725748_financeguru_pr";
$username = "u519725748_prod_admin";
$password = "f1n@nc3guRuPr0d";

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // sql to create table
  $visitor_sql = "CREATE TABLE IF NOT EXISTS site_visitor (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  visit_ip_addr VARCHAR(30) NOT NULL,
  visit_country VARCHAR(30) NOT NULL,
  visit_count INT(100) NOT NULL,
  visit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

  // sql to create table
  $quiz_visitor_sql = "CREATE TABLE IF NOT EXISTS quiz_visitor (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  visit_ip_addr VARCHAR(30) NOT NULL,
  visit_country VARCHAR(30) NOT NULL,
  visit_count INT(100) NOT NULL,
  visit_site_section VARCHAR(100) NOT NULL,
  visit_user_name VARCHAR(100) NOT NULL,
  visit_user_email VARCHAR(100) NOT NULL,
  visit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

  $tips_sql = "CREATE TABLE IF NOT EXISTS finance_tip(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tip_category VARCHAR(30) NOT NULL,
    tip_dailyquote VARCHAR(255) NOT NULL,
    tip_country VARCHAR(30) NOT NULL,
    tip_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

  $questions_sql = "CREATE TABLE IF NOT EXISTS finance_questions(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fin_quest_order INT (6) NOT NULL,
    fin_quest_quest VARCHAR(255) NOT NULL,
    fin_quest_category VARCHAR(30) NOT NULL,
    fin_quest_skipped INT
  )";

  $question_answers = "CREATE TABLE IF NOT EXISTS finance_question_options(
    id iNT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fin_quest_order INT(6) NOT NULL,
    fin_quest_option_one VARCHAR (100) NOT NULL,
    fin_quest_option_two VARCHAR (100) NOT NULL,
    fin_quest_option_three VARCHAR (100) NOT NULL,
    fin_quest_option_four VARCHAR (100) NOT NULL,
    fin_quest_option_five VARCHAR(100) NOT NULL,
    fin_quest_option_six VARCHAR (100) NOT NULL
    /*fin_quest_order,fin_quest_option_one,fin_quest_option_two, fin_quest_option_three, fin_quest_option_four, fin_quest_option_five, fin_quest_option_six*/
  )";

$question_resp_test_sql = "CREATE TABLE IF NOT EXISTS fin_health_test_resp(
    id INT(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fin_health_resp_ip_addr VARCHAR (50) NOT NULL,
    fin_health_resp_gender	VARCHAR(50) NOT NULL,
    fin_health_resp_age	INT (6) NOT NULL,
    fin_health_resp_getapi_country VARCHAR (50) NOT NULL,
    fin_health_resp_country	VARCHAR (50) NOT NULL,
    fin_health_resp_married VARCHAR(50) NOT NULL,
    fin_health_resp_children_count INT (6) NOT NULL,
    fin_health_resp_youngest INT NOT NULL,
    fin_health_resp_profession VARCHAR(50),
    fin_health_resp_profession_time INT (6) NOT NULL,
    fin_health_resp_salary INT NOT NULL,
    fin_health_resp_other_income INT NOT NULL,
    fin_health_resp_mortgage INT NOT NULL,
    fin_health_resp_savings INT NOT NULL,
    fin_health_resp_investment_ratio INT NOT NULL,
    fin_health_resp_credit_card_debt INT NOT NULL,
    fin_health_resp_other_debt INT NOT NULL,
    fin_health_resp_insurance INT NOT NULL,
    fin_health_resp_update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

  //scheduled routine to update these tables??
  $demographic_data_international = "CREATE TABLE IF NOT EXISTS finance_international_demo_data(
    id INT (50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fin_demo_ip_addr VARCHAR(50) NOT NULL,
    fin_demo_country VARCHAR (50) NOT NULL,
    fin_demo_age INT (6) NOT NULL,
    fin_demo_sex VARCHAR (5) NOT NULL,
    fin_demo_marital_status VARCHAR (5) NOT NULL,
    fin_demo_effective_date DATE,
    fin_demo_life_insurance DECIMAL(10,2) NOT NULL,
    fin_demo_career VARCHAR (50) NOT NULL,
    fin_demo_income INT (6) NOT NULL,
    fin_demo_debt INT (6) NOT NULL,
    fin_demo_update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
  //in progress

$analysis_results_sql = "CREATE TABLE IF NOT EXISTS fin_health_report(
    id INT(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fin_health_report_email VARCHAR (50) NOT NULL,
    fin_health_report_phone VARCHAR (50) NOT NULL,
    fin_health_report_firstname VARCHAR (50) NOT NULL,
    fin_health_report_lastname VARCHAR (50) NOT NULL,
    fin_health_report_gender	VARCHAR(50) NOT NULL,
    fin_health_report_age	INT (6) NOT NULL,
    fin_health_report_getapi_country VARCHAR (50) NOT NULL,
    fin_health_report_country	VARCHAR (50) NOT NULL,
    fin_health_report_married VARCHAR(50) NOT NULL,
    fin_health_report_children_count INT (6) NOT NULL,
    fin_health_report_profession VARCHAR(50),
    fin_health_report_profession_time INT (6) NOT NULL,
    fin_health_report_salary INT NOT NULL,
    fin_health_report_mortgage INT NOT NULL,
    fin_health_report_savings INT NOT NULL,
    fin_health_report_saving_recommendation INT NOT NULL,
    fin_health_report_saving_score INT NOT NULL,
    fin_health_report_credit_card_debt INT NOT NULL,
    fin_health_report_other_debt INT NOT NULL,
    fin_health_report_investment_ratio INT NOT NULL,
    fin_health_report_investment_recommendation INT NOT NULL,
    fin_health_report_insurance INT NOT NULL,
    fin_health_report_insurance_recommendation INT NOT NULL,
    fin_health_report_insurance_score INT NOT NULL,
    fin_health_report_overall_score INT NOT NULL,
    fin_health_resp_yes_contact BOOLEAN,
    fin_health_resp_yes_email_list BOOLEAN,
    fin_health_report_update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

  //use exec() because no results are returnedvisit
  $conn->exec($visitor_sql);
  $conn->exec($quiz_visitor_sql);
  $conn->exec($tips_sql);
  $conn->exec($questions_sql);
  $conn->exec($question_answers);
  $conn->exec($question_resp_test_sql);
  $conn->exec($demographic_data_international);
  $conn->exec($analysis_results_sql);

  echo "Table site_visitor created successfully\n";
  echo "Table quiz_visitor created successfully\n";
  echo "Table finance_tip created successfully\n";
  echo "Table finance_questions created successfully\n";
  echo "Table finance health responses created successfully";
  echo "Table finance_question_options created successfully";
  echo "Table test_insert created successfully";
  echo "Table fin_health_test_resp created successfully";
} catch(PDOException $e) {
  echo $visitor_sql . "<br>" . $e->getMessage();
  echo $quiz_visitor_sql . "<br>" . $e->getMessage();
  echo $tips_sql . "<br>" . $e->getMessage();
  echo $questions_sql . "<br>" . $e->getMessage();
  echo $question_resp_test_sql . "<br>" . $e->getMessage();
  echo $demographic_data_international . "<br>".$e->getMessage();
  echo $question_answers . "<br>" . $e->getMessage();
  echo $analysis_results_sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
