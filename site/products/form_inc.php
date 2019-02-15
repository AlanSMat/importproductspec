<?php 
include("../../globals.php");
$id = "1";
ob_start();
?>
<link rel="stylesheet" href="<?php echo BOOTSTRAP_CSS ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL ?>/default.css" />

<div class="container">
  <form id="product" name="productform" action="process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id ?>">

    <div class="form-row" id="first-form-header">
        <h4 class="form-header">Product Details</h4>        
    </div>
    <div>
    <?php 
    echo "test";
    ?>
    </div>
  </form>  
</div>
<?php 
file_put_contents("test.html", ob_get_contents());
?>