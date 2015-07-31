<?php
require_once (PRIVATE_PATH.DS.'includes'.DS.'database.php');

class User extends DatabaseObject {
    
    protected static $table_name = "users";
    protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'email');
    
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $email;

    
    public function full_name() {
        if(isset($this->first_name) && isset($this->last_name)) {
            return $this->first_name . " " . $this->last_name;
        } else {
            return "";
        }
    }
    
    public static function authenticate($username="", $password="") {
        global $database;
        self::log_auth_attempt($username, $password);
        
        $username = $database->escape_value($username);
        // $password = $database->escape_value($password);
        
        $sql = "SELECT * FROM users ";
        $sql .= "WHERE username = '{$username}' ";
        $sql .= "LIMIT 1";
        $result_array = self::find_by_sql($sql);
       
        
        if (empty($result_array)) {
            return false;
        }
        $user_object = array_shift($result_array);       
        $hashed_password = $user_object->password;
        if ( password_check( $password, $hashed_password )){
            return $user_object;
        } else {
            return false;
        }
    }
    

    public function find_user_by_id ($id="") {
        global $database;
        $id = $database->escape_value($id);
        $sql = "SELECT id, username FROM users ";
        $sql .= "WHERE id = '{$id}' ";
        $sql .= "LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? true : false;
    }
    
    
    public function find_user_by_username ($username="") {
        global $database;
        $username = $database->escape_value($username);
        $sql = "SELECT id, username FROM users ";
        $sql .= "WHERE username = '{$username}' ";
        $sql .= "LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? true : false;
    }
    
    public function create() {
        global $database;
        // Don't forget your SQL syntax and good habits;
        // -INSERT INTO table (key, key) VALUES ('value', 'value')
        // - single-qoutes around all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        
        $sql  = "INSERT INTO " . self::$table_name ." (";
        $sql .= join(", ", array_keys($attributes));
        
        // $sql .= "username, password, first_name, last_name";
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if($database->query($sql)){
            $this->id = $database->insert_id();  // make sure to get the user ID!
            return true;
        } else {
            return false;
        }
    }
    
    public function update() {
        global $database;
        // Don't forget your SQL syntax and good habits;
        // -INSERT INTO table (key, key) VALUES ('value', 'value')
        // - single-qoutes around all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach($attribute_pairs as $key => $value) {
            $attributes_pairs[] = "{$key}='{$value}'";
        }
        
        $sql = "UPDATE " . self::$table_name ." SET ";
        $sql .=join(", ", $attribute_pairs);
        /*
        $sql .= "username= '".   $database->escape_value($this->username) . "', ";
        $sql .= "password= '".   $database->escape_value($this->password) . "', ";
        $sql .= "first_name= '". $database->escape_value($this->first_name) . "', ";
        $sql .= "last_name= '".  $database->escape_value($this->last_name) . "' ";
         * 
         */
        $sql .= " WHERE  id=".   $database->escape_value($this->id);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public function save() {
        // A new record won't have an id yet
        return isset($this->id) ? $this->update() : $this->create();
    }
    
    public function delete() {
        // Don't forget your SQL syntax and good habits;
        // -DELETE FROM table WHERE condition LIMIT 1
        // - single-qoutes around all values
        // - escape all values to prevent SQL injection
        global $database;
        $sql  = "DELETE FROM " . self::$table_name;
        $sql .= " WHERE  id=".   $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public function attempt_login($username, $password) {
        global $database;
        $admin = find_admin_by_username($username);
        if ($admin) {
            if(password_check($password, $admin["password"]) ) {
                return $admin;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function logged_in() {
        return isset($_SESSION["admin_id"]);
    }

    public function confirm_logged_in() {
        if (!logged_in() ) {        
            redirect_to("login.php");
        }
    }
    
    private static function log_auth_attempt($username, $password) {
        global $database;
        $encrypted_password = password_encrypt($password);

        $stmt = $database->prepare("INSERT INTO auth_history (username, password) values (?, ?)");
        if(!$stmt) die ('prepare failed');
        
        $rc = $stmt->bind_param("ss", $username, $encrypted_password);    
        if ( false===$rc ) {die('bind_param() failed: ' . htmlspecialchars($stmt->error));}
        
        $rc = $stmt->execute();
        if ( false===$rc ) { die('execute() failed: ' . htmlspecialchars($stmt->error));}        
    }
}
?>