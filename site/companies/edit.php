<?php 
session_start();
include("../../globals.php");

include(SITE_HEADER);

isset($_REQUEST["id"]) ? $id = $_REQUEST["id"] : $id = 0 ;

$dbs = new DB_SELECT("select * from com_company where com_id = " . $id . "");
$form_data = $dbs->get_form_data("com_company");

?>
<div class="container">
  <form id="company" name="companyform" action="process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <div class="form-group">
      <label for="company_name">Company Name</label>
      <input type="text" class="form-control" name="companyname" id="companyname" placeholder="Enter Company Name" required value="<?php echo $form_data["com_companyname"] ?>">    
    </div>
    <div class="form-group">
      <label for="companyurl">Company URL</label>
      <input type="text" class="form-control" name="companyurl" id="companyurl" placeholder="Company URL" required value="<?php echo $form_data["com_companyurl"] ?>">
    </div>
    <div class="form-group">
      <label for="address">Company Address</label>
      <input type="text" class="form-control" name="address" id="address" placeholder="Company Address" value="<?php echo $form_data["com_address"] ?>">
    </div>
    <div class="form-group">
      <label for="province">Province</label>
      <input type="text" class="form-control" name="province" id="province" placeholder="Province" value="<?php echo $form_data["com_province"] ?>">
    </div>
    <div class="form-group">
      <label for="postcode">Post Code</label>
      <input type="text" class="form-control" name="postcode" id="postcode" placeholder="Post Code" value="<?php echo $form_data["com_postcode"] ?>">
    </div>
    <div class="form-group">
      <label for="country">Country</label>
      <input type="text" class="form-control" name="country" name="country" id="country" placeholder="Country" value="China">
    </div>
    <div class="form-group">
      <label for="port">Port</label>
      <input type="text" class="form-control" name="port" name="port" id="port" placeholder="Port" value="<?php echo $form_data["com_port"] ?>">
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
  </form>
</div>
<?php
include(SITE_FOOTER);
?>

