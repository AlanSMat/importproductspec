<?php 
session_start();

include("../../globals.php");

include(SITE_HEADER);

$dbs = new DB_SELECT("select * from com_company");

?>
<style>
.tableLink {  
  width: "150px";  
  float: right;
  padding-right: 10px;
}
</style>
   <div class="container">
    <h4 class="form-header">Companies</h4>      
    <div class="table-responsive">
      <table class="table table-striped table-sm">        
        <tbody>
        <?php
        for ($i = 0; $i < count($dbs->result()); $i++) {
          $field_value = $dbs->result()[$i];
          ?>
          <tr>
            <td><?php echo $field_value["com_companyname"] ?></td>
            <td>              
              <div class="table-link"><a href="process.php?del=<?php echo $field_value["com_id"] ?>">Delete</div>              
              <div class="table-link"><a href="edit.php?id=<?php echo $field_value["com_id"] ?>">Edit</div>              
            </td>
          </tr>
        <?php

      }
      ?>
        </tbody>
      </table>
    </div>
    <button type="button" class="btn btn btn-primary" name="add_new" onclick="window.location.href='edit.php'" class="btn btn-primary">Add Companies</button>    
  </div> <!-- /container -->
<?php 
include(SITE_FOOTER);
?>