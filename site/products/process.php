<?php 
session_start();
include("../../globals.php");

//remove this from the post array as this column is not in the products table
if (isset($_POST["companyname"])) {
  unset($_POST["companyname"]);
}

//remove this from the post array as this column is not in the products table
if (isset($_POST["shcompanyname"])) {
  unset($_POST["shcompanyname"]);
}

// delete record
if (isset($_REQUEST["del"])) {
  $query_string = "DELETE FROM pro_product WHERE pro_id=" . $_REQUEST["del"] . "";
  $del = new DB_DELETE($query_string);

  header("LOCATION: index.php");
  exit;
}

// update record
if (isset($_POST["id"]) && $_POST["id"] != 0) {

  $id = $_POST["id"];
  $where_clause = "WHERE pro_id = " . $_POST["id"] . "";

  try {
    $upd = new DB_UPDATE("pro_product", $_POST, $where_clause);

  } catch (Exception $e) {
    echo $e->message;
    exit;
  }

  $product_id = $_POST["id"];

  // if the form was submitted via the generate shipping quote button
  if (isset($_POST["generate_shipping_quote"])) {

    $shipping_quote["productid"] = $_POST["id"];
    $shipping_quote["productcompanyid"] = $_POST["companyid"];
    $shipping_quote["shippingcompanyid"] = $_POST["shcompanyid"];

    // insert a record into the shipping quotes table
    $insert = new DB_INSERT("shq_shippingquote", $shipping_quote);
    $quote_id = $insert->insert_id();

    // call the create pdf file and create a shipping quote pdf
    include("createpdf.php");

  }

} else if (isset($_POST) && $_POST["id"] < 1) {

  // insert a new product record
  $insert = new DB_INSERT("pro_product", $_POST);

  $product_id = $insert->insert_id();

  $lan_landingcost = array(
    "lan_productid" => $product_id
  );

  $insert = new DB_INSERT("lan_landedcost", $lan_landingcost);

  if (!$id = $insert->insert_id()) {
    exit;
  };

}

header("LOCATION: view.php?id=" . $id . "");
?>