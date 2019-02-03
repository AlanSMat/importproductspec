<?php 
session_start();

include("../../globals.php");

include(SITE_HEADER);

$dbs = new DB_SELECT("select * from com_company");

?>
   <div class="container">
    <h4>Companies</h4>      
    <div class="table-responsive">
      <table class="table table-striped table-sm">        
        <tbody>
        <?php
        for($i = 0; $i < count($dbs->result()); $i++) {     
          $field_value = $dbs->result()[$i];         
        ?>
          <tr>
            <td><a href="edit.php?id=<?php echo $field_value["com_id"] ?>"><?php echo $field_value["com_companyname"] ?></a></td>
            <td>
              <span><a href="edit.php?id=<?php echo $field_value["com_id"] ?>">Edit</button></span>
              <span><a href="process.php?del=<?php echo $field_value["com_id"] ?>">Delete</button></span>
            </td>
          </tr>
        <?php
        }
        ?>
        </tbody>
      </table>
    <a href="edit.php">Add New</a>
  </div> <!-- /container -->
<?php 
include(SITE_FOOTER);
?>