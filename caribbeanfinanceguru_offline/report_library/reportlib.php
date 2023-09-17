
<?php
function savings_report($fin_health_resp_age, $projected_saving, $current_saving, $fin_health_resp_salary,$fin_health_resp_investment_ratio){
  $emergency_funds = $fin_health_resp_salary * 6;
  $idle_savings = $fin_health_resp_salary * 7;
  $investment_ratio = 110 - $fin_health_resp_age;
  $investable_savings = $current_saving - $emergency_funds;
  $ideal_savings_10_percent = ceil($fin_health_resp_salary * .1);
  $ideal_savings_15_percent = ceil($fin_health_resp_salary  * .15);
  $ideal_investment_rate = ceil((($ideal_savings_10_percent + $ideal_savings_15_percent)/2) * ($investment_ratio / 100));
  $time_till_emergency_fund_check = ceil(($emergency_funds - $current_saving) / $ideal_savings_10_percent);


  $emergency_fund = new CurrencyFormat();
  $emergency_fund->set_region_dollar_amt($emergency_funds);
  $emergency_fund->get_region_dollar_amt();

  $current_saving_amt = new CurrencyFormat();
  $current_saving_amt ->set_region_dollar_amt($current_saving);
  $current_saving_amt ->get_region_dollar_amt();

  $investable_savings_amt = new CurrencyFormat();
  $investable_savings_amt  ->set_region_dollar_amt($investable_savings);
  $investable_savings_amt  ->get_region_dollar_amt();


  $ideal_savings_10 = new CurrencyFormat();
  $ideal_savings_10->set_region_dollar_amt($ideal_savings_10_percent);
  $ideal_savings_10->get_region_dollar_amt();

  $ideal_savings_15 = new CurrencyFormat();
  $ideal_savings_15->set_region_dollar_amt($ideal_savings_15_percent);
  $ideal_savings_15->get_region_dollar_amt();

  $ideal_investment_amt = new CurrencyFormat();
  $ideal_investment_amt->set_region_dollar_amt($ideal_investment_rate);
  $ideal_investment_amt->get_region_dollar_amt();

  $investment_preparedness = "(10 percent: $ideal_savings_10_percent plus $ideal_savings_15_percent / 2) * (110 - $fin_health_resp_age / 100)";

  if($current_saving > $idle_savings){
    $investment_preparedness =
    "<strong><span style ='color: #4CAF50;'>Fantastic Job!</span></strong> Now would be a great time to consider putting some of your savings over <strong>$emergency_fund (<span style ='color: #4CAF50;'>$investable_savings_amt</span>) </strong> to work.
    Investment tools such as annuities, mutual funds, stocks etc are great options. A common recommendation is the <strong>rule of 110 (110 - Age)</strong>.
    In your case, this would be roughly $investment_ratio% of your monthly savings (10%-15% income) or <strong><span style ='color: #4CAF50;'>$ideal_investment_amt</span></strong>
    going toward higher risk investments like stocks and the remainder to bonds or mutual funds.";
  }
  elseif($current_saving > $emergency_funds)
  {
    $investment_preparedness =
    "<strong><span style ='color: #4CAF50;'>Great Work!</span></strong> You have done really well at preparing yourself for uncertainty in the job market, change of careers or
    personal emergencies.Emergency fund ($emergency_fund) <strong>check! </strong>. Now is the right to time to start considering investing towards a successful retirement.
    The types of investments available are many and now is the perfect time to schedule a consultation with a financial planning professional to make the best use of your money.
    The recommended amounts based on your age are $investment_ratio% of your monthly savings (10%-15% income) or  <strong><span style ='color: #4CAF50;'>$ideal_investment_amt</span></strong>
    going toward higher risk investments like stocks and the remainder to bonds or mutual funds.";
  }
  else{
    $investment_preparedness =
    "<strong><span style ='color: #4CAF50;'>Let's Go!</span></strong> It's time to focus on hitting your first financial health milestone. An emergency fund <strong>($emergency_fund)</strong>.
    This is generally <strong>4-6 months of your income</strong> (<strong><span style ='color: #4CAF50;'>$emergency_fund</span></strong>) that you can call on in the event of unplanned expenses, car troubles, changing jobs and other emergencies.
    With a savings rate of as little as <strong>$ideal_savings_10</strong> per month placed into a savings account (kept separate from your day to day account) you can get that emergency fund in place (within <strong>$time_till_emergency_fund_check</strong> months).
    At that point, the sky is the limit and you can begin looking at investing and having your money work for you.";
  }

    $saving_report_detail = array(
    $investment_preparedness,
  );
  return $saving_report_detail;
}//end function savings_report


