<?php 
if(!isset($page_title)) {
    $page_title = "";
}
$current_page = basename($_SERVER["REQUEST_URI"]);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $page_title ?></title>
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:009:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />            
    <link rel="stylesheet" href="<?php echo BOOTSTRAP_CSS ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL ?>/default.css" />
    <script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/default.js" />
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL ?>/side-bar.css" /> -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>                
</head>
<body>
<?php 
include(SITE_NAV);
?>





