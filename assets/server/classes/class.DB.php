<?php
class DB_CONNECT extends PDO
{

  protected $pdo;

  public function __construct()
  {
    $this->pdo = $this->connect();
  }

  public static function connect()
  {

    try {
      $conn = new PDO(
        "mysql:host=" . DB_SERVER_NAME . ";dbname=" .
          DB_NAME . "",
        DB_USERNAME,
        DB_PASSWORD
      );
        // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully"; 
      return $conn;
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }
}

class DB_VARIABLES
{

  protected $pdo;

  public function __construct($table_name, $post_array)
  {
    $this->table_name = $table_name;
    $this->post_array = $this->clean_post_array($post_array);
    $this->pdo = DB_CONNECT::connect();
    $this->table_prefix = $this->get_table_prefix();
  }
    
    /* remove non relevant fields from the post array, e.g. submit */
  protected function clean_post_array($post_array)
  {

    $fields_to_remove = array(
      "submit",
      "id",
      "generate_shipping_quote",
      "add_product"
    );
    $cleansed_array = $post_array;

    foreach ($fields_to_remove as $field) {
      if (array_key_exists($field, $cleansed_array)) {
        unset($cleansed_array[$field]);
      }
    }

    return $cleansed_array;
  }

  protected function get_table_prefix()
  {
    $prefix_array = explode("_", $this->table_name);
    $table_prefix = $prefix_array[0] . "_";
    return $table_prefix;
  }

  protected function get_table_id_name()
  {
    return $this->table_prefix . "id";
  }

  private function _get_table_array()
  {

    $post_data = $this->_add_prefix_to_array($this->post_array);
    $table_data = array();

    foreach ($post_data as $key => $value) {
      if (substr($key, 0, 4) == $this->table_prefix) {
        $table_data[$key] = $value;
      }
    }
    return $table_data;
  }

  protected function get_db_string()
  {

    $post_data = $this->_get_table_array();

    $db_string = "";

    while (list($key, $value) = each($post_data)) {

      if (is_array($value)) {
        $x = 0;
        while (list($key2, $value2) = each($value)) {
          $val_input .= $value2;
          if ($x < count($value) - 1) {
            $val_input .= ",";
            $x++;
          }
        }
        $columns[] = $key;
        $values[] = $val_input;
        $x = 0;
        $val_input = "";
      } else {
        $columns[] = $key;
        $values[] = $value;
      }

    }

    $num_cols = count($columns);
    $num_vals = count($values);

    for ($i = 0; $i < $num_cols; $i++) {
      $db_string .= $columns[$i] . "=:" . (str_replace($this->get_table_prefix(), "", $columns[$i])) . "";

      if ($i < $num_cols - 1)
        $db_string .= ", ";

    }
    return $db_string;
  }

    //** adds a prefix to the array for the db **/
  private function _add_prefix_to_array($array)
  {

    foreach ($array as $key => $value) {
      if (!strstr(strtolower($key), "submit")) {
        $db_array[$this->table_prefix . $key] = $value;
      }
    }
    return $db_array;
  }
}

class DB_INSERT extends DB_VARIABLES
{

  public function __construct($table_name, $post_array)
  {
    $this->table_name = $table_name;
    $this->post_array = $post_array;
    $this->db_variables = parent::__construct($table_name, $this->post_array);
    $this->insert_id = $this->insert_record();
  }

  public function insert_record()
  {

    $sql = "INSERT INTO " . $this->table_name . " SET " . parent::get_db_string();

    echo $sql;

    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($this->post_array);
      return $insert_id = $this->pdo->lastInsertId();
    } catch (Exception $e) {
      echo 'Message: ' . $e->getMessage();
    }
    finally {
      $this->pdo = null;
    }

  }

  public function insert_id()
  {
    return $this->insert_id;
  }


}

class DB_UPDATE extends DB_VARIABLES
{

  public function __construct($table_name, $post_array, $where_clause = false)
  {

    $this->table_name = $table_name;
    $this->post_array = $post_array;
    $this->db_variables = parent::__construct($table_name, $this->post_array);
    $this->where_clause = $where_clause;
    $this->update_record();

  }

  public function update_record()
  {

    if (!$this->where_clause) {
      echo "Error: missing WHERE clause";
      exit;
    }

    $sql = "UPDATE " . $this->table_name . " SET " . parent::get_db_string($this->post_array) . " " . $this->where_clause . "";
     
      //echo $sql;

    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($this->post_array);
    } catch (Exception $e) {
      echo 'Message: ' . $e->getMessage();
    }
    finally {
      $this->pdo = null;
    }
  }

}

class DB_DELETE extends DB_VARIABLES
{

  public function __construct($query)
  {
    $this->query = $query;
    $this->pdo = DB_CONNECT::connect();
    $this->delete_record();
  }

  public function delete_record()
  {
    try {
      $stmt = $this->pdo->prepare($this->query);
      $stmt->execute();
    } catch (Exception $e) {
      echo 'Message: ' . $e->getMessage();
    }
    finally {
      $this->pdo = null;
    }
  }
}

class DB_SELECT
{

  public function __construct($query)
  {
    $this->pdo = DB_CONNECT::connect();
    $this->query = $query;

  }

  public function result()
  {

    try {
      $stmt = $this->pdo->prepare($this->query);
      $stmt->execute();
    } catch (Exception $e) {
      echo 'Message: ' . $e->getMessage();
    }

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;

  }

    // get column names and return them in the key in an associative array, value is set to ""
  public function get_form_data($table_name)
  {
    $this->table_name = $table_name;

    $raw_column_data = $this->_get_raw_column_data();

    $field_names = array();

    for ($i = 0; $i < count($raw_column_data); $i++) {
      isset($this->result()[0][$raw_column_data[$i]["Field"]]) ? $field_value = $this->result()[0][$raw_column_data[$i]["Field"]] : $field_value = "";
      $field_names[$raw_column_data[$i]["Field"]] = $field_value;
    }

    return $field_names;

  }

  private function _get_raw_column_data()
  {

    $query = 'SHOW COLUMNS FROM ' . $this->table_name;

    try {
      $stmt = $this->pdo->prepare($query);
      $stmt->execute();
    } catch (Exception $e) {
      echo 'Message: ' . $e->getMessage();
    }

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;

  }

}
?>