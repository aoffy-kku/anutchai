<?php
  class Users {

    // create connection and table name first
    private $conn;
    private $table_name = "users";

    // create properties
    public $user_id;
    public $user_firstname;
    public $user_lastname;
    public $user_brithdate;
    public $user_nationally;
    public $user_religion;
    public $user_cardnumber;
    public $user_address;
    public $user_moo;
    public $user_tumbon;
    public $user_ampor;
    public $user_provice;
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

    public function create() {
      $query = "INSERT INTO `user` 
      (`username`, `password`, `personal_id`, `personal_image`, `flname`, `email`, `birthday`, `question1`, `answer1`, `question2`, `answer2`, `question3`, `answer3`, `created_at`, `updated_at`) 
      VALUES 
      (:username, :password, :personal_id, :personal_image, :flname, :email, :birthday, :question1, :answer1, :question2, :answer2, :question3, :answer3, NOW(), NOW())";
        
      $stmt = $this->conn->prepare($query);

      $this->username=htmlspecialchars(strip_tags($this->username));
      $this->password=htmlspecialchars(strip_tags($this->password));
      $this->personal_id=htmlspecialchars(strip_tags($this->personal_id));
      $this->personal_image=htmlspecialchars(strip_tags($this->personal_image));
      $this->flname=htmlspecialchars(strip_tags($this->flname));
      $this->email=htmlspecialchars(strip_tags($this->email));
      $this->birthday=htmlspecialchars(strip_tags($this->birthday));
      $this->question1=htmlspecialchars(strip_tags($this->question1));
      $this->answer1=htmlspecialchars(strip_tags($this->answer1));
      $this->question2=htmlspecialchars(strip_tags($this->question2));
      $this->answer2=htmlspecialchars(strip_tags($this->answer2));
      $this->question3=htmlspecialchars(strip_tags($this->question3));
      $this->answer3=htmlspecialchars(strip_tags($this->answer3));

      $stmt->bindParam(":username", $this->username);
      $stmt->bindParam(":password", $this->password);
      $stmt->bindParam(":personal_id", $this->personal_id);
      $stmt->bindParam(":personal_image", $this->personal_image);
      $stmt->bindParam(":flname", $this->flname);
      $stmt->bindParam(":email", $this->email);
      $stmt->bindParam(":birthday", $this->birthday);
      $stmt->bindParam(":question1", $this->question1);
      $stmt->bindParam(":answer1", $this->answer1);
      $stmt->bindParam(":question2", $this->question2);
      $stmt->bindParam(":answer2", $this->answer2);
      $stmt->bindParam(":question3", $this->question3);
      $stmt->bindParam(":answer3", $this->answer3);
      
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
  }
?>