<?php 
session_start();
include("../../globals.php");

if (isset($_REQUEST["del"])) {
  $query_string = "delete from shq_shippingquote where shq_id=" . $_REQUEST["del"] . "";
  $del = new DB_DELETE($query_string);

  header("LOCATION: index.php");
  exit;
}
/*
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

} else if (isset($_POST) && $_POST["id"] < 1) {   

  $insert = new DB_INSERT("pro_product",$_POST);
  $id = $insert->insert_id();
  
}
 */
header("LOCATION: edit.php?id=" . $id . "");
?>