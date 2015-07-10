<?php 
// signed cookie example

function sign_string($string) {
    // Using $slat makes it hard to guess how $checksum is generated
    // Caution: changing slat will invalidate all signed strings
    GLOBAL $salt;
    $checksum = sha1($string.$salt); // Any hash algorithm would work
    // return the string with the checksum at the end
    return $string.'--'.$checksum;
}

function signed_string_is_valid($signed_string) {
    $cookie_array = explode('--', $signed_string);
    
    if(count($cookie_array ) !=2) {
        // string is malformed or not signed
        return false;
    }
    
    // Sign the string portion again.  Should create same 
    // checksum and therefore the same isgned string.
    $new_signed_string = sign_string($cookie_array [0]);
    if($new_signed_string == $signed_string) {
        return true;
    } else {
        return false;
    }
}