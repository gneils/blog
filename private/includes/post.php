<?php
// If it 's going to need the database, then it's probably smart 
// to require it before we start

require_once(PRIVATE_PATH . DS . "includes" . DS . "database_object.php");

class Post extends DatabaseObject {
    
    protected static $table_name = "posts";
    protected static $db_fields = array('id', 
                                        'person', 
                                        'event_date', 
                                        'created',
                                        'title',
                                        'description', 
                                        'author',
                                        'tags', 
                                        'slug', 
                                        'rating',
                                        'public',
                                        'visible');
    public $id;
    public $person;
    public $persons;
    public $event_date;
    public $created;
    public $title;
    public $description;
    public $author;
    public $tags;
    public $slug;
    public $rating;
    public $public;
    public $visible;
    public $nav;
    
    // "new" is a keyword so you can't use it here 
    public static function make($post_id, $author="Anonymous", $body="") {
        if(!empty($post_id) && !empty($author) && !empty($body)){
            $post = new Post();
            $post->post_id = (int) $post_id;
            $post->created = strftime("%Y-%m-%d %H:%M:%S", time());
            $post->author = $author;
            $post->body = $body;
            return $post;
        } else {
            return false;
        }
    }
    
    public static function find_comments_on($post_id=0) {
        global $database;
        $sql = "SELECT * FROM " . self::$table_name;
        $sql .= " WHERE post_id=" . $database->escape_value($post_id);
        $sql .= " ORDER BY created ASC";
        return self::find_by_sql($sql);
    }
    
    public static function get_all_persons() {
        global $database;
        $sql = "SELECT person FROM " . self::$table_name;
        $sql .= " GROUP BY person";
        $result_set = self::find_by_sql($sql);
        $persons=[]; 
        foreach ($result_set as $key => $value ) {
            foreach ($value as $column => $that) {
                if ($column =='person'){array_push($persons,$that);}
            }
        }
        return $persons;
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
        // - single-qoutes around all values
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