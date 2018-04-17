<?php
  class Report {

    // create connection and table name first
    private $conn;
    private $table_name = "report";

    // create properties
    public $report_id;
    public $rent_id;
    public $detail;
    public $created_at;
    public $updated_at;
    public $status;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function create() {
      $query = "INSERT INTO `report` (`rent_id`, `detail`) VALUES (:rent_id, :detail)";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":rent_id", $this->rent_id);
      $stmt->bindParam(":detail", $this->detail);      
      try {
        $stmt->execute();
        $rows = $stmt->rowCount();

        if($rows > 0) {
          $user_arr = array();
          $user_arr["success"] = true;
          $user_arr["message"]  = "รายงานถูกส่งแล้ว";
          return json_encode($user_arr);
        } else {
          return json_encode(array(
            "success" => false,
            "message" => "ไม่สามารถส่งรายงานได้",
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function read() {
      $query = "SELECT room.*, report.* FROM room, report, rent WHERE rent.enabled = 1 AND rent.rent_id = report.rent_id AND room.room_id = rent.room_id ORDER BY report.created_at DESC";
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
            "message" => "report is empty.",
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