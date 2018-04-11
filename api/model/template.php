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
    
  }
?>