<?php
require_once('header.php');
$registered_user = $_SESSION['visit_user_name'];
$registered_user_check = $conn->prepare("SELECT registered_user_name FROM  registered_user WHERE  registered_user_name = '$registered_user' AND registered_user_is_paid = 1"); 
$registered_user_check->execute();
$registered_user_check_result = $registered_user_check->fetch(PDO::FETCH_ASSOC);
if(!$registered_user_check_result){header("Location: index.php");}

$life_ins_quiz_chapter_desc = [];
$life_ins_quiz_chapter_score = [];
$life_ins_quiz_chapter_pct = [];
$life_ins_quiz_chapter_num = [];
$quiz_attempt_total_questions = 0;
$quiz_attempt_total_score= 0;
$index = 0;

//User has previous quiz results?
$life_ins_quiz_result_check =
$conn->prepare("SELECT DISTINCT(life_ins_chapter_desc), quiz_result_chapter_num , quiz_result_chapter_score ,  quiz_result_total_score
                  FROM  life_ins_quiz_result
                  JOIN  life_ins_quest  ON  life_ins_quest_chapter_num  =  quiz_result_chapter_num
                  WHERE  quiz_result_user_name = '$registered_user'");
$life_ins_quiz_result_check->execute();
$life_ins_quiz_result = $life_ins_quiz_result_check->rowCount();
//var_dump($life_ins_quiz_result);
if($life_ins_quiz_result)
{
  while ($life_ins_quiz_result = $life_ins_quiz_result_check->fetch(PDO::FETCH_ASSOC))
 {
   array_push($life_ins_quiz_chapter_desc,$life_ins_quiz_result['life_ins_chapter_desc']);
   array_push($life_ins_quiz_chapter_score,$life_ins_quiz_result['quiz_result_chapter_score']); 
   array_push($life_ins_quiz_chapter_num,$life_ins_quiz_result['quiz_result_chapter_num']);
 }
 var_dump(count($life_ins_quiz_chapter_score));
  //echo "Score is : " . $life_ins_chapter_score[0];
  //var_dump($life_ins_quiz_chapter_desc);
  //$quiz_attempt_total_questions = count($life_ins_quiz_chapter_num) * 6;
  //$quiz_attempt_total_score = ceil(array_sum($life_ins_quiz_chapter_score)/$quiz_attempt_total_questions * 100);//division by zero
}
  //Fetch TTII Exam Chapters
  $life_ins_chapters_query = $conn->prepare("SELECT DISTINCT(life_ins_chapter_desc), life_ins_quest_chapter_num FROM life_ins_quest"); 
  //WHERE life_ins_quest_chapter_num IN ('1','2','3','4','5','6','7')");
  $life_ins_chapters_query->execute();
  $life_ins_chapter_desc = [];
  $life_ins_chapter_num = [];
  $life_ins_chapters_count = $life_ins_chapters_query->rowCount();

  //store chapters and numbers for display
    for($i=0;$i < $life_ins_chapters_count;$i++)
    {
      $result = $life_ins_chapters_query->fetch(PDO::FETCH_OBJ);
      $life_ins_chapter_num[$i] = $result->life_ins_quest_chapter_num;
      $life_ins_chapter_desc[$i] = $result->life_ins_chapter_desc;
    }
?>
<html>
<head>
  <link rel="stylesheet" href="ttii_user_dash.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

  <title>HealthyFinanceCheck | Home</title>
</head>

<body>
  <div class="container">
    <h1>Todo List</h1>
    <form method="POST" action="chapter_select_redirect.php" id="chapter_select_form">
      <?php
        for($i = 0; $i < count($life_ins_chapter_num); $i++)
        {
      ?>
      <ul>
        <li>
          <label>
             <!--Produces Non Fatal Error (Warning) for user first time : PHP Warning:  Undefined array key 0 (No previous scores)-->
            <input type="checkbox" class="checked_option" name="task1" value="<?php echo $life_ins_chapter_num[$i]; ?>">
            <?php echo $life_ins_chapter_num[$i] . ". " . $life_ins_chapter_desc[$i]; ?>
            <?php echo  ($life_ins_quiz_chapter_score[$i]== -1) ? "-- pts" :  "[".$life_ins_quiz_chapter_score[$i]."] pts"; ?>
          </label>
        </li>
      <?php
        }
       ?>
      </ul>
      <input type='submit' value='Submit'>
    </form>
  </div>
  </body>
  <script src="ttii_dash.js"></script>
</html>
