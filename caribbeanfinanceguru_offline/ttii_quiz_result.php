<?php
require_once('header.php');
if($_SESSION['visit_user_name'] == ''){header("Location: index.php");} //Is IP available?
$life_ins_quiz_user = $_SESSION['visit_user_name'];
$chapters_attempted_scores =   $_SESSION['chapters_attempted_scores'];
$chapters_array = [];
$index = 0;
foreach($chapters_attempted_scores as $key => $value){if($value != -1)$chapters_array[$index] = $key;$index++;}
$inClause = implode(',', $chapters_array);

//var_dump($chapters_attempted_scores);

$life_ins_quiz_chapter_desc = [];
$life_ins_quiz_chapter_score = [];
$life_ins_quiz_chapter_pct = [];
$life_ins_quiz_chapter_num = [];
$quiz_attempt_total_questions = 0;
$quiz_attempt_total_score= 0;
//Is new user?
$life_ins_quiz_result_check =
$conn->prepare("SELECT DISTINCT(life_ins_chapter_desc), quiz_result_chapter_num , quiz_result_chapter_score ,  quiz_result_total_score
                  FROM  life_ins_quiz_result
                  JOIN  life_ins_quest  ON  life_ins_quest_chapter_num  =  quiz_result_chapter_num
                  WHERE  quiz_result_user_name = '$life_ins_quiz_user' AND life_ins_quest_chapter_num IN ($inClause) ORDER BY life_ins_quest.id ASC");
$life_ins_quiz_result_check->execute();
while ($life_ins_quiz_result = $life_ins_quiz_result_check->fetch(PDO::FETCH_ASSOC))
 {
   $chapter_pct_calculate  =  ($life_ins_quiz_result['quiz_result_chapter_score'] == 0) ? 0 :ceil(($life_ins_quiz_result['quiz_result_chapter_score']/6)*100);
   array_push($life_ins_quiz_chapter_desc,$life_ins_quiz_result['life_ins_chapter_desc']);
   array_push($life_ins_quiz_chapter_score,$life_ins_quiz_result['quiz_result_chapter_score']); //score number
   array_push($life_ins_quiz_chapter_pct,$chapter_pct_calculate); //integer percent
   array_push($life_ins_quiz_chapter_num,$life_ins_quiz_result['quiz_result_chapter_num']);
 }
 //var_dump($life_ins_quiz_chapter_num);
 //var_dump($life_ins_quiz_chapter_pct);
 var_dump($chapter_pct_calculate);

 $quiz_attempt_total_questions = count($life_ins_quiz_chapter_num) * 6;
 $quiz_attempt_total_score = (array_sum($life_ins_quiz_chapter_score) == 0) ? 0 : ceil(array_sum($life_ins_quiz_chapter_score)/$quiz_attempt_total_questions * 100);
//put in a  function and file
$disclaimer = "<em><Strong>Disclaimer</Strong> -Practice exam scores are limited to content provided by the Life Insurance manual. They do not offer any guarante</em>";

?>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="ttii_quiz_result_style.css">
</head>

<body>
  <h2 style="padding-top:5%;"><?php echo "Welcome: " . $life_ins_quiz_user; ?></h2>
  <!-- wrapper starts  -->
  <div class="wrapper">
    <div class="wrapper_inner">
      <h1 class="heading">TTII Quiz Results</h1>

<?php
  for($i = 0; $i < count($life_ins_quiz_chapter_num); $i++){
?>
      <!-- results box -->
      <div class="result_box">
        <h3 class="hd text-center">Chapter: <?php echo $life_ins_quiz_chapter_num[$i];?></h3>
        <p><?php echo $life_ins_quiz_chapter_desc[$i];?></p>
        <div class="row align-items-center">
          <div class="bar_main col-sm-11 col-9">
            <div id="myResult" class="bar">
              <div class="myResultBar" data-width="<?php echo $life_ins_quiz_chapter_pct[$i];?>"></div>
            </div>
          </div>
          <div class="percent col-sm-1 col-3">
            <?php echo intval($life_ins_quiz_chapter_pct[$i]); ?> %
          </div>
        </div>
        <div class="box_analysis">
          <h3>Question Score: <?php echo "[ " . $life_ins_quiz_chapter_score[$i] . "/6 ]"; ?> </h3>
          <?php //echo $saving_report_detail; ?>
        </div>
      </div>
<?php
  }//end embedded for
?>

<div class="box_analysis">
    <div class="overall_score">
      Overall Score <br> <?php echo $quiz_attempt_total_score; ?> %
    </div>
    <div class="disclaimer"style="font-size:.75em;">
      <?php //echo $disclaimer;?>
    </div>
    </div>
  </div>
  <!-- wrapper ends -->
  <!-- buttons -->
  <div class="links">
    <!--<a class="button" id="myBtn">Register/Login For Full Access</a>-->
    <a href="index.php" class="button">Return to Home</a>
  </div><!--end div box_analysis-->


</body>
<script>
$(document).ready(function() {
 $(".myResultBar").each(function(i) {
      $width = $(this).data("width");
      $(this).css("width", $width + "%");
  });

});
</script>
</html>
