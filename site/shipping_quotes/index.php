<?php 
session_start();

include("../../globals.php");

include(SITE_HEADER);

$dbs = new DB_SELECT("SELECT
                        shq_shippingquote.shq_id AS quoteid,
                        shq_shippingquote.shq_contact AS shipping_contact,
                        pro_product.pro_productname AS product_name,
                        shc_shippingcompany.shc_shcompanyname AS shipping_company
                        FROM pro_product
                        INNER JOIN shq_shippingquote
                        ON pro_product.pro_id = shq_shippingquote.shq_productid    
                        INNER JOIN shc_shippingcompany 
                        ON shc_shippingcompany.shc_id = shq_shippingquote.shq_shippingcompanyid                  
                      ");
?>
   <div class="container">    
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr class="form-header">
            <th colspan="4">Shipping Quotes</th>
          </tr>       
          <tr class="table-sub-header">          
            <td>Quote ID</td>
            <td>Product Name</td>
            <td>Shipping Company</td>            
            <td></td>            
          </tr>
        </thead>        
        <tbody>
          <?php 
          for ($i = 0; $i < count($dbs->result()); $i++) {
            $field_value = $dbs->result()[$i];
            ?>
            <tr>
              <td><?php echo $field_value["quoteid"] ?></td>
              <td><?php echo $field_value["product_name"] ?></td>
              <td><?php echo $field_value["shipping_company"] ?></td>                            
              <td>
              <div class="table-link"><a href="process.php?del=<?php echo $field_value["quoteid"] ?>">Delete</button></span></div>
                <div class="table-link"><a href="view.php?id=<?php //echo $field_value["pro_id"] ?>">View</button></div>                                
              </td>
            </tr>
          <?php 
        }
        ?>
        </tbody>
      </table>   
    </div>    
    <!--<button type="button" class="btn btn btn-primary" name="add_new" onclick="window.location.href='edit.php'" class="btn btn-primary">Edit Company</button>-->
  </div> <!-- /container -->
<?php 
include(SITE_FOOTER);
?>
