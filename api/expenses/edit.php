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

  extract($_POST);
  $expenses->exp_id = $exp_id;
  $expenses->p_room = $p_room;
  $expenses->u_electricity = $u_electricity;
  $expenses->u_water = $u_water;
  $expenses->p_electricity = $p_electricity;
  $expenses->p_water = $p_water;
  $expenses->status = $status;
  $result = $expenses->edit();
  
  echo $result;

?>