<?php
  // require important headr
  include_once("../config/get_header.php");

  // get database connection
  include_once("../config/database.php");

  // get model
  include_once("../model/rent.php");
  
  // create object database
  $database = new Database();

  // get connection from database
  $db = $database->getConnection();

  // create object user with database connection
  $rent = new Rent($db);

  extract($_POST);
  $rent->rent_id = $rent_id;

  $result = $rent->delete();
  
  echo $result;

?>