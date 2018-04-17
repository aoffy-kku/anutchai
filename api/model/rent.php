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

    public function create() {
      $query = "INSERT INTO `rent` (`room_id`, `user_id`) VALUES (:room_id, :user_id)";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":room_id", $this->room_id);
      $stmt->bindParam(":user_id", $this->user_id);
      try {
        $stmt->execute();
        return json_encode(array(
          "success" => true,
          "message" => $stmt->rowCount(). " row(s) inserted.",
        ));
      } catch(PDOExeption $e){
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
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
            "message" => "rent is empty.",
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function readRent() {
      $query = "SELECT rent.rent_id, users.*, room.* FROM room, users, rent WHERE rent.enabled = 1 AND users.user_id = rent.user_id AND room.room_id = rent.room_id ORDER BY room.room_number ASC";
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
            "message" => "rent is empty.",
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function delete() {
      $query = "UPDATE `rent` SET `enabled` = 0 WHERE `rent_id` = :rent_id";
        
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":rent_id", $this->rent_id);
      try {
        $stmt->execute();
        $row = $stmt->rowCount();
        if($row === 0) {
          return json_encode(array(
            "success" => false,
            "message" => "ไม่สามารถลบสัญญาได้",
          ));
        } else {
          return json_encode(array(
            "success" => true,
            "message" => $stmt->rowCount(). " row(s) deleted.",
          ));
        }
      } catch(PDOExeption $e){
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

  }
?>