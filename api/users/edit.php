<?php
    require_once("../config/post_header.php");
    include_once("../config/database.php");

    include_once("../model/users.php");

    $database = new Database();
    $db = $database->getConnection();

    $users = new Users($db);

    extract($_POST);
    $users->user_id = $user_id;
    $users->user_firstname = $user_firstname;
    $users->user_lastname = $user_lastname;
    $users->user_birthdate = $user_birthdate;
    $users->user_nationallity = $user_nationallity;
    $users->user_religion = $user_religion;
    $users->user_cardnumber = $user_cardnumber;
    $users->user_address = $user_address;
    $users->user_moo = $user_moo;
    $users->user_tumbon = $user_tumbon;
    $users->user_ampor = $user_ampor;
    $users->user_province = $user_province;
    $users->user_zip = $user_zip;
    $users->user_tel = $user_tel;
    $users->username = $username;
    $users->password = $password;

    // print_r($_POST);
    // print_r($users);

    $result = $users->edit();
    echo $result;
?>