<?php 
session_start();
include("../../globals.php");

include(SITE_HEADER);

isset($_REQUEST["id"]) ? $id = $_REQUEST["id"] : $id = 0;

$products = new DB_SELECT("SELECT * FROM pro_product WHERE pro_id = " . $id . "");

$table_array[0] = "com_company";
$table_array[1] = "pro_product";

$form_data = $products->get_form_data($table_array);

isset($_REQUEST["companyid"]) ? $form_data["pro_companyid"] = $_REQUEST["companyid"] : $companyidid = 0;
?>
<div class="container">
  <form id="productform" name="productform" action="process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id ?>">

    <div class="form-row" id="first-form-header">
        <h4 class="form-header">Product Details</h4>        
    </div>

    <div class="section-panel">
      <div class="form-row">
        <div class="col" >        
          <label for="producttype">Product Type</label>
          <select class="form-control" name="producttype">          
            <option value=""> -- select product type -- </option>
            <?php 

            $product_types = array(
              "Electric Recliner Chair",
              "Leather Sofa",
              "Recliner Sofa"
            );

            foreach ($product_types as $product_type) {
              ?>
              <option value="<?php echo $product_type ?>" <?php if ($form_data["pro_producttype"] == $product_type) print "selected" ?>><?php echo $product_type ?></option>
              <?php 
            }
            ?>
          </select>        
        </div>
        <div class="col">
          <label for="productname">Product Name</label>
          <input type="text" class="form-control" required name="productname" id="productname" placeholder="Product Name" value="<?php echo $form_data["pro_productname"] ?>">    
        </div>
      </div>       

      <div class="form-row">
        <div class="col">
          <label for="alibabaurl">Alibaba URL</label>
          <input type="text" class="form-control" name="alibabaurl" name="alibabaurl" id="alibabaurl" placeholder="Alibaba URL" value="<?php echo $form_data["pro_alibabaurl"] ?>">
        </div>
      </div>
      <div class="form-row">
        <div class="col">
          <label for="retailurl">Retail URL</label>
          <input type="text" class="form-control" name="retailurl" name="retailurl" id="retailurl" placeholder="Retail URL" value="<?php echo $form_data["pro_retailurl"] ?>">    
        </div>
      </div>

      <div class="form-row">      
        <div class="col">
          <label for="address">Model No</label>
          <input type="text" class="form-control" name="modelno" id="address" placeholder="Model No" value="<?php echo $form_data["pro_modelno"] ?>">
        </div>

        <div class="col">
          <label for="company">Company</label>
          <?php 
          $company = new DB_SELECT("select * from com_company");
          ?>      
          <select class="form-control" name="companyid" required>
            <option value=""> -- select company -- </option>
            <?php
            for ($i = 0; $i < count($company->result()); $i++) {
              $field_value = $company->result()[$i];
              ?>
              <option value="<?php echo $field_value["com_id"] ?>" <?php $form_data["pro_companyid"] == $field_value["com_id"] ? print "selected" : print ""; ?>><?php echo $field_value["com_companyname"] ?></option>
            <?php 
          }
          ?>
          </select>            
        </div>
      </div>
    </div>

    <div class="section-panel">
      <div class="form-row">
          <h4 class="form-header">Rough landed cost calculation</h4>        
      </div>
      <div class="form-row">
        <div class="col">
          <label for="quantity">MOQ</label>
          <input type="text" class="form-control" name="moq" id="moq" placeholder="Quantity" value="<?php echo $form_data["pro_moq"] ?>">
        </div>

        <div class="col">
          <label for="orderqty">Order Qty</label>
          <input type="text" class="form-control" name="orderqty" id="orderqty" placeholder="Actual Order Qty" value="<?php echo $form_data["pro_orderqty"] ?>">
        </div>      
          
        <div class="col">
          <label for=" ">Quoted Price Unit</label>
          <input type="text" class="form-control" onblur="calc_total_price()" name="quotedpriceunit" id="quotedpriceunit" placeholder="Quoted Price Unit" value="<?php echo $form_data["pro_quotedpriceunit"] ?>">
        </div>      
        
        <div class="col">
          <label for="quotedpricetotal">Quoted Price Total</label>
          <input type="text" class="form-control" name="quotedpricetotal" id="quotedpricetotal" placeholder="Quoted Price Total" value="<?php echo $form_data["pro_quotedpricetotal"] ?>">
        </div>

        <div class="col">
          <label for="retailpercent">USD Rate</label>
          <input type="text" onblur="calc_rough_landed_cost()" class="form-control" name="usdrate" id="usdrate" placeholder="USD Rate" value="<?php echo $form_data["pro_usdrate"] ?>">
        </div>

        <div class="col">
          <label for="roughlandedcost">Rough Landed Cost</label>
          <input type="text" xonblur="calc_margin()" class="form-control" name="roughlandedcost" id="roughlandedcost" placeholder="Rough Landed Cost" value="<?php echo $form_data["pro_roughlandedcost"] ?>">
        </div>
      </div>
    </div>

    <div class="form-row">
        <h4 class="form-header">Estimated profit calculation</h4>        
    </div>

    <div class="section-panel">
      <div class="form-row">
        <div class="col">
          <label for="retailprice">Retail Price Unit</label>
          <input type="text" class="form-control" name="retailpriceunit" onblur="calc_retail_price_total()" id="retailpriceunit" placeholder="Retail Price Unit" value="<?php echo $form_data["pro_retailpriceunit"] ?>">
        </div>

        <div class="col">
          <label for="retailprice">Retail Price Total</label>
          <input type="text" class="form-control" name="retailpricetotal" id="retailpricetotal" onblur="calc_margin()" placeholder="Retail Price Total" value="<?php echo $form_data["pro_retailpricetotal"] ?>">
        </div>

        <div class="col">
          <label for="margin">Estimated Margin</label>
          <input type="text" class="form-control" name="margin" id="margin" placeholder="Margin" value="<?php echo $form_data["pro_margin"] ?>">
        </div>

        <div class="col">
          <label for="retailpercent">Retail Percent</label>
          <input type="text" onblur="calc_profit()" class="form-control" name="retailpercent" id="retailpercent" placeholder="Retail Percent" value="<?php echo $form_data["pro_retailpercent"] ?>">
        </div>

        <div class="col">
          <label for="approxsellprice">Approx Sell Price</label>
          <input type="text" class="form-control" name="approxsellprice" id="approxsellprice" placeholder="Approx Sell Price" value="<?php echo $form_data["pro_approxsellprice"] ?>">
        </div>

        <div class="col">
          <label for="retailprofit">Retail Profit</label>
          <input type="text" class="form-control" name="retailprofit" id="retailprofit" placeholder="Retail Profit" value="<?php echo $form_data["pro_retailprofit"] ?>">
        </div>

        <div class="col">
          <label for="estprofit">Estimated Profit</label>
          <input type="text" class="form-control" name="estprofit" id="estprofit" placeholder="Est Profit" value="<?php echo $form_data["pro_estprofit"] ?>">
        </div>
      </div>
    </div>

    <div class="section-panel">
      <div class="form-row">
          <h4 class="form-header">Shipping <span class="note-text">Note: Est Units 20ft and Est Units 40ft are a guide ONLY.</span></h4>        
      </div>
      <div class="form-row">
        <div class="col" >
          <label for="width">Width</label>
          <input type="text" class="form-control" name="width" name="width" id="width" placeholder="Width" value="<?php echo $form_data["pro_width"] ?>">
        </div>
        <div class="col">
          <label for="depth">Depth</label>
          <input type="text" class="form-control" name="depth" name="depth" id="depth" placeholder="Depth" value="<?php echo $form_data["pro_depth"] ?>">
        </div>
        <div class="col" >      
          <label for="height">Height</label>
          <input type="text" class="form-control" onblur="calc_cmb_unit()" name="height" name="height" id="height" placeholder="Height" value="<?php echo $form_data["pro_height"] ?>">
        </div>      
        <div class="col">    
          <label for="cmunit">CM (per unit)</label>
          <input type="text" class="form-control" name="cmunit" name="cmunit" id="cmunit" placeholder="CM (Per Unit)" value="<?php echo $form_data["pro_cmunit"] ?>">    
        </div>
        <div class="col">    
          <label for="units20">Est Units 20ft</label>
          <input type="text" class="form-control" name="units20" name="units20" id="units20" placeholder="Est Units 20ft" value="<?php echo $form_data["pro_units20"] ?>">    
        </div>
        <div class="col">    
          <label for="units40">Est Units 40ft</label>
          <input type="text" class="form-control" name="units40" name="units40" id="units40" placeholder="Est Units 40ft" value="<?php echo $form_data["pro_units40"] ?>">    
        </div>
      </div>
      <div class="form-row">
        <div class="col">
          <label for="company">Shipping Company</label>
          <?php 
          $company = new DB_SELECT("select * from shc_shippingcompany");
          ?>      
          <select class="form-control" name="shcompanyid">
            <option value=""> -- select company -- </option>
            <?php
            for ($i = 0; $i < count($company->result()); $i++) {
              $field_value = $company->result()[$i];
              ?>
              <option value="<?php echo $field_value["shc_id"] ?>" <?php $form_data["pro_shcompanyid"] == $field_value["shc_id"] ? print "selected" : print ""; ?>><?php echo $field_value["shc_shcompanyname"] ?></option>
            <?php 
          }
          ?>
          </select> 
        </div>
        <div class="col">
          <label for="shippingterms">Shipping Terms</label>
          <select class="form-control" name="shippingterms" required>
            <option> -- select -- </option>
            <option value="FOB" <?php $form_data["pro_shippingterms"] == "FOB" ? print "selected" : print ""; ?>>FOB</option>
          </select>  
        </div>
        <div class="col">
          <label for="freighttype">Freight Type</label>
          <select class="form-control" name="freighttype" required>
            <option> -- select -- </option>
            <option value="LCL" <?php $form_data["pro_freighttype"] == "LCL" ? print "selected" : print ""; ?>>LCL</option>
            <option value="20'GP" <?php $form_data["pro_freighttype"] == "20'GP" ? print "selected" : print ""; ?>>20'GP</option>
            <option value="40'GP" <?php $form_data["pro_freighttype"] == "40'GP" ? print "selected" : print ""; ?>>40'GP</option>
            <option value="Airfreight" <?php $form_data["pro_freighttype"] == "Airfreight" ? print "selected" : print ""; ?>>Airfreight</option>
          </select> 
        </div>
      </div>
      <div class="form-row">
        <div class="col">
          <label for="weightunit">Weight Per Unit</label>
          <input type="text" class="form-control" onblur="calc_weight_total()" name="weightunit" name="weightunit" id="weightunit" placeholder="Weight Per Unit" value="<?php echo $form_data["pro_weightunit"] ?>">
        </div>      
      
        <div class="col">
          <label for="weighttotal">Weight Total</label>
          <input type="text" class="form-control" name="weighttotal" name="weighttotal" id="weighttotal" placeholder="Weight Total" value="<?php echo $form_data["pro_weighttotal"] ?>">
        </div>
      </div>
    </div>      
    <?php
    if (!isset($_REQUEST["view"])) {
      ?>   
    <button type="submit" name="submit" class="btn btn btn-primary">Save Product</button>
    <button type="submit" name="generate_shipping_quote" class="btn btn btn-primary">Generate Shipping Quote</button>    
    <?php 
  }
  ?>
  </form>

