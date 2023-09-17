<?php
session_start();
$chaptersChoice = [];
if(isset($_POST['submit'])){
  // Fetching variables of the form which travels in URL
  $_SESSION['chaptersChoice'] = $_POST['hidden_field'];
  $chaptersChoice = json_decode($_SESSION['chaptersChoice']);
  var_dump($chaptersChoice);
}
