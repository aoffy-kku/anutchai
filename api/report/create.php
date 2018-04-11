<?php
    require_once("../config/post_header.php");
    include_once("../config/database.php");

    include_once("../model/report.php");

    $database = new Database();
    $db = $database->getConnection();

    $report = new Report($db);

    extract($_POST);

    $report->rent_id = (int)$rent_id;
    $report->detail = $detail;
    
   
    $result = $report->create();
    echo $result;
?>