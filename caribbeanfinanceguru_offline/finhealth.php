<?php
require_once('header.php');
  //Return the financial health quiz questions from SQL Database
  $_SESSION['user_ip']  = ($_SESSION['user_ip'] == '') ? 'guest_'. time() : $_SESSION['user_ip']; //user IP address or guest timestamp
  $usr_detail = $_SESSION['user_ip']; //set session variable for possible user with blocked ip

  $_SESSION['user_region'] = ($_SESSION['user_region'] == '') ? 'guest_region' : $_SESSION['user_region'];
  $usr_region = $_SESSION['user_region'];

  //Fetch financial health questions
  $fin_questions_query = $conn->prepare("SELECT id,fin_quest_quest FROM finance_questions;");
  $fin_questions_query->execute();
  $fin_health_questions_array = $fin_questions_query->fetchAll();

 //Return the financial health MCQ responses
 $fin_questions_mcq_query = $conn->prepare("SELECT * FROM finance_question_options");
 $fin_questions_mcq_query->execute();
 $fin_questions_mcq_array = $fin_questions_mcq_query->fetchAll();

?>
<!--store questions returned from MySQL DB to Javascript array-->
<script type="text/javascript">
//Convert the questions to a javascript array
let questions = <?php echo json_encode($fin_health_questions_array); ?>;
let mcq_options = <?php echo json_encode($fin_questions_mcq_array);?>;
</script>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Healthy Finance Quiz | CodingNepal</title>
  <link rel="stylesheet" href="fin_health_style.css">
  <!-- FontAweome CDN Link for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <style>
  .navbar {
    position: sticky;
  }
  </style>
</head>

<body>
  <div class="wrapper_main">
    <!-- start Quiz button -->
    <!-- <div class="start_btn"><button>Start Quiz</button></div> -->
    <div class="wa_quiz_btn">
      <div class="start_btn"><button>Start Financial Health Quiz</button></div>
    </div>

    <!-- Info Box -->

    <div class="info_box col-lg-6 col-sm-8 col-10">
      <div class="info-title"><span>Some Rules of this Quiz</span></div>
      <div class="info-list">
        <div class="info">1. This quiz should take about <span>2 minutes.</span></div>
        <div class="info">2. You cannot change an answer without having to restart.</div>
        <div class="info">3. Select the <span> closest </span> answer from your options .</div>
        <div class="info">4. The dollar figures in the questions are in USD.</div>
        <!--<div class="info">5. You 'must' select an answer to move forward.</div>-->
        <!--<div class="info">6. Your report is converted to the chosen region.</div>-->
      </div>
      <div class="buttons">
        <button class="quit">Exit Quiz</button>
        <button class="restart">Continue</button>
      </div>
    </div>

    <!-- Quiz Box -->


    <div class="quiz_box col-lg-6 col-sm-8 col-11">
      <header>
        <div class="title">Awesome Quiz Application</div>
      </header>
      <section>
        <div class="que_text">
          <!-- Here I've inserted question from JavaScript -->
        </div>
        <div class="option_list">
          <!-- Here I've inserted options from JavaScript -->
        </div>
      </section>

      <!-- footer of Quiz Box -->
      <footer>
        <div class="total_que">
          <!-- Here I've inserted Question Count Number from JavaScript -->
        </div>
        <button class="next_btn">Next</button>
      </footer>
    </div>

    <!-- Result Box -->
    <div class="result_box col-lg-6 col-sm-8 col-10">
      <div class="result_box_inner">
        <div class="icon">
          <i class="fas fa-crown"></i>
        </div>
        <div class="complete_text">You've completed the Financial Health Quiz!</div>
        <div class="score_text">
          <!-- Here I've inserted Score Result from JavaScript -->
        </div>
        <div class="buttons">
          <button class="restart">Replay Quiz</button>
          <button class="quit">Generate Report</button>
        </div>
      </div>
    </div>
  </div>
 <div style="visibility:hidden; display: none;">
    <p id="fin_health_resp_ip_addr"><?php echo $usr_detail; ?></p>
    <p id="fin_health_resp_getapi_country"><?php echo $usr_region; ?></p>
  </div>
  <script src="fin_health_quiz_script.js"></script>
</body>
