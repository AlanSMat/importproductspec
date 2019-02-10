<?php 
session_start();
include("../../globals.php");

include(SITE_HEADER);

isset($_REQUEST["id"]) ? $id = $_REQUEST["id"] : $id = 0;

$products = new DB_SELECT("select
                            com_company.com_companyname,
                            shc_shippingcompany.shc_shcompanyname,
                            pro_product.*
                      from pro_product
                      inner join com_company
                      on pro_product.pro_companyid = com_company.com_id
                      inner join shc_shippingcompany 
                      on pro_product.pro_shcompanyid = shc_shippingcompany.shc_id
                      where pro_id=" . $_REQUEST["id"] . "
                      ");

$form_data = $products->result()[0];

isset($_REQUEST["companyid"]) ? $form_data["pro_companyid"] = $_REQUEST["companyid"] : $companyidid = 0;
?>
<div class="container">
  <form id="product" name="productform" action="process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id ?>">

    <div class="form-row" id="first-form-header">
        <h4 class="form-header">Product Details</h4>        
    </div>

    <div class="section-panel">
      <div class="form-row">
        <div class="col" >        
          <label for="producttype">Product Type</label>          
          <input type="text" disabled class="form-control" name="producttype" id="producttype" value="<?php echo $form_data["pro_producttype"] ?>">              
        </div>
        <div class="col">
          <label for="productname">Product Name</label>
          <input type="text" disabled class="form-control" required name="productname" id="productname" placeholder="Product Name" value="<?php echo $form_data["pro_productname"] ?>">    
        </div>
      </div>       

      <div class="form-row">
        <div class="col">
          <label for="alibabaurl">Alibaba Link</label>
          <a href="<?php echo $form_data["pro_alibabaurl"] ?>"><input type="text" disabled class="form-control" name="alibabaurl" name="alibabaurl" id="alibabaurl" placeholder="Alibaba URL" value="<?php echo $form_data["pro_alibabaurl"] ?>"></a>
        </div>
      </div>
      <div class="form-row">
        <div class="col">
          <label for="retailurl">Retail URL</label>
          <input type="text" class="form-control" disabled name="retailurl" name="retailurl" id="retailurl" placeholder="Retail URL" value="<?php echo $form_data["pro_retailurl"] ?>">    
        </div>
      </div>

      <div class="form-row">      
        <div class="col">
          <label for="address">Model No</label>
          <input type="text" disabled class="form-control" name="modelno" id="address" placeholder="Model No" value="<?php echo $form_data["pro_modelno"] ?>">
        </div>

        <div class="col">
          <label for="company">Company</label>
          <input type="text" disabled class="form-control" name="company" id="company" value="<?php echo $form_data["com_companyname"] ?>">                        
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
          <input type="text" class="form-control" disabled name="moq" id="moq" placeholder="Quantity" value="<?php echo $form_data["pro_moq"] ?>">
        </div>

        <div class="col">
          <label for="orderqty">Order Qty</label>
          <input type="text" class="form-control" disabled name="orderqty" id="orderqty" placeholder="Actual Order Qty" value="<?php echo (int)$form_data["pro_orderqty"] ?>">
        </div>      
          
        <div class="col">
          <label for=" ">Quoted price</label>
          <input type="text" class="form-control" disabled onblur="calc_total_price()" name="quotedprice" id="quotedprice" placeholder="Quoted Price" value="<?php echo $form_data["pro_quotedprice"] ?>">
        </div>      
        
        <div class="col">
          <label for="totalprice">Total Price</label>
          <input type="text" class="form-control" disabled name="totalprice" id="totalprice" placeholder="Total Price" value="<?php echo $form_data["pro_totalprice"] ?>">
        </div>

        <div class="col">
          <label for="retailpercent">USD Rate</label>
          <input type="text" disabled onblur="calc_rough_landed_cost()" class="form-control" name="usdrate" id="usdrate" placeholder="USD Rate" value="<?php echo $form_data["pro_usdrate"] ?>">
        </div>

        <div class="col">
          <label for="roughlandedcost">Rough Landed Cost</label>
          <input type="text" disabled xonblur="calc_margin()" class="form-control" name="roughlandedcost" id="roughlandedcost" placeholder="Rough Landed Cost" value="<?php echo $form_data["pro_roughlandedcost"] ?>">
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
          <input type="text" disabled class="form-control" onblur="calc_retail_price_total()" name="retailpriceunit" id="retailpriceunit" placeholder="Retail Price Unit" value="<?php echo (int)$form_data["pro_retailpriceunit"] ?>">
        </div>

        <div class="col">
          <label for="retailprice">Retail Price Total</label>
          <input type="text" disabled onblur="calc_margin()" class="form-control" name="retailpricetotal" id="retailpricetotal" placeholder="Retail Price Total" value="<?php echo (int)$form_data["pro_retailpricetotal"] ?>">
        </div>

        <div class="col">
          <label for="margin">Estimated Margin</label>
          <input type="text" disabled class="form-control" name="margin" id="margin" placeholder="Margin" value="<?php echo (int)$form_data["pro_margin"] ?>">
        </div>

        <div class="col">
          <label for="retailpercent">Retail Percent</label>
          <input type="text" disabled onblur="calc_profit()" class="form-control" name="retailpercent" id="retailpercent" placeholder="USD Rate" value="<?php echo $form_data["pro_retailpercent"] ?>">
        </div>

        <div class="col">
          <label for="estprofit">Estimated Profit</label>
          <input type="text" disabled class="form-control" name="estprofit" id="estprofit" placeholder="Est Profit" value="<?php echo $form_data["pro_estprofit"] ?>">
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
          <input type="text" disabled class="form-control" name="width" name="width" id="width" placeholder="Width" value="<?php echo $form_data["pro_width"] ?>">
        </div>
        <div class="col">
          <label for="depth">Depth</label>
          <input type="text" disabled class="form-control" name="depth" name="depth" id="depth" placeholder="Depth" value="<?php echo $form_data["pro_depth"] ?>">
        </div>
        <div class="col" >      
          <label for="height">Height</label>
          <input type="text" disabled class="form-control" onblur="calc_cmb_unit()" name="height" name="height" id="height" placeholder="Height" value="<?php echo $form_data["pro_height"] ?>">
        </div>      
        <div class="col">    
          <label for="cmunit">CM (per unit)</label>
          <input type="text" disabled class="form-control" name="cmunit" name="cmunit" id="cmunit" placeholder="CM (Per Unit)" value="<?php echo $form_data["pro_cmunit"] ?>">    
        </div>
        <div class="col">    
          <label for="units20">Est Units 20ft</label>
          <input type="text" disabled class="form-control" name="units20" name="units20" id="units20" placeholder="Est Units 20ft" value="<?php echo $form_data["pro_units20"] ?>">    
        </div>
        <div class="col">    
          <label for="units40">Est Units 40ft</label>
          <input type="text" disabled class="form-control" name="units40" name="units40" id="units40" placeholder="Est Units 40ft" value="<?php echo $form_data["pro_units40"] ?>">    
        </div>
      </div>
      <div class="form-row">
        <div class="col">
          <label for="shcompanyname">Shipping Company</label>
          <input type="text" disabled class="form-control" name="shcompanyname" name="units40" id="shcompanyname" value="<?php echo $form_data["shc_shcompanyname"] ?>">    
        </div>
        <div class="col">
          <label for="shippingterms">Shipping Terms</label>
          <input type="text" disabled class="form-control" name="shippingterms" name="shippingterms" id="shippingterms" value="<?php echo $form_data["pro_shippingterms"] ?>">              
        </div>
        <div class="col">
          <label for="freighttype">Freight Type</label>
          <input type="text" disabled class="form-control" name="freighttype" name="freighttype" id="freighttype" value="<?php echo $form_data["pro_freighttype"] ?>">          
        </div>
      </div>
      <div class="form-row">
        <div class="col">
          <label for="weightunit">Weight Per Unit</label>
          <input type="text" class="form-control" disabled onblur="calc_weight_total()" name="weightunit" name="weightunit" id="weightunit" placeholder="Weight Per Unit" value="<?php echo $form_data["pro_weightunit"] ?>">
        </div>    
        <div class="col">
          <label for="weighttotal">Weight Total</label>
          <input type="text" class="form-control" disabled name="weighttotal" name="weighttotal" id="weighttotal" placeholder="Weight Total" value="<?php echo $form_data["pro_weighttotal"] ?>">
        </div>
      </div>
    </div>          
    <button type="submit" name="generate_shipping_quote" class="btn btn btn-primary">Generate Shipping Quote</button>    
  </form>

</div>
<p>&nbsp;</p>
<script type="text/javascript">
  /**
  * @param num The number to round
  * @param precision The number of decimal places to preserve
  */
  function roundUp(num, precision) {
    precision = Math.pow(10, precision)
    return Math.ceil(num * precision) / precision
  }

  let form = document.getElementById("product");

  function populate_calc_fields() {
    calc_total_price();
    calc_weight_total();
    calc_margin();
  }

  function calc_retail_price_total() {   
    let total_retail_price = form.orderqty.value * form.retailpriceunit.value;    
    form.retailpricetotal.value = total_retail_price;
  }

  function calc_rough_landed_cost() {       
    let rough_landed_cost = form.totalprice.value * form.usdrate.value * 1.3;    
    form.roughlandedcost.value = parseFloat(rough_landed_cost).toFixed(2);
  }

  function calc_margin() {    
    form.margin.value = parseFloat(form.retailpricetotal.value - form.roughlandedcost.value).toFixed(2);
  }

  function calc_profit() {
    form.estprofit.value =  parseFloat(form.retailpricetotal.value * form.retailpercent.value - form.roughlandedcost.value).toFixed(2);
  }

  function calc_total_price() {        
    let total_price = parseFloat(form.orderqty.value * form.quotedprice.value).toFixed(2);    
    form.totalprice.value = total_price;
  }

  function calc_weight_total() {            
    let total_weight = parseFloat(form.orderqty.value * form.weightunit.value).toFixed(2);    
    
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

    calc_num_units_per_container(unit_calc);
  }
  
  function calc_num_units_per_container(cm_unit) {
    var container20ft = Math.round(27 / cm_unit);  
    var container40ft = Math.round(55 / cm_unit);
    var form = document.getElementById("product");

    form.units20.value = container20ft;
    form.units40.value = container40ft;
  }

</script>
<?php
include(SITE_FOOTER);
?>

