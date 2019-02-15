<?php 
session_start();
include("../../globals.php");

if (!$_REQUEST["id"]) {
  trigger_error("id not supplied");
  exit;
}

$dbs = new DB_SELECT("select * from shc_shippingcompany 
                      where shc_id=" . $_REQUEST["id"] . "
                      ");
$field_value = $dbs->result()[0];

include(SITE_HEADER);
?>
<div class="container">
<h2>Product Details</h2>
  <div class="table-responsive">
    <table class="table table-striped table-sm">    
      <tbody>
        <tr>
          <td>Shipping Company Name</td>
          <td><?php echo $field_value["shc_shippingcompanyname"] ?></td>
        </tr>        
        <tr>        
          <td>Shipping Company URL</td>
          <td><a href="<?php echo $field_value["shc_shippingcompanyurl"] ?>">Shipping Company URL</a></td>        
        </tr>
      </tbody>
    </table>
      
  </div>
</div> <!-- /container -->
<?php
include(SITE_FOOTER);
?>