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
    
    public function read() {
      $query = "SELECT * FROM ". $this->table_name;
      $stmt = $this->conn->prepare($query);
      try {
        $stmt->execute();
        $rows = $stmt->rowCount();

        if($rows > 0) {
          $user_arr = array();
          $user_arr["success"] = true;
          $user_arr["message"]  = array();

          while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            array_push($user_arr["message"], $row);
          }
          return json_encode($user_arr);
        } else {
          return json_encode(array(
            "success" => false,
            "message" => "user is empty.",
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function readEmpty() {
      $query = "SELECT room.* FROM room  WHERE room.enabled = 1 AND NOT EXISTS (SELECT rent.room_id FROM rent WHERE rent.room_id = room.room_id AND rent.enabled = 1)";
      $stmt = $this->conn->prepare($query);
      try {
        $stmt->execute();
        $rows = $stmt->rowCount();

        if($rows > 0) {
          $user_arr = array();
          $user_arr["success"] = true;
          $user_arr["message"]  = array();

          while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            array_push($user_arr["message"], $row);
          }
          return json_encode($user_arr);
        } else {
          return json_encode(array(
            "success" => false,
            "message" => "room is empty.",
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

  }
?>