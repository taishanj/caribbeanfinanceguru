<?php
require_once('header.php');
  $_SESSION['user_ip'] = '';
  $_SESSION['user_region'] = '';
  //Display random  daily finance tip from finance_tip table
  $daily_tips = $conn->prepare("SELECT tip_dailyquote FROM finance_tip ORDER BY RAND() LIMIT 1;");
  $daily_tips->execute();
  $tip = $daily_tips->fetch(PDO::FETCH_ASSOC);
  $my_tip = $tip['tip_dailyquote'];
 ?>
<html>

<head>
  <link rel="stylesheet" href="index_style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="shortcut icon" href="#">
  <script type="text/javascript" src="visitor_metadata.js"></script>
  <title>Caribbean Finance Guru | Home</title>
</head>

<body>
  <!-- alert area starts -->
  <div class="wa-alert justify-content-center">
    <div class="alert col-xl-6 col-lg-8 col-11">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
      <strong>Tip: </strong> <?php echo $my_tip; ?>
    </div>
  </div>

  <!-- wrapper of images and buttons -->
  <div class="wrapper">
    <div class="boxes">
      <div class="box-area col-lg-4 col-sm-6 col-12">
        <div class="box_area_inner">
          <div class="box-img">
            <img src="assets/img/calc.png" alt="">
          </div>
          <div class="box-desc">
        <button id="user_section_choice_one" onclick="SendDataFinQuiz()">Financial Health Check</button>
          </div>
        </div>
      </div>
      <div class="box-area col-lg-4 col-sm-6">
        <div class="box_area_inner">
          <div class="box-img">
            <img src="assets/img/exam.png" alt="">
          </div>
          <div class="box-desc">
           <button id="user_section_choice_two" onclick="SendDataTTTIIQuiz()">Exam Prep</button>
          </div>
        </div>
      </div>
      <div class="box-area col-lg-4 col-sm-6">
        <div class="box_area_inner">
          <div class="box-img">
            <img src="assets/img/finclass.png" alt="">
          </div>
          <div class="box-desc">
            <button>Financial Health Education</button>
          </div>
          <p style="text-align:center; color:#C70039;"> Coming soon! </p>
        </div>
      </div>
    </div>
  </div>

  <!--User metadata obtain-->
  <div style="visibility:hidden;">
    <p id ="visit_user_name"><?php echo $name; ?></p>
    <p id ="visit_user_email"><?php echo $email; ?></p>
    <p id="visit_ip_addr"></p>
    <p id="visit_country"></p>
  </div>

  <?php
  include "footer.php";
  ?>
</body>

</html>
