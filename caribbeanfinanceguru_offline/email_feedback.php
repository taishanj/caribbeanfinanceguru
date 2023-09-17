<?php
//feedback Email
if($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$firstname = test_input($_POST['firstname']);
	$lastname = test_input($_POST['lastname']);
	$receiver = test_input($_POST['email']);
  $country =  test_input($_POST['country']);
  $comment = $_POST['comment'];

}
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$subject = "$firstname $lastname feedback";
$body = "$comment";

//Validate first (necessary??)
if(empty($firstname)||empty($receiver))
{
    echo "Name and email are mandatory!";
    exit;
}

//malicious attempt
if(IsInjected($receiver))
{
    echo "Bad email value!";
    exit;
}

//if(mail($receiver, $subject, $body, $sender,$headers)){
if(mail($receiver, $subject, $body,$headers)){
    echo "Email sent successfully to $receiver";
}else{
    echo "Sorry, failed while sending mail!";
}


function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}//end function IsInjected
header('Location: finanalysis.php');exit();
?>
