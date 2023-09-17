<?php
require_once(dirname(__FILE__) . '/db_connection/dbconn.php');
class DB {
  /*
    private $dbHost     = "DB_HOST";
    private $dbUsername = "DB_USERNAME";
    private $dbPassword = "DB_PASSWORD";
    private $dbName     = "DB_NAME";
*/
/*
    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }
*/

    public function get_user($id) {
      $sql = $conn->prepare("SELECT * FROM registered_user WHERE registered_user_google_uid = '$id'");
      $sql->execute();
      $sql_guid_find = $sql->fetch(PDO::FETCH_ASSOC);
      return $sql_guid_find;
    }

    public function upsert_user($arr_data = array()) {
        $uid = $arr_data['sub'];
        $name = $arr_data['name'];
        $email = $arr_data['email'];
        $picture = $arr_data['picture'];

        // check if user exists by fetching it's details
        $user = $this->get_user($uid);

        if(!$user) {
            // insert the user
            $this->db->query("INSERT INTO users(google_uid, name, email, picture) VALUES('$uid', '$name', '$email', '$picture')");
        } else {
            // update the user
            $this->db->query("UPDATE users SET name = '$name', email = '$email', picture = '$picture' WHERE google_uid = '$uid'");
        }
    }
}
