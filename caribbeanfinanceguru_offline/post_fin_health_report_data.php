<?php
session_start();
require_once(dirname(__FILE__) . '/db_connection/dbconn.php');
//Objective: Send the email from email.php after click by users on finanalysis.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$user_email = test_input(trim($_POST['user_email']));
	$user_phone = test_input(trim($_POST['user_telephone']));
	$user_firstname = test_input(trim($_POST['user_firstname']));
	$user_lastname = test_input(trim($_POST['user_lastname']));

	//should these be test_input() too?
	//Hidden fields from the user (viewable on developer console?)
	$user_saving_report = $_POST['user_saving_report'];
	$user_insurance_report= $_POST['user_insurance_report'];
	$user_salary_report= $_POST['user_salary_report'];
	$user_saving_calc = $_POST['user_savings_recommendation'];;

  $user_gender = $_POST['user_gender'];
	$user_age = $_POST['user_age'];
	$user_apiresult_country = $_POST['user_apiresult_country'];
	$user_reported_country = $_POST['user_country'];
	$user_marital_status = $_POST['user_married'];
	$user_children_count = $_POST['user_children_count'];
	$user_profession = $_POST['user_profession'];
	$user_profession_time = $_POST['user_profession_time'];
	$user_salary = $_POST['user_salary'];
	$user_mortgage_monthly = $_POST['user_mortgage_monthly'];
	$user_savings = $_POST['user_savings'];
	$user_recommended_saving = $_POST['user_savings_recommendation'];
	$user_saving_score = $_POST['user_saving_score'];
	$user_credit_card_debt = $_POST['user_credit_card_debt'];
	$user_other_debt = $_POST['user_other_debt'];
	$user_investment_ratio = $_POST['user_investment_ratio'];
	$user_investment_recommendation = $_POST['user_investment_recommendation'];
	$user_insurance = $_POST['user_insurance'];
	$user_recommended_insurance = $_POST['user_insurance_recommendation'];
	$user_insurance_calculation = $_POST['user_insurance_score'];
	$user_overall_financial_health_score = $_POST['user_overall_fin_health'];
	$user_resp_yes_contact = isset($_POST['user_resp_yes_contact']) == true ? true:false;
	$user_resp_yes_email_list = isset($_POST['user_resp_yes_email_list']) == true ? true:false;

 //email variables
	$_SESSION['user_firstname'] = $user_firstname;
	$_SESSION['user_lastname'] = $user_lastname;
	$_SESSION['user_saving_report'] = $user_saving_report;
	$_SESSION['user_insurance_report'] = $user_insurance_report;
	$_SESSION['user_salary_report'] = $user_salary_report;
	$_SESSION['user_saving_calc'] = $user_saving_calc;
	$_SESSION['user_overall_financial_health_score'] = $user_overall_financial_health_score;
	$_SESSION['user_email'] = $user_email;


	//Adding client data to Agent Hot Lead Report
	$fin_health_report_user_db_check = $conn->prepare("SELECT fin_health_report_email, fin_health_report_firstname FROM fin_health_report WHERE fin_health_report_email ='$user_email'");
	$fin_health_report_user_db_check->execute();
	$fin_health_report_user_db_check_result = $fin_health_report_user_db_check->rowCount();

 //var_dump($fin_health_report_user_db_check);

	if($fin_health_report_user_db_check_result)
	{
	}
	else{
		//PDO update site visit count based on IP address (Unregistered users)
		$sql_lead_report_update = "INSERT INTO fin_health_report
		                           (
																 fin_health_report_email,
																 fin_health_report_phone,
																 fin_health_report_firstname,
																 fin_health_report_lastname,
																 fin_health_report_gender,
																 fin_health_report_age,
																 fin_health_report_getapi_country,
																 fin_health_report_country,
																 fin_health_report_married,
																 fin_health_report_children_count,
																 fin_health_report_profession,
																 fin_health_report_profession_time,
																 fin_health_report_salary,
																 fin_health_report_mortgage ,
																 fin_health_report_savings ,
																 fin_health_report_saving_recommendation ,
																 fin_health_report_saving_score ,
																 fin_health_report_credit_card_debt ,
																 fin_health_report_other_debt ,
																 fin_health_report_investment_ratio ,
																 fin_health_report_investment_recommendation,
																 fin_health_report_insurance ,
																 fin_health_report_insurance_recommendation ,
																 fin_health_report_insurance_score ,
																 fin_health_report_overall_score,
																 fin_health_resp_yes_contact,
																 fin_health_resp_yes_email_list
		                           )
		                           VALUES
		                           (
	                               '$user_email',
																 '$user_phone',
																 '$user_firstname',
																 '$user_lastname',
																 'user_gender',
																 'user_age',
																 '$user_apiresult_country',
																 '$user_reported_country',
																 '$user_marital_status',
																 '$user_children_count',
																 '$user_profession',
																 '$user_profession_time',
																 '$user_salary',
																 '$user_mortgage_monthly',
																 '$user_savings',
																 '$user_recommended_saving',
																 '$user_saving_score',
																 '$user_credit_card_debt',
																 '$user_other_debt',
																 '$user_investment_ratio',
																 '$user_investment_recommendation',
																 '$user_insurance',
																 '$user_recommended_insurance',
																 '$user_insurance_calculation',
																 '$user_overall_financial_health_score',
																 '$user_resp_yes_contact',
																 '$user_resp_yes_email_list'
		                           )";
		         $result = $conn->exec($sql_lead_report_update);
	}//end else
}//end if server post

//safety measure for user input (email, first/lastname and phone number)
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
header('Location: email.php');exit();
?>
