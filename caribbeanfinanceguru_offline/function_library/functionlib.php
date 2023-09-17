<?php

function conversion_variable($fin_health_resp_country){
 $conversion_value = 0;
 //which country is the user from?
 if($fin_health_resp_country == "Trinidad and Tobago")
 {
   $conversion_value = 7;
 }
 elseif($fin_health_resp_country == "Barbados")
 {
   $conversion_value = 2;
 }
 elseif($fin_health_resp_country == "Jamaica")
 {
   $conversion_value = 155;
 }
 else
 {
   $conversion_value = 1;
 }

   $conversion_var = array($conversion_value);
   return $conversion_var;
}//end function conversion_variable

function saving_health($fin_health_resp_savings, $fin_health_resp_salary,$fin_health_resp_age) {
  $current_savings = $fin_health_resp_savings;
  $years = $fin_health_resp_age - 18;
  $sal_inc_rate = 1 + .03;
  $saving_rate = .1;
  $actual_saving = $fin_health_resp_savings;
  $total_projected_saving = 0;

  //Salary at 18yrs old
  $test = ($fin_health_resp_salary * 12)/($sal_inc_rate * pow($sal_inc_rate,$years));
  //Expected Savings 10% salary per year since 18yrs old
  for($i=1; $i <= $years; $i++)
  {
    $current_projected_saving= $saving_rate * ($test * pow($sal_inc_rate,$i));
    $total_projected_saving += $current_projected_saving;
  }
  $saving_ratio_calculation =   ceil(($fin_health_resp_savings/$total_projected_saving) * 100);
  $saving_ratio_calculation = ($saving_ratio_calculation > 100) ? 100:$saving_ratio_calculation; //always >=100
  $total_projected_saving = ceil($total_projected_saving);


  $saving_data_result = array(
    $saving_ratio_calculation,
    $total_projected_saving,
    $current_savings,
);
  return $saving_data_result;
}//end function saving_health()


//Needs work!!!
//How much insurance you have vs should have
function insurance_health($fin_health_resp_insurance,$fin_health_resp_age,$fin_health_resp_children_count,$fin_health_resp_youngest,$fin_health_resp_salary,$fin_health_resp_credit_card_debt,$fin_health_resp_other_debt,$fin_health_resp_savings,$fin_health_resp_married){

  $current_insurance = $fin_health_resp_insurance;
  $total_debt = $fin_health_resp_other_debt + $fin_health_resp_credit_card_debt + 1;
  $annual_income = $fin_health_resp_salary * 12;
  $retire_age = ($fin_health_resp_gender = "M") ? 65:60;
  $yrs_till_retire =  $retire_age - $fin_health_resp_age;
  $funeral_expense = 4000; //international = 8000
  $college_price = 5000;  //international 20000
  $child_graduate_avg_age = 18;
  $generic_recommended_insurance_amt = $annual_income * 12.5; //10 - 15 times income


  $yrs_till_child_graduate = ($fin_health_resp_children_count == 0) ? $child_graduate_avg_age:$fin_health_resp_youngest;
  $kids_college_tuition = $college_price * $fin_health_resp_children_count;
  $income_till_youngest_graduate = $annual_income * ($child_graduate_avg_age - $yrs_till_child_graduate);
  $income_till_retire = $annual_income * $yrs_till_retire;

  //condition needed for if spouse but no children , otherwise none needed
  $income_maintain_family = ($income_till_youngest_graduate < $income_till_retire)? $income_till_retire:$income_till_youngest_graduate;

  //condition for single person with no children
  $income_maintain_family = ($fin_health_resp_married == "S" && $fin_health_resp_children_count == 0)? 0:$income_maintain_family;


  $total_recommended_insurance = $income_maintain_family + $kids_college_tuition + $total_debt + $funeral_expense - $fin_health_resp_savings;
  //If total recommended insurance is above generic 10x -15x - recommend 12.5x
  $total_recommended_insurance = ($total_recommended_insurance > $generic_recommended_insurance_amt) ? $generic_recommended_insurance_amt:$total_recommended_insurance;

  //individuals with no insurance need. those who do get a score out of 100
  if($fin_health_resp_insurance = 0)
  {
    $insurance_ratio_calculation = 0;
  }
  else{
    //$insurance_ratio_calculation = ceil(($fin_health_resp_insurance / $total_recommended_insurance) * 100);
    $insurance_ratio_calculation = ($total_recommended_insurance <= 0) ? 0: ceil(($current_insurance /$total_recommended_insurance) * 100);
  }
  //if more insurance than required. set it to 100%
  $insurance_ratio_calculation = ($insurance_ratio_calculation > 100) ? 100 : $insurance_ratio_calculation;



  $insurance_data_result = array(
    $insurance_ratio_calculation,
    $total_recommended_insurance,
    $current_insurance,
);
   return $insurance_data_result;
}//end function insurance_health

function salary_health($fin_health_resp_salary,$fin_health_resp_sal_percentile){
  //for loop rank Salary where age, gender, profession
  $total_recommended_salary = $fin_health_resp_salary * 2;

  $income_data_result = array(
    $fin_health_resp_sal_percentile,
    $total_recommended_salary,
    $fin_health_resp_salary,
);
   return $income_data_result;

}//end function income health

function overall_health($salary_calculation,$insurance_calculation,$saving_calculation){//no data
  $sal = $salary_calculation;
  $ins = $insurance_calculation;
  $saved = $saving_calculation ;
  $divisor_count = 0;
  if ($salary_calculation == 100){$sal = 0;} //no region data for salary
  if($sal < 100 && $sal > 0 ){ $divisor_count++;}//doesn't matter. will never be < 0
  if($ins > 0){$divisor_count++;}
  if($saved > 0){$divisor_count++;}

  $overall_financial_health_score = ceil(($sal + $ins + $saved) / $divisor_count);
  return $overall_financial_health_score;
}//end function overall health

 ?>
