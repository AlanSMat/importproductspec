<?php 
session_start();
include("../../globals.php");

if (isset($_REQUEST["del"])) {
  // delete company
  $query_string = "DELETE from lan_landedcost where lan_did=" . $_REQUEST["del"] . "";
  $del = new DB_DELETE($query_string);
}

if (isset($_POST["id"]) && $_POST["id"] != 0) {

  $id = $_POST["id"];
  $where_clause = "WHERE lan_id = " . $_POST["id"] . "";

  $upd = new DB_UPDATE("lan_landedcost", $_POST, $where_clause);

} else if (!isset($_REQUEST["del"]) && isset($_POST) && $_POST["id"] < 1) {

  $insert = new DB_INSERT("lan_landedcost", $_POST);
  $id = $insert->insert_id();

  if (isset($_POST["add_product"])) {
    header("LOCATION: ../landed_cost/edit.php?landedcostid=" . $id . "");
    exit;
  }
}

header("LOCATION: index.php");
?>