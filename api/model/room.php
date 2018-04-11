<?php
  class Room {

    // create connection and table name first
    private $conn;
    private $table_name = "room";

    // create properties
    public $room_id;
    public $room_number1;
    public $enabled;
    public $created_at;
   
    public function __construct($db) {
      $this->conn = $db;
    }
    
  }
?>