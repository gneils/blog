<?php
// A class to help work with Sessions
// In our case, primarily to manage logging users in and out

// Keep in mind when working with sessions that it is generally
// inadvisable to store DB-related objects in sessions

class Session {  
    
    private $logged_in;
    public $user_id;
    
    function __construct() {
        session_start();
        $this->check_login();      
    }
    
    private function check_login() {
        if(isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }
    
    public function is_logged_in() {
        return $this->logged_in;
    }
    
    public function login($user) {
        // database should find user based on username/password
        if($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->logged_in = true;
        }
    }
    
    public function logout() {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->logged_in = false;
    }
    
    /* Session Functions */
    public function message() {
        if(isset($_SESSION["message"])) {
            $output = "<div class=\"message\">";
            $output .= htmlentities($_SESSION["message"]);
            $output .= "</div>";
            // clear message after use
            $_SESSION["message"] = null;

            return $output;
        }
    }

    public function errors() {
        if (isset($_SESSION["errors"])) {
            $output = "<div class=\"row error\">";
            $output .="<div class=\"col-md-10 col-md-offset-1\"";
            $output .= "Please fix the following errors:";
            $output .= "<ul>";
            $errors = $_SESSION["errors"];
          
            foreach ($errors as $key => $error) {
                $output .= "<li>";
                $output .= h($error);
                $output .= "</li>";
            } 
            $output .= "</ul>";
            $output .= "</div>";
            $output .= "</div>";
            // clear errors after use
            $_SESSION["errors"] = null;
            return $output;
        } else {
            return NULL;
        }
    }
 }

$session = new Session();

?>