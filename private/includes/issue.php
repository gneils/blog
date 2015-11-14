<?php
// If it 's going to need the database, then it's probably smart 
// to require it before we start

require_once(PRIVATE_PATH . DS . "includes" . DS . "database_object.php");

class Issue extends DatabaseObject {
    
    protected static $table_name = "issues";
    protected static $db_fields = array('id', 
                                        'description', 
                                        'priority', 
                                        'created', 
                                        'updated',
                                        'curr_status',
                                        'resolution',
                                        'submitted_by',
                                        );
    public $id;
    public $description;
    public $priority;
    public $created;
    public $updated;
    public $curr_status;
    public $resolution;
    public $submitted_by;
    
    // "new" is a keyword so you can't use it here 
    public static function make($id, 
                                $description="",
                                $submitted_by="anon",
                                $curr_status="Open"
                                ) {
        if(!empty($issue_id) && !empty($author) && !empty($body)){
            $issue = new Issue();
            $issue->issue_id = (int) $issue_id;
            $issue->created = strftime("%Y-%m-%d %H:%M:%S", time());
            $issue->updated = strftime("%Y-%m-%d %H:%M:%S", time());
            $issue->description = $description;
            $issue->curr_status = $curr_status;
            $issue->resolution = $resolution;
            
            return $issue;
        } else {
            return false;
        }
    }
    
    public static function find_comments_on($id=0) {
        global $database;
        $sql = "SELECT * FROM " . self::$table_name;
        $sql .= " WHERE id=" . $database->escape_value($id);
        $sql .= " ORDER BY created ASC";
        return self::find_by_sql($sql);
    }
    

    public function create() {
        global $database;
        // Don't forget your SQL syntax and good habits;
        // -INSERT INTO table (key, key) VALUES ('value', 'value')
        // - single-qoutes around all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        unset($attributes['id']);
        
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
        // Don't forget your SQL syntax and good habits;
        // -INSERT INTO table (key, key) VALUES ('value', 'value')
        // - single-qoutes around all values
        // - escape all values to prevent SQL injection
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
        // A new record won't have an id yet
        return isset($this->id) ? $this->update() : $this->create();
    }
    
    public function delete() {
        // Don't forget your SQL syntax and good habits;
        // -DELETE FROM table WHERE condition LIMIT 1
        // - single-qoutes around all string values
        // - escape all values to prevent SQL injection
        global $database;
        $sql  = "DELETE FROM " . self::$table_name;
        $sql .= " WHERE  id=".   $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }  
}
?>