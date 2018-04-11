<?php
  class Rent {

    // create connection and table name first
    private $conn;
    private $table_name = "rent";

    // create properties
    public $rent_id;
    public $user_id;
    public $room_id;
    public $enabled_at;
    public $created_at;
    public $updated_at;
    public function __construct($db) {
      $this->conn = $db;
    }
    
  }
?>