<?php
require_once(PRIVATE_PATH . "/includes/database.php");

class DatabaseObject {
    
    public static function find_all() {
        return static::find_by_sql("SELECT * FROM ". static::$table_name);
    }
        
    public static function find_by_id($id=0) {
        $result_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function find_by_sql($sql="") {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();

        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }

    private static function instantiate($record) {
        // could check that $record exists and is an array 
        // simple, long-form approach:
        $object = new static;
//        $object->id         = $record['id'];
//        $obejct->username   = $record['username'];
//        $object->password   = $record['password'];
//        $object->first_name = $record['first_name'];
//        $object->last_name  = $record['last_name'];
//        return $object;
        
        // More dynamic, short-form approach:
        foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)){
                $object->$attribute = $value;
            }
        }
        return $object;
    }
    
    protected function attributes() {
        // return an array of attribute keys and their values
        // return get_object_vars($this);
        $attributes = array();
        foreach(static::$db_fields as $field) {
            if(property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }
    protected function sanitized_attributes() {
        global $database;
        $clean_attributes = array();
        // sanitize the value before submitting
        // Note: does not alter the actual value of each attribute
        foreach($this->attributes() as $key => $value) {
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }
    
    private function has_attribute($attribute){
        // get_object_vars returns an associative array with all attributes
        // (incl. private ones!) as the keys and their current values as the value
        $object_vars = $this->attributes();
        // We don't care about the value, we just want to know if the key exists
        // Will return true or false
        return array_key_exists($attribute, $object_vars);
    }
    
    public function mysql_prep($string) {
        global $database;
        if($database) {
            return $database->escape_value($string);
       } else {
           // addslashes is almost the same, but not quite as secure.
           // Fallback only when there is no database connection available. 
           return addslashes($string);
        }
    }
    
}
?>