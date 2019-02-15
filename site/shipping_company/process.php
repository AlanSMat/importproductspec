<?php 
session_start();
include("../../globals.php");

if (isset($_REQUEST["del"])) {

  $query_string = "delete from shc_shippingcompany where shc_id=" . $_REQUEST["del"] . "";
  $del = new DB_DELETE($query_string);

  header("LOCATION: index.php");
  exit;
}

if (isset($_POST["id"]) && $_POST["id"] != 0) {

  $id = $_POST["id"];
  $where_clause = "WHERE shc_id = " . $_POST["id"] . "";

  try {
    $upd = new DB_UPDATE("shc_shippingcompany", $_POST, $where_clause);
  } catch (Exception $e) {
    echo $e->message;
    exit;
  }

} else if (isset($_POST) && $_POST["id"] < 1) {

  $insert = new DB_INSERT("shc_shippingcompany", $_POST);
  $id = $insert->insert_id();

  if (isset($_POST["add_shippingcompany"])) {
    header("LOCATION: ../shipping_company/edit.php?shippingcompanyid=" . $id . "");
    exit;
  }
}

header("LOCATION: index.php");
?>