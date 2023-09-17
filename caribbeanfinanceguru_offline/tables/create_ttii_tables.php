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
  $user_info_sql = "CREATE TABLE IF NOT EXISTS registered_user (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  registered_user_name VARCHAR(50) NOT NULL,
  registered_user_email VARCHAR(50) NOT NULL,
  registered_user_register_date timestamp default current_timestamp not null,
  registered_user_last_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  registered_user_login_count INT(6) NOT NULL,
  registered_user_device_count INT(6) NOT NULL,
  registered_user_avg_app_rating INT(6) NOT NULL,
  registered_user_last_app_rating INT(6) NOT NULL,
  registered_user_is_paid BOOLEAN
  )";

  $life_insurance_questions_sql = "CREATE TABLE IF NOT EXISTS life_ins_quest(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    life_ins_quest_chapter_num INT(6) NOT NULL,
    life_ins_quest_num INT(6) NOT NULL,
    life_ins_chapter_desc VARCHAR(100) NOT NULL,
    life_ins_quest_question VARCHAR(1000) NOT NULL,
    life_ins_quest_answer VARCHAR(1000) NOT NULL
  )";


  $life_insurance_options_sql = "CREATE TABLE IF NOT EXISTS life_ins_quest_options(
    id iNT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    life_ins_quest_chapter_num INT(6) NOT NULL, /*Foreign Key*/
    life_ins_quest_num INT(6) NOT NULL, /*Foreign Key */
    life_ins_quest_option_a VARCHAR (300) NOT NULL,
    life_ins_quest_option_b VARCHAR (300) NOT NULL,
    life_ins_quest_option_c VARCHAR (300) NOT NULL,
    life_ins_quest_option_d VARCHAR (300) NOT NULL
  )";

$life_insurance_quiz_results_sql = "CREATE TABLE IF NOT EXISTS life_ins_quiz_result(
  id iNT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  quiz_result_user_email VARCHAR(50) NOT NULL,
  quiz_result_user_name VARCHAR(50) NOT NULL,
  quiz_result_chapter_num VARCHAR(100) NOT NULL,
  quiz_result_chapter_score INT(6) NOT NULL,
  quiz_result_chapter_avg_score INT(6) NOT NULL,
  quiz_result_attempt_count INT(6) NOT NULL,
  quiz_result_total_score INT(6) NOT NULL,
  quiz_result_last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

//use exec() because no results are returnedvisit
$conn->exec($user_info_sql);
$conn->exec($life_insurance_questions_sql);
$conn->exec($life_insurance_options_sql);
$conn->exec($life_insurance_quiz_results_sql);

echo "Table user_info_sql created successfully\n";

} catch(PDOException $e) {
echo $user_info_sql . "<br>" . $e->getMessage();
echo $life_insurance_options_sql . "<br>" . $e->getMessage();
echo $life_insurance_questions_sql . "<br>" . $e->getMessage();
echo $life_insurance_quiz_results_sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
