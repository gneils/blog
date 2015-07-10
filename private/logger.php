<?php 

// log file must exist and have permissions set to allow writing
// Example in Unix: chmod 777 errors.log

$log_file = PRIVATE_PATH . DS . 'logs' . DS . 'log.txt';

// An ultra-simple file logger
function logger($level="ERROR", $msg="") {
    global $log_file;
    if( file_exists($log_file) ) {
        if( !is_readable($log_file)) {
            die ('file not readable');
        }
    }
    $time_stamp = date("Y-m-j, H:i:s");
    
    // Ensure all messages have a final line return
    $log_msg = $time_stamp . " " . $level . ": " . $msg . PHP_EOL;
    
    // FILE_APPEND adds content to teh end of the file
    // LOCK_EX forbids writing to the file while in use by use
    file_put_contents($log_file, $log_msg, FILE_APPEND | LOCK_EX);

}

function clear_log() {
    global $log_file;
    if( file_exists($log_file) ) {
        if(is_readable($log_file)) {
            unlink($log_file);
            $msg = "Log cleared by " . $session->user_id;
            logger("Note: ", $msg);
            // redirect to this same page so that the URL won't have 
            // clear="true" anymore. Clears out parameter, good practice. 
            // Don't leave something dangerous in the URL string.
            redirect_to("logfile.php"); 
        }
    }
}

function show_log() {
    global $log_file;
    if( file_exists($log_file) ) {
        if( is_readable($log_file)) {
            $handle = fopen($log_file, "r");
            $lines = file($log_file);
            $log_txt = '<ul class="log-entries">';
            foreach ($lines as $line_num => $line ) {
                if(trim($line) != ""){
                    $log_txt .= "<li>Line #<strong>{$line_num}</strong>: ". h($line);
                }
            }
            $log_txt .= "</ul>";
        } else {
            $log_txt = "Log file could not be read.";
        }
    } else {
        $log_txt = "Log file could not be found.";
    }
    return $log_txt;
}

// Sample usage
// logger("ERROR", "An unknown error occurred");
// logger("DEBUG", "x is 1");

// echo "Logged";
// Other loggers you can try:
// https://github.com/apache/logging-log4php
// https://github.com/katzgrau/KLogger
// https://github.com/Seldaek/monolog
// https://github.com/jbroadway/analog

// Frameworks have their own logging:
// http://framework.zend.com/manual/1.12/en/zend.log.html
?>