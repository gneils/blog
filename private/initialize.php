<?php

// Perform all initialization here, in private
// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
defined("DS") ? null: define("DS", DIRECTORY_SEPARATOR);

defined("SITE_ROOT") ? null : define("SITE_ROOT", DS . "blog");

defined("WEB_ROOT") ? null : define("WEB_ROOT", "/blog/public");

// Set constant to easily reference public and private directories


define("APP_ROOT", dirname(dirname(__FILE__)));

define("PRIVATE_PATH", APP_ROOT . DS . "private");
define("PUBLIC_PATH", APP_ROOT . DS . "public");

require_once(PRIVATE_PATH . DS . "logger.php");
require_once(PRIVATE_PATH . DS . "config.php");
require_once(PRIVATE_PATH . DS . "constants.php");

require_once(PRIVATE_PATH . DS . "includes" . DS . "functions.php");
require_once(PRIVATE_PATH . DS . "includes" . DS . "php_error.php");

require_once(PRIVATE_PATH . DS . "includes" . DS . "sessions.php");
require_once(PRIVATE_PATH . DS . "includes" . DS . "database.php");
require_once(PRIVATE_PATH . DS . "includes" . DS . "database_object.php");
require_once(PRIVATE_PATH . DS . "includes" . DS . "pagination.php");

require_once(PRIVATE_PATH . DS . "includes" . DS . "user.php");
require_once(PRIVATE_PATH . DS . "includes" . DS . "photograph.php");
require_once(PRIVATE_PATH . DS . "includes" . DS . "comment.php");
require_once(PRIVATE_PATH . DS . "includes" . DS . "post.php");

require_once(PRIVATE_PATH . DS . "security" . DS . "validations.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "sanitize_functions.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "csrf_token_functions.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "xss_sanitize_functions.php");
// require_once(PRIVATE_PATH . DS . "security" . DS . "sqli_escape_functions.php");  // now included in database object
require_once(PRIVATE_PATH . DS . "security" . DS . "request_forgery_functions.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "cookies_encrypt_functions.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "cookies_signed_functions.php");
require_once(PRIVATE_PATH . DS . "security" . DS . "session_hijacking_functions.php");

$salt = 'this is the value of my salt';

?>