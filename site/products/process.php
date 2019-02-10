<?php 
session_start();
include("../../globals.php");

var_dump($_POST);
exit;

if (isset($_REQUEST["del"])) {
  $query_string = "delete from pro_product where pro_id=" . $_REQUEST["del"] . "";
  $del = new DB_DELETE($query_string);

  header("LOCATION: index.php");
  exit;
}

if (isset($_POST["id"]) && $_POST["id"] != 0) {

  $id = $_POST["id"];
  $where_clause = "WHERE pro_id = " . $_POST["id"] . "";

  try {
    $upd = new DB_UPDATE("pro_product", $_POST, $where_clause);
  } catch (Exception $e) {
    echo $e->message;
    exit;
  }

  if (isset($_POST["generate_shipping_quote"])) {

    $shipping_details["productid"] = $_POST["id"];
    $shipping_details["productcompanyid"] = $_POST["companyid"];
    $shipping_details["shippingcompanyid"] = $_POST["shcompanyid"];

    $insert = new DB_INSERT("shq_shippingquote", $shipping_details);
    $quote_id = $insert->insert_id();

    include("createpdf.php");

  }

} else if (isset($_POST) && $_POST["id"] < 1) {

  $insert = new DB_INSERT("pro_product", $_POST);
  $id = $insert->insert_id();

}

header("LOCATION: edit.php?id=" . $id . "");
?>