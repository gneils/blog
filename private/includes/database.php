<?php
require_once(PRIVATE_PATH . "/includes/database.php");

class MySQLDatabase {
    
    private $connection;
    
    function __construct() {
        $this->open_connection();
    }

    public function open_connection() {
        $this->connection = mysqli_connect(DB_SERVER,DB_USER, DB_PASS, DB_NAME);
        if(mysqli_connect_errno()) {
            $_SESSION['message'] = "Cannot Confirm Query. Database query failed.";
            redirect_to(WEB_ROOT."/404_error.php");
            // or this way for debug
            die("Database connection failed: " .
                mysqli_connect_error() . 
                " ( ". mysqli_connect_errno() . ")"
            );
        }
    }
    
    public function close_connection() {
        if(isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }
    
    public function query($sql) {
        $result = mysqli_query($this->connection, $sql);
        $this->confirm_query($result);
        // $_SESSION['message'] .= $sql;
        // $_SESSION['message'] .= "-" . mysqli_error($this->connection);
        return $result;
    }
    
    private function confirm_query($result) {
        if(!$result) {
            $_SESSION['message'] = "Cannot Confirm Query. Database query failed.";
            redirect_to(WEB_ROOT."/404_error.php");
        }
    }
      
    // "database neutral" functions
    public function fetch_array($result_set) {
        return mysqli_fetch_array($result_set);
    }
    
    public function fetch_assoc($result_set) {
        return mysqli_fetch_assoc($result_set);
    }
    
    public function escape_value($string) {
        $escaped_string = mysqli_real_escape_string($this->connection, $string);
        return $escaped_string;
    }
    
    public function num_rows($result_set) {        
        return mysqli_num_rows($result_set);
    }
    
    public function insert_id( ) {
        // get the last id inserted over the crrent db connection
        return mysqli_insert_id($this->connection);
    }
    
    public function affected_rows() {
        return mysqli_affected_rows($this->connection);
    }
}

$database = new MySQLDatabase();
$db =& $database;
?>