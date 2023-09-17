<?php
session_start(); // Start PHP session
require_once(dirname(__FILE__) . '/db_connection/dbconn.php');
require_once(dirname(__FILE__) . '/function_library/functionlib.php');
require_once(dirname(__FILE__) . '/report_library/reportlib.php');
require_once(dirname(__FILE__) . '/report_library/contact_options.php');
require_once(dirname(__FILE__) . '/classes/currency_format.php');
require_once(dirname(__FILE__) . '/glogin/vendor/autoload.php');
require_once(dirname(__FILE__) . '/glogin/google_auth_config.php');

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

  echo "Welcome " . $name . ". You are logged in as " . $email;
} elseif(isset($_GET['code'])) { // Check if user is logging in
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  if(isset($token['access_token'])) {
    $_SESSION['access_token'] = $token; // Store access token in PHP session
    $client->setAccessToken($token);
    $gauth = new Google_Service_Oauth2($client);
    $google_info = $gauth->userinfo->get();
    $email = $google_info->email;
    $name = $google_info->name;

    echo "Welcome " . $name . ". You are logged in as " . $email;
  } else {
    echo "Error: Unable to fetch access token from Google";
  }
} else {
  echo "<a href='" . $client->createAuthUrl() . "'>Google Login </a>";
}
