<?php 

// ---------------------------------------------
// Make sanitizing easy and you will do it often
// Sanitize for HTML output 
function h($string) {
	return htmlspecialchars($string);
}

// Sanitize for JavaScript output
function j($string) {
	return json_encode($string);
}

// Sanitize for use in a URL
function u($string) {
	return urlencode($string);
}
// Remove HTML entities
function s($string) {
    return strip_tags($string);
}

?>