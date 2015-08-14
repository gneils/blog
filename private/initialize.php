<?php

// Perform all initialization here, in private
// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
defined("DS") ? null: define("DS", DIRECTORY_SEPARATOR);

defined("SITE_ROOT") ? null : define("SITE_ROOT", dirname(dirname(__FILE__)));

defined("WEB_ROOT") ? null : define("WEB_ROOT", "/blog/public");

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'private'.DS.'includes');


// Set constant to easily reference public and private directories
define("PRIVATE_PATH", SITE_ROOT . DS . "private");
define("PUBLIC_PATH", SITE_ROOT . DS . "public");

require_once(PRIVATE_PATH . DS . "logger.php");
// load config files first
require_once(PRIVATE_PATH . DS . "config.php");
require_once(PRIVATE_PATH . DS . "constants.php");

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS."functions.php");

require_once(LIB_PATH.DS."php_error.php");

// load core objects
require_once(LIB_PATH.DS."sessions.php");
require_once(LIB_PATH.DS."database.php");
require_once(LIB_PATH.DS."database_object.php");
require_once(LIB_PATH.DS."pagination.php");

// Load database related classes
require_once(LIB_PATH.DS."user.php");
require_once(LIB_PATH.DS."photograph.php");
require_once(LIB_PATH.DS."comment.php");
require_once(LIB_PATH.DS."post.php");
require_once(LIB_PATH.DS."issue.php");

require_once(PRIVATE_PATH . DS . "security" . DS . "validations.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "sanitize_functions.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "csrf_token_functions.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "xss_sanitize_functions.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "request_forgery_functions.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "cookies_encrypt_functions.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "cookies_signed_functions.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "session_hijacking_functions.php");

// PHPMailer
require_once (PRIVATE_PATH . DS . "includes" . DS . "PHPMailer/PHPMailerAutoload.php");


$salt = 'this is the value of my salt';

?>