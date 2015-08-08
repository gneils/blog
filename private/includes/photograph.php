<?php
// If it 's going to need the database, then it's probably smart 
// to require it before we start

require_once(PRIVATE_PATH . DS . "includes" . DS . "database_object.php");

class Photograph extends DatabaseObject {
    
    protected static $table_name = "photographs";
    protected static $db_fields = array('id', 'filename', 'type', 'size', 'caption', 'public', 'upload_time', 'username');
    protected static $allowed_ext = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
    public $id;
    public $filename;
    public $type;
    public $size;
    public $caption;
    public $public;
    public $upload_time;
    public $username;
           
    
    private   $temp_path;
    protected $upload_dir = "images";
    public    $errors = array();

    public function create() {
        global $database;
        // Don't forget your SQL syntax and good habits;
        // -INSERT INTO table (key, key) VALUES ('value', 'value')
        // - single-qoutes around all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        unset($attributes['id']); // this MySQL version requires that the ID value does not have qoutes.

        $sql  = "INSERT INTO " . self::$table_name ." (";
        $sql .= join(", ", array_keys($attributes));
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
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach($attribute_pairs as $key => $value) {
            $attributes_pairs[] = "{$key}='{$value}'";
        }
        
        $sql = "UPDATE " . self::$table_name ." SET ";
        $sql .=join(", ", $attribute_pairs);
        $sql .= " WHERE  id=".   $database->escape_value($this->id);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
    
    public function save() {
        // A new record won't have an id yet.
        
        if(isset($this->id)) {
            // really just to update the caption
            $this->update();
        } else {
            // Make sure there are no errors
            // Can't save if there are pre-exsisting errors 
            if(!empty($this->errors)) {
                $this->errors[] = "previous errors";
                return false;
            }
            
            // Make suer the caption is not too long for the DB
            if(strlen($this->caption) >= 255) {
                $this->errors[] = "The caption can only be 255 characters";
                return false;
            }
            // Can't save without filename and temp location
            if(empty($this->filename)) {
                $this->errors[] = "Sorry, bad file name";
                return false;
            }
            if(empty($this->temp_path)){
                $this->errors[] = "Sorry, your account is full at this time";
                return false;
            }
            // Determine the target_path
            $target_path = APP_ROOT.DS. 'public'.DS.$this->upload_dir .DS. $this->filename;
            
            // Make sure a file doesn't already exist in the target location
            if(file_exists($target_path)) {
                $this->errors[] = "The file {$this->filename} already exists.";
                return false;
            }
            // Attempt to move the file
            if(move_uploaded_file($this->temp_path, $target_path))  {
                // Success
                // Save a corresponding entry to the database
               if($this->create()) {
                    // We are done with temp_path. The file doesn't exists anymore
                    unset($this->temp_path);                 
                    return true;
                } else {
                    $this->errors[] = "The file upload succed, but the database update failed.";
                    return false;
        }
            } else {
                $this->errors[] = "The file upload failed, possibly due to incorrect permissions.";
                return false;
            }
        }
    }
    
    public function image_path() {
        return $this->upload_dir."/".$this->filename;
    }
    
    public function size_as_text() {
        if($this->size < 1024){
            return "{$this->size} bytes";
        } elseif ($this->size < 1048576){
            $size_kb = round($this->size/1024);
            return "{$size_kb}  KB";
        } else {
            $size_mb = round($this->size/1048576);
            return "{$size_mb}  MB";
        }
    }
    
    public function comments() {
        return Comment::find_comments_on($this->id);
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
    
    // Pass in $_FILE[['uploaded_file'] as an argument
    public function attach_file($file) {
        global $upload_errors;
        // Perform error checking on the form parameters
        // Error: nothing uploaded or wrong arugument usage
        if(!$file ) {
            $this->errors[] = "File not defined";
            return false;
        } elseif(empty($file)) {
            $this->errors[] = "Empty File variable";
            return false;
        } elseif( !is_array($file)) {
            $this->errors[] = "File is not array";
            return false;
        } elseif($file['error'] != 0) {
            // Error: report what PHP says went wrong
            $this->errors[] = $upload_errors[$file['error']];
            return false;
        } elseif( !in_array($file['type'],  self::$allowed_ext)){
            die ('That type of file is not allowed.');
        } else {
            // Set object attributes to the form parameters
            // Don't wory about saving anyting to the database yet.
            $this->temp_path = $file['tmp_name'];
            $this->filename  = basename($file['name']);
            $this->type      = $file['type'];
            $this->size      = $file['size'];
            return true;
        }
    }
    public function destroy (){
        // First remove the database entry
        // then remove the file
        if($this->delete()) {
            // then remove file
            // Note that even though the database entry is gone, this object,
            // is still around (which lets us use $this-image_path()).
            $target_path = PUBLIC_PATH.DS.$this->image_path();
            return unlink($target_path) ? true : false;
        } else {
            // Database delete failed
            return false;
        }
    }
}
?>