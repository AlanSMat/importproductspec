<?php
  class DB_CONNECT extends PDO {

  }
  class DB extends DB_CONNECT {

    private $_table_name;
    private $_table_prefix;
        
    public function __construct($server_name, $db_name, $db_username, $db_password) {
      /*$this->server_name = $server_name;
      $this->db_name     = $db_name;
      $this->db_username = $db_username;
      $this->db_password = $db_password;      
      $this->pdo         = $this->_connect();       */
    }

    public function get_table_name() {
      return $this->_table_name;
    }

    public function set_table_name($table_name) {            
      $this->_table_name   = $table_name;
      $this->_table_prefix = $this->_get_table_prefix();
    }

    private function _get_table_prefix() {
      $prefix_array = explode("_", $this->_table_name);
      $table_prefix = $prefix_array[0] . "_";
      return $table_prefix;
    }

    public function get_table_id_name() {
      return $this->_table_prefix . "id";
    }

    private function _connect() {
      try {
        $conn = new PDO("mysql:host=" . $this->server_name . ";dbname=" . $this->db_name . "", $this->db_username, $this->db_password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $conn;
        //echo "Connected successfully"; 
      }
      catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
    }

    public function fetch_objects() { 
        $obj = Array(); 
        while($val = @mysql_fetch_object($this->result)) 
        { 
            $obj[] = $val; 
        } 
        return $obj; 
    } 
  
    public function fetch_arrays() { 
        $arr = Array(); 
        while($val = @mysql_fetch_array($this->result)) 
        { 
            $arr[] = $val; 
        } 
        return $arr; 
    } 

    private function _get_table_array ($post_data) {
      
      $post_data = $this->_add_prefix_to_array($post_data);
      //var_dump($post_data);
      $table_data = array();
      
      foreach($post_data as $key => $value) {
        if(substr($key,0,4) == $this->_table_prefix) {
          $table_data[$key] = $value;        
        }                
      }	      
      return $table_data;
    }

    private function _query_string() {
      $this->_get_table_array();

      return $query_string;
    }

    //
    private function _get_db_string( $post_data ) {

      $post_data = $this->_get_table_array( $post_data );		
      
      $update_string = "";
      
      while(list($key,$value) = each( $post_data )) {			

          if(is_array($value)) {				  
            $x=0;
            while(list($key2,$value2)=each($value)) 
            {
              $val_input .= $value2;
              if($x < count($value)-1) 
              { 
                $val_input .= ",";$x++; 
              }
            }
            $columns[] = $key;
            $values[]  = $val_input;
            $x         = 0;
            $val_input  = "";
          }
          else 
          {
            $columns[] = $key;
            $values[]  = $value;
          }

      }

      $num_cols = count($columns);
      $num_vals = count($values);
      
      for($i = 0; $i < $num_cols; $i++) {        
        $update_string .= $columns[$i] . "='" . $values[$i] . "'";
      
        if($i<$num_cols-1) 
          $update_string .= ", ";	
        
      }
      
      return $update_string;
    }

    public function insert_record( $array ) {
      
      //** this is an insert, remove the id if it exists */
      if(array_key_exists("id", $array)) {
        unset($array["id"]);
      }
      
      $sql = "INSERT INTO ". $this->_table_name . " SET " . $this->_get_db_string( $array );
        
      try {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();          
        return $insert_id = $this->pdo->lastInsertId();
      }
      catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
      }
      
    }	

    public function update_record($post_data, $where_clause = false) {

      if(!$where_clause) 
      {
        echo "Error: missing WHERE clause";
        exit;
      }      

      $sql  = "UPDATE " . $this->_table_name . " SET " . $this->_get_db_string( $post_data ) . " " . $where_clause . "";
      
      try {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
      } 
      catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
      }     

    }

    public function delete_record($query) {
      try {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
      } 
      catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
      }      
    }

    //** adds a prefix to the array for the db **/
    private function _add_prefix_to_array($array) {
      
      foreach($array as $key => $value) {
        if(!strstr(strtolower($key), "submit")) {
          $db_array[$this->_table_prefix . $key] = $value;
        }        
      }  
      
      return $db_array;
    }
  }
  class DB_SELECT extends DB {

    public function select($query) {

      try {
        $stmt = PDO::prepare($query);
        $stmt->execute();
      } 
      catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
      }      

      $result = $stm->fetch(PDO::FETCH_ASSOC);
      return $result;

    }

  }
?>