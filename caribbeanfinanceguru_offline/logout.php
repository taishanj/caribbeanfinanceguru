<?php
// Include configuration file
require_once('header.php');
require_once(dirname(__FILE__) . '/glogin/google_auth_config.php');
unset($_SESSION['access_token']);
session_destroy();
header('location:index.php');
?>
