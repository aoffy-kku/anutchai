<?php
  class Expenses {

    // create connection and table name first
    private $conn;
    private $table_name = "expenses";

    // create properties
    public $exp_id;
    public $rent_id;
    public $p_room;
    public $u_electricity;
    public $u_water;
    public $p_electricity;
    public $p_water;
    public $status;
    public $created_at;
    public $updated_at;
   
     public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = "SELECT * FROM ". $this->table_name . " WHERE rent_id=:rent_id ORDER BY created_at DESC";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":rent_id", $this->rent_id);
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
            "message" => "ไม่มีข้อมูลค่าใช้จ่าย",
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function readById() {
      $query = "SELECT * FROM ". $this->table_name . " WHERE rent_id=:rent_id AND exp_id = :exp_id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":rent_id", $this->rent_id);
      $stmt->bindParam(":exp_id", $this->exp_id);
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
            "message" => "ไม่มีข้อมูลค่าใช้จ่าย",
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
      $query = "SELECT expenses.*, room.* FROM rent, expenses, room WHERE rent.enabled = 1 AND expenses.rent_id = rent.rent_id AND rent.room_id = room.room_id ORDER BY expenses.created_at DESC";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":rent_id", $this->rent_id);
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
            "message" => "ไม่มีข้อมูลค่าใช้จ่าย",
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function create() {
      $query = "INSERT INTO `expenses` (`rent_id`, `p_room`, `u_electricity`, `p_electricity`, `u_water`, `p_water`) VALUES (:rent_id, :p_room, :u_electricity, :p_electricity, :u_water, :p_water)";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":rent_id", $this->rent_id);
      $stmt->bindParam(":p_room", $this->p_room);
      $stmt->bindParam(":u_electricity", $this->u_electricity);
      $stmt->bindParam(":p_electricity", $this->p_electricity);
      $stmt->bindParam(":u_water", $this->u_water);
      $stmt->bindParam(":p_water", $this->p_water);
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

    public function edit() {
      $query = "UPDATE `expenses` SET `p_room` = :p_room, `u_electricity` = :u_electricity, `p_electricity` = :p_electricity, `u_water` = :u_water, `p_water` = :p_water, `status` = :status, `updated_at` = CURRENT_TIMESTAMP WHERE `exp_id` = :exp_id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":exp_id", $this->exp_id);
      $stmt->bindParam(":p_room", $this->p_room);
      $stmt->bindParam(":u_electricity", $this->u_electricity);
      $stmt->bindParam(":p_electricity", $this->p_electricity);
      $stmt->bindParam(":u_water", $this->u_water);
      $stmt->bindParam(":p_water", $this->p_water);
      $stmt->bindParam(":status", $this->status);
      try {
        $stmt->execute();
        return json_encode(array(
          "success" => true,
          "message" => $stmt->rowCount(). " row(s) updated.",
        ));
      } catch(PDOExeption $e){
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

  }
?>