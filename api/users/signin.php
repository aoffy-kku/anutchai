<?php
  require_once("../config/post_header.php");

  include_once("../config/database.php");

  include_once("../model/users.php");

  $database = new Database();
  $db = $database->getConnection();

  $users = new Users($db);

  //$data = json_decode(file_get_contents("php://input"));
  extract($_POST);
  $users->username = $username;
  $users->password = $password;
  
  $result = $users->signin();

  echo $result;
?>