</div>
<p>&nbsp;</p>
<script type="text/javascript">

  let form = document.getElementById("productform");

  function populate_calc_fields() {
    calc_total_price();
    calc_weight_total();
    calc_margin();
  }

  function calc_total_price() {        
    let total_price = parseFloat(form.orderqty.value * form.quotedpriceunit.value).toFixed(2);    
    form.quotedpricetotal.value = total_price;
  }

  function calc_retail_price_total() {   
    let total_retail_price = form.orderqty.value * form.retailpriceunit.value;    
    form.retailpricetotal.value = total_retail_price;
  }

  function calc_rough_landed_cost() {       
    let rough_landed_cost = form.quotedpricetotal.value * form.usdrate.value * 1.3;    
    form.roughlandedcost.value = parseFloat(rough_landed_cost).toFixed(2);
  }

  function calc_margin() {    
    form.margin.value = parseFloat(form.retailpricetotal.value - form.roughlandedcost.value).toFixed(2);
  }

  function calc_profit() {
    form.approxsellprice.value = parseFloat(form.retailpricetotal.value * (form.retailpercent.value / 100)).toFixed(2);
    form.retailprofit.value    = parseFloat(form.retailpricetotal.value - form.approxsellprice.value).toFixed(2);
    form.estprofit.value       = parseFloat(form.approxsellprice.value - form.roughlandedcost.value).toFixed(2);
  }

  function calc_weight_total() {            
    let total_weight = parseFloat(form.orderqty.value * form.weightunit.value);    
    
    form.weighttotal.value = total_weight;
  }

  function calc_cmb_unit() {    
    // convert to mm's for calculation
    var width  = form.width.value * 10;
    var depth  = form.depth.value * 10;
    var height = form.height.value * 10

    var num_total      = width * depth * height / 1000000000;
    var decimal_places = Math.pow(10, 2)
    var unit_calc = Math.ceil(num_total * decimal_places) / decimal_places;

    form.cmunit.value = unit_calc; 

    calc_num_units_per_container(unit_calc);
  }
  
  function calc_num_units_per_container(cm_unit) {
    var container20ft = Math.round(27 / cm_unit);  
    var container40ft = Math.round(55 / cm_unit);
    
    form.units20.value = container20ft;
    form.units40.value = container40ft;
  }

  function set_disabled() {
    
    for(var i = 0; i < form.elements.length; i++) {      
      form.elements[i].disabled = true;
    }

  }
  <?php
  if (isset($_REQUEST["view"])) {
    ?>    
    set_disabled();
  <?php

}
?>

</script>
<?php
include(SITE_FOOTER);
?>

