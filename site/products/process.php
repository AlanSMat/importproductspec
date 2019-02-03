<?php 
session_start();
include("../../globals.php");

if (isset($_REQUEST["del"])) {
  $query_string = "delete from pro_product where pro_id=" . $_REQUEST["del"] . "";  
  $del = new DB_DELETE($query_string);  
 
  header("LOCATION: index.php");
  exit;
}

if(isset($_POST["id"]) && $_POST["id"] != 0) {  
  
  $id = $_POST["id"];
  $where_clause = "WHERE pro_id = " . $_POST["id"]  . "";     

  try {
    $upd = new DB_UPDATE("pro_product", $_POST, $where_clause);           
  }
   
  catch(Exception $e) {
    echo $e->message;
    exit;
  }    

  if(isset($_POST["generate_shipping_quote"])) {
    include("createpdf.php");
  }

} else if (isset($_POST) && $_POST["id"] < 1) {   

  //$_POST["test"] = 0;

  //var_dump($_POST);  
  $insert = new DB_INSERT("pro_product",$_POST);
  $id = $insert->insert_id();
  
}

header("LOCATION: edit.php?id=" . $id . "");
?>