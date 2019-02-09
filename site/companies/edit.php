<?php 
session_start();
include("../../globals.php");

include(SITE_HEADER);

isset($_REQUEST["id"]) ? $id = $_REQUEST["id"] : $id = 0;

$dbs = new DB_SELECT("select * from com_company where com_id = " . $id . "");
$form_data = $dbs->get_form_data("com_company");

?>
<div class="container">
  <form id="company" name="companyform" action="process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <div class="form-row">
        <h4 class="form-header">Company Details</h4>        
    </div>    
    <div class="form-row">
      <div class="col">
        <label for="company_name">Company Name</label>
        <input type="text" class="form-control" name="companyname" id="companyname" placeholder="Enter Company Name" required value="<?php echo $form_data["com_companyname"] ?>">    
      </div>
    </div>
    <div class="form-row">
      <div class="col">
        <label for="companyurl">Company URL</label>
        <input type="text" class="form-control" name="companyurl" id="companyurl" placeholder="Company URL" required value="<?php echo $form_data["com_companyurl"] ?>">
      </div>
    </div>
    <div class="form-row">
      <div class="col">    
        <div class="form-group">
          <label for="contact">Company Contact</label>
          <input type="text" class="form-control" name="contact" id="contact" placeholder="Company Contact" value="<?php echo $form_data["com_contact"] ?>">
        </div>
      </div>
      <div class="col">    
        <label for="address">Company Address</label>
        <input type="text" class="form-control" name="address" id="address" placeholder="Company Address" value="<?php echo $form_data["com_address"] ?>">
      </div>
    </div>    
    <div class="form-row">
      <div class="col">  
        <label for="province">Province</label>
        <input type="text" class="form-control" name="province" id="province" placeholder="Province" value="<?php echo $form_data["com_province"] ?>">
      </div>
      <div class="col">
        <label for="zip">Zip Code</label>
        <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip Code" value="<?php echo $form_data["com_zip"] ?>">
      </div>
    </div>    
    <div class="form-row">
      <div class="col">  
        <label for="city">City</label>
        <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?php echo $form_data["com_city"] ?>">
      </div>
      <div class="col">  
        <label for="country">Country</label>
        <input type="text" class="form-control" name="country" name="country" id="country" placeholder="Country" value="China">
      </div>
      <div class="col">  
        <label for="port">Port</label>
        <input type="text" class="form-control" name="port" name="port" id="port" placeholder="Port" value="<?php echo $form_data["com_port"] ?>">
      </div>
    </div>    
    <button type="submit" name="submit" class="btn btn-primary">Save Company</button>    
  </form>
</div>
<?php
include(SITE_FOOTER);
?>

