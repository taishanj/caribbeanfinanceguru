<?php
session_start();
require_once(dirname(__FILE__) . '/db_connection/dbconn.php');
require_once(dirname(__FILE__) . '/function_library/functionlib.php');
require_once(dirname(__FILE__) . '/report_library/reportlib.php');
require_once(dirname(__FILE__) . '/report_library/contact_options.php');
require_once(dirname(__FILE__) . '/classes/currency_format.php');
require_once(dirname(__FILE__) . '/glogin/vendor/autoload.php');
require_once(dirname(__FILE__) . '/glogin/google_auth_config.php');
require_once('post_registration_data.php');

$is_logged_in = false;
$name = "guest";
$email = "guest_email";

$clientID = constant('GOOGLE_CLIENT_ID');
$clientSecret = constant('GOOGLE_CLIENT_SECRET');
$redirectUrl  = constant('GOOGLE_REDIRECT_URL');
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUrl);
$client->addScope('profile');
$client->addScope('email');

//Creating client request to google
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUrl);
$client->addScope('profile');
$client->addScope('email');

if(isset($_SESSION['access_token'])) { // Check if user is already logged in
  $client->setAccessToken($_SESSION['access_token']);
  $gauth = new Google_Service_Oauth2($client);
  $google_info = $gauth->userinfo->get();
  $email = $google_info->email;
  $name = $google_info->name;
  $_SESSION['visit_user_name'] = $name;
  $_SESSION['visit_user_email'] = $email;
  post_registered_user($name,$email);

  $logged_in_user = "<a href='#'>" . $name ."</a>";
  $is_logged_in = true;
} elseif(isset($_GET['code'])) { // Check if user is logging in
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  if(isset($token['access_token'])) {
    $_SESSION['access_token'] = $token; // Store access token in PHP session
    $client->setAccessToken($token);
    $gauth = new Google_Service_Oauth2($client);
    $google_info = $gauth->userinfo->get();
    $email = $google_info->email;
    $name = $google_info->name;
    $_SESSION['visit_user_name'] = $name;
    $_SESSION['visit_user_email'] = $email;
    //Post new users to registered_user table
    post_registered_user($name,$email);
    $logged_in_user = "<a href='#'>" . $name ."</a>";
    $is_logged_in = true;
  } else {
    echo "Error: Unable to fetch access token from Google";
  }
} else {
    $logged_in_user = "<a href='" . $client->createAuthUrl() . "'<i class='fa fa-fw fa-user'></i></a>";
}

?>
<!--Created: 26/12/2021-->
<html>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/navbar.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>
</head>

<body>
  <!-- wrapper navbar -->
  <div class="navbar">
    <div class="navbar__inner">
      <ul class="navbar__inner_list">
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><?php if($is_logged_in){ echo "<a href='ttii_user_dashboard.php'>Dashboard</a>"; }else{ echo "";} ?></li>
        <li><?php echo $logged_in_user; ?></a></li>
        <li><?php if($is_logged_in){ echo "<a href='logout.php'>Logout</a>"; }else{ echo "";}?></li>
      <!--  <li><?php //if(str_contains($_SERVER['PHP_SELF'], 'ttii_quiz') && $is_logged_in){ echo "<a href='ttii_user_dashboard.php'>Dashboard</a>"; }else{ echo "";} ?></li>-->

      <!--  <li><?php //if(str_contains($_SERVER['PHP_SELF'], 'ttii_quiz')){echo $logged_in_user;} ?></a></li>-->
      </ul>
    </div>
    <!-- for small screen view -->
    <div class="btn_mobile">
      <div class="btn_mobile_inner">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>

<!-- side bar -->
<div class="sidebar">
  <div class="sidebar_inner">
    <div class="sidebar_close justify-content-end align-items-center">
      <div class="sidebar_close_inner justify-content-center align-items-center">
        <span></span>
        <span></span>
      </div>
    </div>
    <ul class="side_list">
      <li><a href="index.php" class="active">Home</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">About</a></li>
      <li><?php if($is_logged_in){ echo "<a href='ttii_user_dashboard.php'>Dashboard</a>"; }else{ echo "";} ?></li>
      <li><?php echo $logged_in_user; ?></a></li>
    </ul>
  </div>
</div>
  <!-- bg sidebar -->
  <div class="sidebar-bg"></div>
  <script>
$(document).ready(function() {

  /////// making navbar
  $(".btn_mobile_inner").on('click', function() {
    $(".sidebar").removeClass("removeside");
    $(".sidebar").addClass("activeside");
    $(".sidebar-bg").css("display", "block");
  })
  $('.sidebar_close_inner').on('click', function() {
    $(".sidebar").removeClass("activeside");
    $(".sidebar").addClass("removeside");
    $(".sidebar-bg").css("display", "none");
  })

});
  </script>

</body>

</html>
