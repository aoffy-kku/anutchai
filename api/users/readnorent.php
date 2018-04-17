<?php
  require_once("../config/post_header.php");

  include_once("../config/database.php");

  include_once("../model/users.php");

  $database = new Database();
  $db = $database->getConnection();

  $users = new Users($db);
  
  $result = $users->readNoRent();

  echo $result;
?>