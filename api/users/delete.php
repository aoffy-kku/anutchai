<?php
    require_once("../config/post_header.php");
    include_once("../config/database.php");

    include_once("../model/users.php");

    $database = new Database();
    $db = $database->getConnection();

    $users = new Users($db);

    extract($_POST);
    $users->user_id = $user_id;

    // print_r($_POST);
    // print_r($users);

    $result = $users->delete();
    echo $result;
?>