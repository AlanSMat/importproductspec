<?php 
session_start();
include("../../globals.php");

include(SITE_HEADER);

isset($_REQUEST["id"]) ? $id = $_REQUEST["id"] : $id = 0 ;

$products = new DB_SELECT("select * from pro_product where pro_id = " . $id . "");
$form_data = $products->get_form_data("pro_product");

isset($_REQUEST["companyid"]) ? $form_data["pro_companyid"] = $_REQUEST["companyid"] : $companyidid = 0 ;
?>
<div class="container">
  <form id="product" name="productform" action="process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <div class="form-group">
      <label for="productname">Product Type</label>
      <input type="text" class="form-control" required name="producttype" id="producttype" placeholder="Product Type" value="<?php echo $form_data["pro_producttype"] ?>">    
    </div>
    <div class="form-group">
      <label for="productname">Product Name</label>
      <input type="text" class="form-control" required name="productname" id="productname" placeholder="Product Name" value="<?php echo $form_data["pro_productname"] ?>">    
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
      <select class="form-control" name="companyid" required>
        <option> -- select company -- </option>
        <?php
        for($i = 0; $i < count($company->result()); $i++) {     
          $field_value = $company->result()[$i];         
          ?>
          <option value="<?php echo $field_value["com_id"] ?>" <?php $form_data["pro_companyid"] == $field_value["com_id"] ? print "selected" : print "" ; ?>><?php echo $field_value["com_companyname"] ?></option>
        <?php 
        }
        ?>
      </select>      
    </div>
    <div class="form-group">
      <label for="shippingterms">Shipping Terms</label>
      <select class="form-control" name="shippingterms" required>
        <option> -- select -- </option>
        <option value="FOB" <?php $form_data["pro_shippingterms"] == "FOB" ? print "selected" : print "" ; ?>>FOB</option>
      </select>      
    </div>
    <div class="form-group">
      <label for=" ">Quoted price</label>
      <input type="text" class="form-control" name="quotedprice" id="quotedprice" placeholder="Quoted Price" value="<?php echo $form_data["pro_quotedprice"] ?>">
    </div>
    <div class="form-group">
      <label for="orderqty">Actual Order Qty</label>
      <input type="text" class="form-control" onblur="calc_total_price()" name="orderqty" id="orderqty" placeholder="Actual Order Qty" value="<?php echo (int)$form_data["pro_orderqty"] ?>">
    </div>
    <div class="form-group">
      <label for="totalprice">Total Price</label>
      <input type="text" class="form-control" name="totalprice" id="totalprice" placeholder="Total Price" value="<?php echo (int)$form_data["pro_totalprice"] ?>">
    </div>    
    <div class="form-group">
      <label for="quantity">Mininum Order Qty</label>
      <input type="text" class="form-control" name="moq" id="moq" placeholder="Quantity" value="<?php echo $form_data["pro_moq"] ?>">
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
      <label for="weightunit">Weight Per Unit</label>
      <input type="text" class="form-control" onblur="calc_weight_total()" name="weightunit" name="weightunit" id="weightunit" placeholder="Weight Per Unit" value="<?php echo $form_data["pro_weightunit"] ?>">
    </div>
    <div class="form-group">
      <label for="weighttotal">Weight Total</label>
      <input type="text" class="form-control" name="weighttotal" name="weighttotal" id="weighttotal" placeholder="Weight Total" value="<?php echo $form_data["pro_weighttotal"] ?>">
    </div>
    <div class="form-group">
      <label for="freighttype">Freight Type</label>
      <select class="form-control" name="freighttype" required>
        <option> -- select -- </option>
        <option value="LCL" <?php $form_data["pro_freighttype"] == "LCL" ? print "selected" : print "" ; ?>>LCL</option>
        <option value="20'GP" <?php $form_data["pro_freighttype"] == "20'GP" ? print "selected" : print "" ; ?>>20'GP</option>
        <option value="40'GP" <?php $form_data["pro_freighttype"] == "40'GP" ? print "selected" : print "" ; ?>>40'GP</option>
        <option value="airfreight" <?php $form_data["pro_freighttype"] == "airfreight" ? print "selected" : print "" ; ?>>Airfreight</option>
      </select> 
    </div>
    <div class="form-group">
      <label for="alibabaurl">Alibaba URL</label>
      <input type="text" class="form-control" name="alibabaurl" name="alibabaurl" id="alibabaurl" placeholder="Alibaba URL" value="<?php echo $form_data["pro_alibabaurl"] ?>">
    </div>
    <div class="form-group">
      <label for="companyurl">Company URL</label>
      <input type="text" class="form-control" name="companyurl" name="companyurl" id="companyurl" placeholder="Company URL" value="<?php echo $form_data["pro_companyurl"] ?>">    
    </div>
    <button type="submit" name="generate_shipping_quote" class="btn btn-primary">Generate Shipping Quote</button>
    <button type="submit" name="submit" class="btn btn-primary">Save Product</button>
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

  function calc_total_price() {    
    var form = document.getElementById("product");
    var total_price = form.orderqty.value * form.quotedprice.value;    
    form.totalprice.value = total_price;
  }

  function calc_weight_total() {    
    var form = document.getElementById("product");
    var total_weight = form.orderqty.value * form.weightunit.value;    
    
    form.weighttotal.value = total_weight;
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

