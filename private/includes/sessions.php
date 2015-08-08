<?php
// A class to help work with Sessions
// In our case, primarily to manage logging users in and out

// Keep in mind when working with sessions that it is generally
// inadvisable to store DB-related objects in sessions

class Session {  
    
    private $logged_in;
    public $user_id;
    public $message;
    public $last_request_time;
    public $current_request_time ;
    public $time_delta;
    
    function __construct() {
        session_start();
        $this->check_login();      
        $this->check_message();
    }
    
    private function check_login() {
        if(isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
            if(isset( $_SESSION['request_time']  )) {
                $this->last_request_time = $_SESSION['request_time'];
            } else {
                $this->last_request_time = time();                
            }
            $this->current_request_time = time();
            $_SESSION['request_time'] = $this->current_request_time;
            $this->time_delta = $this->current_request_time - $this->last_request_time;
            // SERVER SIDE lOG OUT AFTER 15 MINUTES
            if($this->time_delta / 60 > 15 ){
                $this->logout();
                redirect_to(WEB_ROOT."/admin/login.php");
            }
                
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
    public function message($msg="") {
        if(!empty($msg)) {
            // then this is a "set message"
            if(isset($_SESSION["message"])) {
                $_SESSION['message'] .= $msg;
            } else {
                $_SESSION['message'] = $msg;
            }
                
        } else {
            // then this is a "get message"
            return $this->message;
        }
    }
    
    public function check_message() {
        // Is there a message stored in the session
        if(isset($_SESSION["message"])) {
            // Add it as an attribute and 
            $this ->message = $_SESSION["message"];
            // clear message after use
            unset($_SESSION["message"]);
        } else {
            $this->message ="";
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
$message = $session->message();

?>