function insurance_report($fin_health_resp_insurance, $recommended_insurance,$fin_health_resp_salary, $fin_health_resp_children_count){
  $avg_insurance_cost = $fin_health_resp_salary * (.06 + $fin_health_resp_children_count * .01);

  $average_insurance_cost = new CurrencyFormat();
  $average_insurance_cost->set_region_dollar_amt($avg_insurance_cost);
  $average_insurance_cost->get_region_dollar_amt();

  if($recommended_insurance > $fin_health_resp_insurance && $fin_health_resp_insurance == 0){
    $insurance_coverage_health =
    "Now would be a great time to start considering your options for life insurance. A good rule of thumb
     is to get as much of the recommended coverage as possible for less than or equal to 6% - 8% of your gross income.
     Based on your reported figures you can shop around for coverage that costs around <strong>$average_insurance_cost</strong>.";
  }
  elseif($recommended_insurance > $fin_health_resp_insurance )
  {
    $insurance_coverage_health =
    "Based on our analysis and general guidelines your life insurance seems <strong>lower than recommended</strong>. Consider increasing
     your coverage. Shopping for the best deal that costs no more than <strong>$average_insurance_cost</strong> per month. Remember; insurance needs
     change with time so this is more of an outline based on (income, age, dependents etc.).";
   }
  else{
    $insurance_coverage_health =
    "Based on the info provided your coverage seems adequate at this time. ";
  }

  $insurance_report_detail = array(
    $insurance_coverage_health,
  );
  return $insurance_report_detail;
}//end function insurance_report


function salary_report($fin_health_resp_salary,$salary_calculation,$fin_health_resp_age,$fin_health_resp_gender,$fin_health_resp_sal_percentile){
$salary_percentile = $fin_health_resp_sal_percentile;

  switch($salary_percentile){
    case $salary_percentile > 75:
         $salary_comparison = "<strong><span style ='color: #ff2424;'>High Earner -</span></strong> Your reported income is within the highest quartile (75-100%) of your demographic (age,gender,region).";
         break;
    case $salary_percentile > 50:
         $salary_comparison = "<strong><span style ='color: #ff2424;'>Average Earner -</span></strong> Your reported income is within the second quartile (50%-75%) of your demographic (age,gender,region).
                               Depending on the number of years that you have spent within your current role it 'may' be the time to start considering upgrading your qualifications or a change of companies to move up the pay scale.";
         break;
    case $salary_percentile > 25:
         $salary_comparison = "<strong><span style ='color: #ff2424;'>Low Earner -</span></strong> Your reported income is within the third quartile (25%-50%) of your demographic (age,gender,region).
                               Depending on the number of years that you have spent within your current role, investing in an upgrade to your qualifications, seeking a raise or looking for higher paying options seem like great moves";
         break;
    default:
         $salary_comparison = "<strong><span style ='color: #ff2424;'>Time for growth -</span></strong>. Depending on your circumstances it is highly recommended that you invest in further training and qualifications in your field and
                               eventually seek opportunities for promotion or other employers that offer higher salaries";
    }//end switch

    $salary_report_detail = array(
    $salary_comparison,
  );
  return $salary_report_detail;
}//end function salary_report
?>
