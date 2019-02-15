<?php 
session_start();

include("../../globals.php");

include(SITE_HEADER);

$dbs = new DB_SELECT("select * from shc_shippingcompany");

?>
  <div class="container">
    <!--<h4 class="form-header">Shipping Companies</h4>-->
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>          
            <th colspan="2" class="form-header">Shipping Companies</th>           
          </tr>
        </thead>        
        <tbody>
        <?php
        for ($i = 0; $i < count($dbs->result()); $i++) {
          $field_value = $dbs->result()[$i];
          ?>
          <tr>
            <td><?php echo $field_value["shc_shcompanyname"] ?></td>            
            <td>
              <div class="table-link"><a href="process.php?del=<?php echo $field_value["shc_id"] ?>">Delete</div>
              <div class="table-link"><a href="edit.php?id=<?php echo $field_value["shc_id"] ?>">Edit</div>              
            </td>
          </tr>
        <?php

      }
      ?>
        </tbody>
      </table>    
    </div>
    <button type="button" class="btn btn btn-primary" name="add_new" onclick="window.location.href='edit.php'" class="btn btn-primary">Add Shipping Company</button>    
  </div> <!-- /container -->
<?php 
include(SITE_FOOTER);
?>