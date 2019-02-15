<?php 
session_start();
include("../../globals.php");

include(SITE_HEADER);

isset($_REQUEST["id"]) ? $id = $_REQUEST["id"] : $id = 0;

$dbs = new DB_SELECT("SELECT pro_product.*, 
                             lan_landedcost.* 
                      FROM pro_product
                      INNER JOIN lan_landedcost 
                      ON pro_id = lan_productid                        
                      WHERE pro_id = " . $id . "");

$table_array[0] = "pro_product";
$table_array[1] = "lan_landedcost";


$form_data = $dbs->get_form_data($table_array);

?>
<div class="container">
  <form id="landed_cost" name="landed_cost" action="process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <div class="section-panel">
      <div class="form-row">
          <h4 class="form-header">The Goods</h4>        
      </div>    

      <div class="form-row">

        <div class="col">
          <label for="cbm">CBM</label>
          <input type="text" class="form-control" name="cbm" id="cbunit" placeholder="CBM" disabled required value="<?php echo $form_data["pro_cmunit"] ?>">    
        </div>

        <div class="col">
          <label for="orderqty">Qty</label>
          <input type="text" class="form-control" name="orderqty" id="orderqty" placeholder="Order QTY" disabled required value="<?php echo $form_data["pro_orderqty"] ?>">    
        </div>

        <div class="col">
          <label for="productname">Product Name</label>
          <input type="text" class="form-control" name="cbm" id="productname" disabled placeholder="Product Name" required value="<?php echo $form_data["pro_productname"] ?>">    
        </div>

      </div>

      <div class="form-row">

        <div class="col">
          <label for="quotedprice">Quoted Price (USD)</label>
          <input type="text" class="form-control" name="quotedprice" id="quotedprice" disabled placeholder="Quoted Price" required value="<?php echo $form_data["pro_quotedprice"] ?>">    
        </div>

        <div class="col">
          <label for="quotedprice">Total Price (USD)</label>
          <input type="text" class="form-control" name="totalprice" id="totalprice" disabled placeholder="Total Price" required value="<?php echo $form_data["pro_totalprice"] ?>">    
        </div>

        <div class="col">
          <label for="usdrate">Current USD to AUD rate</label>
          <input type="text" class="form-control" name="usdrate" id="usdrate" disabled placeholder="USD RAte" required value="<?php echo $form_data["pro_usdrate"] ?>">    
        </div>

        <div class="col">
          <label for="agentfee">Agent Fee 5% (USD)</label>
          <input type="text" class="form-control" name="agentfee" id="agentfee" disabled placeholder="Agent Fee 5%" required value="<?php echo $form_data["pro_totalprice"] * 0.05 ?>">    
        </div>
      </div>

    </div>    

    <div class="section-panel">      
      <div class="form-row">
          <h4 class="form-header">Shipping</h4>        
      </div>    
      <div class="form-row">
        <div class="col">
          <label for="freight">Sea Freight / Shipping Cost</label>
          <input type="text" class="form-control" name="freight" id="freight" placeholder="Freight" value="<?php echo $form_data["lan_freight"] ?>">
        </div>
        <div class="col">
          <label for="clearingagentcharges">Clearing Agent Charges</label>
          <input type="text" class="form-control" name="clearingagentcharges" id="clearingagentcharges" placeholder="Clearing Agent Charges" value="<?php echo $form_data["lan_clearingagentcharges"] ?>">
        </div>
        <div class="col">
          <label for="dutiesonshipping">Duties on shipping + clearing @ 5%</label>
          <input type="text" class="form-control" name="dutiesonshipping" id="dutiesonshipping" placeholder="Duties on shipping" value="<?php echo $form_data["lan_dutiesonshipping"] ?>">
        </div>
        <div class="col">
          <label for="roadfreight">Road Freight To Door (AUD)</label>
          <input type="text" class="form-control" name="roadfreight" id="roadfreight" placeholder="Road Freight" value="<?php echo $form_data["lan_roadfreight"] ?>">
        </div>
      </div>    
    </div>

    <div class="section-panel">

      <div class="form-row">
          <h4 class="form-header">Sale Price</h4>        
      </div>              

      <div class="form-row">
        <div class="col">
          <label for="saleprice">Your Sale Price</label>
          <input type="text" class="form-control" onblur="calc_landed_cost_all()" name="saleprice" id="saleprice" placeholder="Sale Price" value="<?php echo $form_data["pro_retailpriceunit"] * ($form_data["pro_retailpercent"] / 100) ?>">
        </div>  

        <div class="col">
          <label for="wholesale">Wholesale / Facilitate</label>                              
          <select class="form-control" name="wholesale" required>
            <option value=""> -- wholesale / facilitate -- </option>            
            <option value="wholesale" <?php $form_data["lan_wholesale"] == "wholesale" ? print "selected" : print ""; ?>>Wholesale</option>            
            <option value="facilitate" <?php $form_data["lan_wholesale"] == "facilitate" ? print "selected" : print ""; ?>>Facilitate</option>            
          </select> 
        </div>
      </div>

    </div>

    <div class="section-panel">

      <div class="form-row">
          <h4 class="form-header">The Results</h4>        
      </div>   

      <div class="form-row">
        <div class="col">
          <label for="landedcostallitems">Landed Cost All Items (AUD)</label>
          <input type="text" class="form-control" name="landedcostallitems" id="landedcostallitems" placeholder="Landed Cost All Items" required value="<?php echo $form_data["lan_landedcostallitems"] ?>">
        </div>
        <div class="col">
          <label for="landedcostperitem">Landed Cost Per Item (AUD)</label>
          <input type="text" class="form-control" name="landedcostperitem" id="landedcostperitem" placeholder="Landed Cost Per Item" required value="<?php echo $form_data["lan_landedcostperitem"] ?>">
        </div>        
        <div class="col">
          <label for="salepriceallitems">Sale Price All Items (AUD)</label>
          <input type="text" class="form-control" name="salepriceallitems" id="salepriceallitems" placeholder="Landed Cost Per Item" required value="<?php echo $form_data["lan_salepriceallitems"] ?>">
        </div>
        <div class="col">
          <label for="cogs">Cogs %</label>
          <input type="text" class="form-control" name="cogs" id="cogs" placeholder="Landed Cost Per Item" required value="<?php echo $form_data["lan_cogs"] ?>">
        </div>
        <div class="col">
          <label for="profitperitem">Profit Per Item</label>
          <input type="text" class="form-control" name="profitperitem" id="profitperitem" placeholder="Profit Per Item" required value="<?php echo $form_data["lan_profitperitem"] ?>">
        </div>
      </div>   

    </div>


    <button type="submit" name="submit" class="btn btn-primary"><?php isset($_REQUEST["id"]) ? print "Save" : print "Add"; ?> Shipping Company</button>
  </form>
</div>

<script type="text/javascript">

var form = document.getElementById("landed_cost");

function landed_cost_unit() {

}

function calc_landed_cost_all() {
  var totallandedcostallitems = 0;
  
  var price_total_plus_usd = (parseFloat(form.totalprice.value) * parseFloat(form.usdrate.value)).toFixed(2);
  var agent_fee_usd = (parseFloat(form.agentfee.value) * parseFloat(form.usdrate.value)).toFixed(2);
  var freight_charge_usd = (parseFloat(form.freight.value) * parseFloat(form.usdrate.value)).toFixed(2);
  var clearing_agent_charges = form.clearingagentcharges.value;
  var duties_on_road_freight = (parseFloat(clearing_agent_charges) + (parseFloat(freight_charge_usd) + parseFloat(price_total_plus_usd)) * (parseFloat(form.usdrate.value) * 0.05)).toFixed(2);
  
  console.log(duties_on_road_freight);

  console.log(parseFloat(price_total_plus_usd) + parseFloat(agent_fee_usd) + parseFloat(freight_charge_usd) + parseFloat(clearing_agent_charges) + parseFloat(duties_on_road_freight));
  
  //console.log(parseFloat(price_total_plus_usd) + parseFloat(agent_fee_usd).toFixed(2));
  
  //landedcostallitems = price_total_plus_usd;//(parseFloat(form.totalprice.value) * parseFloat(form.usdrate.value)).toFixed(2) + 
                       //(parseFloat(form.agentfee.value) * parseFloat(form.usdrate.value)) //+                             
                       /*(form.freight.value * form.usdrate.value) + 
                        form.clearingagentcharges.value + 
                        form.dutiesonshipping.value + 
                        form.freight.value;  */
  form.landedcostallitems.value = landedcostallitems;
  
}

</script>

<?php
include(SITE_FOOTER);
?>

