<?php 
session_start();

include("../../globals.php");

include(SITE_HEADER);

$dbs = new DB_SELECT("select
                            com_company.com_companyname,
                            pro_product.pro_id,
                            pro_product.pro_productname,
                            pro_product.pro_modelno,
                            pro_product.pro_moq, 
                            pro_product.pro_orderqty, 
                            pro_product.pro_quotedprice,
                            pro_product.pro_alibabaurl
                      from pro_product
                      inner join com_company
                      on pro_product.pro_companyid = com_company.com_id
                      ");

?>
  <div class="container">    
    <h4 class="form-header">Product List</h4>            
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
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
              <td><?php echo $field_value["com_companyname"] ?></td>              
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
