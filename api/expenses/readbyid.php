<?php
  // require important headr
  include_once("../config/get_header.php");

  // get database connection
  include_once("../config/database.php");

  // get model
  include_once("../model/expenses.php");
  
  // create object database
  $database = new Database();

  // get connection from database
  $db = $database->getConnection();

  // create object user with database connection
  $expenses = new Expenses($db);

  extract($_GET);
  $expenses->exp_id = $exp_id;
  $expenses->rent_id = $rent_id;
  $result = $expenses->readById();
  
  echo $result;

?>