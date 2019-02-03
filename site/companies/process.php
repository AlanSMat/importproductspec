<?php 
session_start();
include("../../globals.php");

if (isset($_REQUEST["del"])) {
  $query_string = "delete from com_company where com_id=" . $_REQUEST["del"] . "";  
  $del = new DB_DELETE($query_string);  

  $query_string = "delete from pro_product where pro_companyid=" . $_REQUEST["del"] . "";   $del = new DB_DELETE($query_string);  

  header("LOCATION: index.php");
  exit;
}

if(isset($_POST["id"]) && $_POST["id"] != 0) {  
  
  $id = $_POST["id"];
  $where_clause = "WHERE com_id = " . $_POST["id"]  . "";   
  
  try {
    $upd = new DB_UPDATE("com_company", $_POST, $where_clause);           
  }
   
  catch(Exception $e) {
    echo $e->message;
    exit;
  }    

} else if (isset($_POST) && $_POST["id"] < 1) {   

  $insert = new DB_INSERT("com_company",$_POST);
  $id = $insert->insert_id();  

  if(isset($_POST["add_product"])) {
    header("LOCATION: ../products/edit.php?companyid=" . $id . "");
    exit;
  } 
}

header("LOCATION: index.php");
?>