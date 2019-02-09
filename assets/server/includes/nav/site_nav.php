<?php
$current_page = basename($_SERVER["REQUEST_URI"]);
?>
<nav class="navbar navbar-expand-md navbar-dark main-bg mb-4">
  <a class="navbar-brand" href="<?php echo ROOT_URL ?>/site">Tech Trans</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <?php 
      $json_file_string = file_get_contents(NAV_JSON);
      $json_array = json_decode($json_file_string, true);

      foreach ($json_array as $nav_item) {
        ?>
        <li class="nav-item" <?php $nav_item[0]["page_title"] == $current_page ? print "active" : print "" ?>>
          <a class="nav-link" href="<?php echo SITE_URL ?>/<?php echo $nav_item[0]["dir"] ?>" ><?php echo $nav_item[0]["page_title"] ?> <span class="sr-only"></span></a>
        </li>      
      <?php 
    }
    ?>
    </ul>    
  </div>
</nav> 