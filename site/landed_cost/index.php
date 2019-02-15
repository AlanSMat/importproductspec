<?php 
session_start();

include("../../globals.php");

include(SITE_HEADER);

/*$dbs = new DB_SELECT("SELECT
                            shc_shippingcompany.shc_shcompanyname,
                            shq_shippingquote.shq_id,                            
                            pro_product.pro_id,
                            pro_product.pro_productname,
                            pro_product.pro_modelno,
                            pro_product.pro_moq, 
                            pro_product.pro_orderqty, 
                            pro_product.pro_quotedprice,
                            pro_product.pro_alibabaurl
                      FROM pro_product
                      INNER JOIN shc_shippingcompany
                      ON pro_product.pro_shcompanyid = shc_shippingcompany.shc_id 
                      INNER JOIN shq_shippingquote
                      ON pro_product.pro_shcompanyid = shq_shippingquote.shq_shippingcompanyid
                      ");*/

$dbs = new DB_SELECT("SELECT
                      shc_shippingcompany.shc_shcompanyname,                      
                      pro_product.pro_id,
                      pro_product.pro_productname,
                      pro_product.pro_modelno,
                      pro_product.pro_moq, 
                      pro_product.pro_orderqty, 
                      pro_product.pro_quotedprice,
                      pro_product.pro_alibabaurl
                FROM pro_product
                INNER JOIN shc_shippingcompany
                ON pro_product.pro_shcompanyid = shc_shippingcompany.shc_id                 
                ");

?>
  <div class="container">        
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr class="form-header">
            <th colspan="4">Product List</th>
          </tr>
          <tr class="table-sub-header">
            <th>Model No</th>
            <th>Product Name</th>
            <th colspan="2">Company</th>                        
          </tr>
        </thead>
        <tbody>
          <?php 
          for ($i = 0; $i < count($dbs->result()); $i++) {
            $field_value = $dbs->result()[$i];
            ?>
            <tr>
              <td><?php echo $field_value["pro_modelno"] ?></td>
              <td><?php echo $field_value["pro_productname"] ?></td>
              <td><?php echo $field_value["shc_shcompanyname"] ?></td>              
              <td width="150">
                <span><a href="view.php?id=<?php echo $field_value["pro_id"] ?>">View</button></span>
                <span><a href="edit.php?id=<?php echo $field_value["pro_id"] ?>">Edit</button></span>
                <span><a href="process.php?del=<?php echo $field_value["pro_id"] ?>">Delete</button></span>
              </td>
            </tr>
          <?php 
        }
        ?>
        </tbody>
      </table>   
    </div>    
    <button type="button" class="btn btn btn-primary" name="add_new" onclick="window.location.href='edit.php'" class="btn btn-primary">Add Product</button>    
  </div> <!-- /container -->
<?php 
include(SITE_FOOTER);
?>
