<?php
  class Users {

    // create connection and table name first
    private $conn;
    private $table_name = "users";

    // create properties
    public $user_id;
    public $user_firstname;
    public $user_lastname;
    public $user_birthdate;
    public $user_nationallity;
    public $user_religion;
    public $user_cardnumber;
    public $user_address;
    public $user_moo;
    public $user_tumbon;
    public $user_ampor;
    public $user_province;
    public $user_zip ;
    public $user_tel;
    public $username;
    public $password;
    public $admin ;
    public $enabled;
    public $created_at ;
    public $updated_at ;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = "SELECT * FROM ". $this->table_name ." WHERE enabled = 1";
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

    public function create() {
      $query = "INSERT INTO `users` (`user_firstname`, `user_lastname`, `user_birthdate`, `user_nationallity`, `user_religion`, `user_cardnumber`, `user_address`, `user_moo`, `user_tumbon`, `user_ampor`, `user_province`, `user_zip`, `user_tel`, `username`, `password`) VALUES (:user_firstname, :user_lastname, :user_birthdate, :user_nationallity, :user_religion, :user_cardnumber, :user_address, :user_moo, :user_tumbon, :user_ampor, :user_province, :user_zip, :user_tel, :username, :password)";
        
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":user_firstname", $this->user_firstname);
      $stmt->bindParam(":user_lastname", $this->user_lastname);
      $stmt->bindParam(":user_birthdate", $this->user_birthdate);
      $stmt->bindParam(":user_nationallity", $this->user_nationallity);
      $stmt->bindParam(":user_religion", $this->user_religion);
      $stmt->bindParam(":user_cardnumber", $this->user_cardnumber);
      $stmt->bindParam(":user_address", $this->user_address);
      $stmt->bindParam(":user_moo", $this->user_moo);
      $stmt->bindParam(":user_tumbon", $this->user_tumbon);
      $stmt->bindParam(":user_ampor", $this->user_ampor);
      $stmt->bindParam(":user_province", $this->user_province);
      $stmt->bindParam(":user_zip", $this->user_zip);
      $stmt->bindParam(":user_tel", $this->user_tel);
      $stmt->bindParam(":username", $this->username);
      $stmt->bindParam(":password", $this->password);
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
      $query = "UPDATE `users` SET `user_firstname` = :user_firstname, `user_lastname` = :user_lastname, `user_lastname` = :user_lastname, `user_nationallity` = :user_nationallity, `user_religion` = :user_religion, `user_cardnumber` = :user_cardnumber, `user_address` = :user_address, `user_moo` = :user_moo, `user_tumbon`= :user_tumbon, `user_ampor`= :user_ampor, `user_province` = :user_province, `user_zip` = :user_zip, `user_tel` = :user_tel, `username` = :username, `password` = :password, `created_at` = CURRENT_TIMESTAMP WHERE `user_id` = :user_id";
        
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":user_id", $this->user_id);
      $stmt->bindParam(":user_firstname", $this->user_firstname);
      $stmt->bindParam(":user_lastname", $this->user_lastname);
      $stmt->bindParam(":user_birthdate", $this->user_birthdate);
      $stmt->bindParam(":user_nationallity", $this->user_nationallity);
      $stmt->bindParam(":user_religion", $this->user_religion);
      $stmt->bindParam(":user_cardnumber", $this->user_cardnumber);
      $stmt->bindParam(":user_address", $this->user_address);
      $stmt->bindParam(":user_moo", $this->user_moo);
      $stmt->bindParam(":user_tumbon", $this->user_tumbon);
      $stmt->bindParam(":user_ampor", $this->user_ampor);
      $stmt->bindParam(":user_province", $this->user_province);
      $stmt->bindParam(":user_zip", $this->user_zip);
      $stmt->bindParam(":user_tel", $this->user_tel);
      $stmt->bindParam(":username", $this->username);
      $stmt->bindParam(":password", $this->password);
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

    public function signin() {
      $query = "SELECT users.*, rent.rent_id, room.room_number FROM users, rent, room WHERE username=:username AND password=:password AND rent.user_id = users.user_id AND room.room_id = rent.room_id AND users.enabled = 1 AND rent.enabled = 1";

      $stmt = $this->conn->prepare($query);

      $this->username=htmlspecialchars(strip_tags($this->username));
      $stmt->bindParam(":username", $this->username);
      $this->password=htmlspecialchars(strip_tags($this->password));
      $stmt->bindParam(":password", $this->password);
      try {
        $stmt->execute();
        $finduser = $stmt->rowCount();
        if($finduser === 0) {
          return json_encode(array(
            "success" => false,
            "message" => "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง",
          ));
        } else {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          extract($row);
          return json_encode(array(
            "success" => true,
            "message" => $row,
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function admin() {
      $query = "SELECT * FROM users WHERE username=:username AND password=:password AND admin=1 AND enabled=1";

      $stmt = $this->conn->prepare($query);

      $this->username=htmlspecialchars(strip_tags($this->username));
      $stmt->bindParam(":username", $this->username);
      $this->password=htmlspecialchars(strip_tags($this->password));
      $stmt->bindParam(":password", $this->password);
      try {
        $stmt->execute();
        $finduser = $stmt->rowCount();
        if($finduser === 0) {
          return json_encode(array(
            "success" => false,
            "message" => "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง",
          ));
        } else {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          extract($row);
          return json_encode(array(
            "success" => true,
            "message" => $row,
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
      $query = "UPDATE users SET users.enabled = 0 WHERE users.user_id = :user_id AND (EXISTS (SELECT rent.user_id FROM rent WHERE rent.user_id = :user_id AND rent.enabled = 0) OR NOT EXISTS (SELECT rent.user_id FROM rent WHERE rent.user_id = :user_id AND rent.enabled = 1))";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":user_id", $this->user_id);
      try {
        $stmt->execute();
        $row = $stmt->rowCount();
        if($row === 0) {
          return json_encode(array(
            "success" => false,
            "message" => "ไม่สามารถลบผู้ใช้ได้ เนื่องจากยังไม่หมดสัญญาเช่า",
          ));
        } else {
          return json_encode(array(
            "success" => true,
            "message" => $stmt->rowCount(). " row(s) deleted.",
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function readNoRent() {
      $query = "SELECT * FROM users WHERE users.enabled = 1 AND users.admin = 0 AND NOT EXISTS (SELECT rent.user_id FROM rent WHERE rent.user_id = users.user_id AND rent.enabled = 1)";
      $stmt = $this->conn->prepare($query);
      try {
        $stmt->execute();
        $row = $stmt->rowCount();
        if($row === 0) {
          return json_encode(array(
            "success" => false,
            "message" => "ไม่มีข้อมูลผู้ใช้",
          ));
        } else {
          $user_arr = array();
          $user_arr["success"] = true;
          $user_arr["message"]  = array();

          while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            array_push($user_arr["message"], $row);
          }
          return json_encode($user_arr);
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