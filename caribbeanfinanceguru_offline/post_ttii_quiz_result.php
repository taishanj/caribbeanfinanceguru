<?php
session_start();
require_once(dirname(__FILE__) . '/db_connection/dbconn.php');
$chapters_array = [];
$scores_array = [];
//$ids_array = [];
$previous_attempts_array = array();
$isPreviousAttempt = false;
$index = 0;
$count = 0;
//session variable needed for scores
if($_GET['data'] != null)
{
  $score_by_chapter = json_decode($_GET['data']);
   foreach($score_by_chapter as $key => $value)
  {
    $chapters_array[$index] = $key;
    $scores_array[$index] = $value;
    $index++;
  }

    $_SESSION['visit_user_name'] = $_GET['visit_user_name'];
    $_SESSION['chapters_attempted_scores'] = $score_by_chapter;
    $quiz_result_user_email = $_GET['visit_user_email'];
    $quiz_result_user_name = $_GET['visit_user_name'];
    
     var_dump($score_by_chapter);
  var_dump($_SESSION['visit_user_name']);

    //life_ins_quiz_result table insert
    $quiz_result_chapter_num = 0;
    $quiz_result_chapter_score = 0;
    $quiz_result_chapter_avg_score = 0; //needs to be returned
    $quiz_result_attempt_count = 1; //needs to be returned
    $quiz_result_total_score = $_GET['total_score'];
    $quiz_result_total_avg_score = 5; //needs to be returned

}//end if
//Is $registered user?
$registered_user_check = $conn->prepare("SELECT registered_user_name FROM registered_user WHERE registered_user_name ='$quiz_result_user_name'");
$registered_user_check->execute();
$registered_user_check_result = $registered_user_check->rowCount();

 //Is do quiz before? (guest or $registered_user)
 $user_quiz_check =  $conn->prepare("SELECT id,quiz_result_chapter_num,quiz_result_chapter_score FROM life_ins_quiz_result WHERE quiz_result_user_name ='$quiz_result_user_name' ");
 $user_quiz_check->execute();
 $user_quiz_check_result_count = $user_quiz_check->rowCount();
 //Is user do the chapters before?
 if($user_quiz_check_result_count){$isPreviousAttempt = true;}

 //Rows where previous chapter efforts recorded
 /*
 while ($user_quiz_check_result = $user_quiz_check->fetch(PDO::FETCH_ASSOC)){
   array_push($ids_array,$user_quiz_check_result['id']);
 }
 */

if ((!empty($registered_user_check_result) || $quiz_result_user_name == 'guest') && $isPreviousAttempt)
 {
   $sql_update = $conn->prepare("
      UPDATE life_ins_quiz_result
          SET
            quiz_result_chapter_score = ?,
            quiz_result_chapter_avg_score = ?,
            quiz_result_attempt_count = ?,
            quiz_result_total_score = ?
          WHERE
            1 = 1
            AND quiz_result_user_name = ?
            AND quiz_result_chapter_num = ?
            ");

        for ($i = 0; $i < count($chapters_array); $i++)
        {
          if($scores_array[$i] != -1){
          $sql_update->execute(
              array($scores_array[$i],$quiz_result_chapter_avg_score,$quiz_result_attempt_count+1,
                    $quiz_result_total_score,$quiz_result_user_name,$chapters_array[$i]));
          }//end if
        }//end for
}
  //if its a guest user or registered user with no previous scores
elseif((!empty($registered_user_check_result) || $quiz_result_user_name == 'guest')  && !$user_quiz_check_result_count){
    for($i = 0; $i < count($chapters_array); $i++)
    {
       $sql_insert = "INSERT INTO life_ins_quiz_result
           (
              quiz_result_user_email,
              quiz_result_user_name,
              quiz_result_chapter_num,
              quiz_result_chapter_score,
              quiz_result_chapter_avg_score,
              quiz_result_attempt_count,
              quiz_result_total_score
           )
           VALUES
           (
             '$quiz_result_user_email',
             '$quiz_result_user_name',
             '$chapters_array[$i]',
             '$scores_array[$i]',
             '$quiz_result_chapter_avg_score',
             '$quiz_result_attempt_count + 1',
             '$quiz_result_total_score'
           )";
       $result = $conn->exec($sql_insert);
  }//end for
}//end else
 $conn = null;
 header('Location: ttii_quiz_result.php');exit();
?>
