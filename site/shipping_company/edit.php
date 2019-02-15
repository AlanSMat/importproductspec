<?php 
session_start();
include("../../globals.php");

include(SITE_HEADER);

isset($_REQUEST["id"]) ? $id = $_REQUEST["id"] : $id = 0;

$dbs = new DB_SELECT("select * from shc_shippingcompany where shc_id = " . $id . "");
$form_data = $dbs->get_form_data("shc_shippingcompany");

?>
<div class="container">
  <form id="company" name="companyform" action="process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <div class="section-panel">
      <div class="form-row">
          <h4 class="form-header">Shipping Company</h4>        
      </div>    
      <div class="form-row">
        <div class="col">
          <label for="shcompanyname">Shipping Company</label>
          <input type="text" class="form-control" name="shcompanyname" id="shcompanyname" placeholder="Shipping Company Name" required value="<?php echo $form_data["shc_shcompanyname"] ?>">    
        </div>
        <div class="col">
          <label for="shphone">Phone</label>
          <input type="text" class="form-control" name="shphone" id="shphone" placeholder="Shipping" value="<?php echo $form_data["shc_shphone"] ?>">
        </div>
      </div>        
      <div class="form-row">
        <div class="col">
          <label for="shaddress">Address</label>
          <input type="text" class="form-control" name="shaddress" id="shaddress" placeholder="Shipping Company Address" value="<?php echo $form_data["shc_shaddress"] ?>">
        </div>  
        <div class="col">
          <label for="shemail">Email</label>
          <input type="text" class="form-control" name="shemail" id="shemail" placeholder="Shipping Email Address" value="<?php echo $form_data["shc_shemail"] ?>">
        </div>
      </div>
      <div class="form-row">
        <div class="col">
          <label for="shcompanyurl">Shipping Company URL</label>
          <input type="text" class="form-control" name="shcompanyurl" id="shcompanyurl" placeholder="Shipping Company URL" required value="<?php echo $form_data["shc_shcompanyurl"] ?>">
        </div>
      </div>   
    </div>         
    <button type="submit" name="submit" class="btn btn-primary"><?php isset($_REQUEST["id"]) ? print "Save" : print "Add"; ?> Shipping Company</button>
  </form>
</div>
<?php
include(SITE_FOOTER);
?>

