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

  }
?>