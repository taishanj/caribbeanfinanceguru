<?php
require_once('header.php');
$chaptersChoice = [];
$inClause =  [];
if(!$_SESSION['visit_user_name']){header("Location: index.php");}
if (isset($_GET['chaptersChoice'])) { $chaptersChoice = json_decode($_GET['chaptersChoice']); $inClause = implode(',', $chaptersChoice);}
  //User session info -Registered or visitor user? (Results and storing them different)
  $visit_user_name = $_SESSION['visit_user_name'];
  $visit_user_email = $_SESSION['visit_user_email'];

 if(!count($chaptersChoice)){array_push($chaptersChoice,1); array_push($chaptersChoice,2);  $inClause = implode(',', $chaptersChoice); } // array_push($chaptersChoice,2);
  //Fetch TTII Exam Questions
  $life_ins_questions_query = $conn->prepare("SELECT * FROM life_ins_quest WHERE life_ins_quest_chapter_num IN ($inClause) ORDER BY id ASC");
  $life_ins_questions_query->execute();
  $life_ins_questions_array = $life_ins_questions_query->fetchAll();
  $life_ins_questions_count =   $life_ins_questions_query->rowCount();

  //Return the TTII Exam Responses
  $life_ins_questions_mcq_query = $conn->prepare("SELECT * FROM life_ins_quest_options  WHERE life_ins_quest_chapter_num IN ($inClause) ORDER BY id ASC");
  $life_ins_questions_mcq_query->execute();
  $life_ins_questions_mcq_array = $life_ins_questions_mcq_query->fetchAll();
  $life_ins_questions_mcq_count =   $life_ins_questions_mcq_query->rowCount();

  //Fetch TTII Exam Chapters
  $life_ins_chapters_query = $conn->prepare("SELECT DISTINCT(life_ins_quest_chapter_num) FROM life_ins_quest");
  $life_ins_chapters_query->execute();
  $life_ins_chapter_desc = [];
  $life_ins_chapter_num = [];
  $life_ins_chapters_query_result =   $life_ins_chapters_query->fetchAll();
  //var_dump($life_ins_chapters_query_result);
  //$life_ins_chapters_count = $life_ins_chapters_query->rowCount();

  //var_dump($life_ins_questions_mcq_count);

  //Shuffle the questions evenly

  $life_ins_questions_array_element_count = count($life_ins_questions_array);
  $order = range(1, $life_ins_questions_array_element_count);
  shuffle($order);
  array_multisort($order, $life_ins_questions_array, $life_ins_questions_mcq_array);
 
?>

<!--store questions returned from MySQL DB to Javascript array-->
<script type="text/javascript">
//Convert the questions to a javascript array
let questions = <?php echo json_encode($life_ins_questions_array); ?>;
let mcq_options = <?php echo json_encode($life_ins_questions_mcq_array);?>;
let chapters = <?php echo json_encode($life_ins_chapters_query_result); ?>
</script>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Caribbean Finance Guru |</title>
  <link rel="stylesheet" href="ttii_quiz_style.css">
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
      <div class="start_btn"><button>Start TTII Demo Quiz</button></div>
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
        <div class="title">Insurance Licensing Quiz</div>
        <div class="timer">
                <div class="time_left_txt">Time Left</div>
                <div class="timer_sec">15</div>
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
    <p id="visit_user_name"><?php echo $visit_user_name; ?></p>
    <p id="visit_user_email"><?php echo $visit_user_email; ?></p>
  </div>
  <script src="ttii_exam_script.js"></script>
</body>
