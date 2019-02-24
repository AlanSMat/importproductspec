<?php 
include("globals.php");



include(CLASSES_PATH . "/class.Test.php");
?>
<html>
<head>
  <title>test</title>
</head>
<body>
   <h1>Test</h1>
   <img src="<?php echo IMAGES_URL ?>/arrow.jpg" />
</body> 
</html>
<?php
header("LOCATION: site/index.php");
?>
