<?php 
session_start();
include("../../globals.php");

include(SITE_HEADER);

isset($_REQUEST["id"]) ? $id = $_REQUEST["id"] : $id = 0;

$shipping = new DB_SELECT("select shq_shippingquote.* 
                           from 
                           shq_shipping 
                           where shq_id = " . $id . "");
$form_data = $products->get_form_data("shq_shippingquote");

?>
<div class="container">
  <form id="product" name="productform" action="process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <div class="form-group">
      <label for="productname">Product Name</label>
      <input type="text" class="form-control" required name="productname" id="productname" placeholder="Enter Product Name" value="<?php echo $form_data["pro_productname"] ?>">    
    </div>
    <div class="form-group">
      <label for="address">Model No</label>
      <input type="text" class="form-control" name="modelno" id="address" placeholder="Model No" value="<?php echo $form_data["pro_modelno"] ?>">
    </div>
    <div class="form-group">
      <label for="company">Company</label>
      <?php 
      $company = new DB_SELECT("select * from com_company");
      ?>      
    </div>
    <div class="form-group">
      <label for="quotedprice">Quoted price</label>
      <input type="text" class="form-control" name="quotedprice" id="quotedprice" placeholder="Quoted Price" value="<?php echo $form_data["pro_quotedprice"] ?>">
    </div>
    <div class="form-group">
      <label for="width">Width</label>
      <input type="text" class="form-control" name="width" name="width" id="width" placeholder="Width" value="<?php echo $form_data["pro_width"] ?>">
    </div>
    <div class="form-group">
      <label for="depth">Depth</label>
      <input type="text" class="form-control" name="depth" name="depth" id="depth" placeholder="Depth" value="<?php echo $form_data["pro_depth"] ?>">
    </div>
    <div class="form-group">
      <label for="height">Height</label>
      <input type="text" class="form-control" onblur="calc_cmb_unit()" name="height" name="height" id="height" placeholder="Height" value="<?php echo $form_data["pro_height"] ?>">
    </div>
    <div class="form-group">
      <label for="cmunit">CM (per unit)</label>
      <input type="text" class="form-control" name="cmunit" name="cmunit" id="cmunit" placeholder="CM (Per Unit)" value="<?php echo $form_data["pro_cmunit"] ?>">
    </div>
    <div class="form-group">
      <label for="alibabaurl">Alibaba URL</label>
      <input type="text" class="form-control" name="alibabaurl" name="alibabaurl" id="alibabaurl" placeholder="Alibaba URL" value="<?php echo $form_data["pro_alibabaurl"] ?>">
    </div>    
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
<script type="text/javascript">
  /**
  * @param num The number to round
  * @param precision The number of decimal places to preserve
  */
  function roundUp(num, precision) {
    precision = Math.pow(10, precision)
    return Math.ceil(num * precision) / precision
  }

  function calc_cmb_unit() {
    var form = document.getElementById("product");
    // convert to mm's for calculation
    var width  = form.width.value * 10;
    var depth  = form.depth.value * 10;
    var height = form.height.value * 10

    var num_total      = width * depth * height / 1000000000;
    var decimal_places = Math.pow(10, 2)
    var unit_calc = Math.ceil(num_total * decimal_places) / decimal_places;

    form.cmunit.value = unit_calc; 
  }
  
</script>
<?php
include(SITE_FOOTER);
?>

