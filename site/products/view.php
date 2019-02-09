<?php 
session_start();
include("../../globals.php");

// require DOC_ROOT . '/vendor/autoload.php';

// use Spipu\Html2Pdf\Html2Pdf;

// $html2pdf = new Html2Pdf();

// $dom = new DomDocument();
// $dom->loadHTMLFile("./test.html") or die("error");

// $html = $dom->saveHTML();

// $html2pdf->writeHTML($html);
// $html2pdf->output();

// $str = "A 'quote' is <b>bold</b>";
// $html = htmlentities($str, ENT_QUOTES);

if (!$_REQUEST["id"]) {
  trigger_error("id not supplied");
  exit;
}

$dbs = new DB_SELECT("select
                            com_company.com_companyname,
                            pro_product.*
                      from pro_product
                      inner join com_company
                      on pro_product.pro_companyid = com_company.com_id
                      where pro_id=" . $_REQUEST["id"] . "
                      ");
$field_value = $dbs->result()[0];

//include(SITE_HEADER);

$html = "<div class=\"container\">";
//$html .= "<form id=\"product\" name=\"productform\" action=\"process.php\" method=\"post\" enctype=\"multipart/form-data\">";
//$html .= "<input type=\"hidden\" name=\"id\" value=\"" . $_REQUEST["id"] . "\">";
$html .= "<div class=\"form-row\" id=\"first-form-header\">";
$html .= "<h4 class =\"form-header\"> Product Details </h4>";
$html .= "</div>";
$html .= "</div>";
//$html .= "</form>";

$html2pdf->writeHTML($html);
$html2pdf->output();

//echo $html;


?>
  </form>
</div>
<!-- <div class="container">
<h2>Product Details</h2>
  <div class="table-responsive">
    <table class="table table-striped table-sm">    
      <tbody>
        <tr>
          <td>Company Name</td>
          <td><?php echo $field_value["com_companyname"] ?></td>
        </tr>
        <tr>
          <td>Product Type</td>
          <td><?php echo $field_value["pro_producttype"] ?></td>
        </tr>
        <tr>
          <td>Product</td>
          <td><?php echo $field_value["pro_productname"] ?></td>
        </tr>
        <tr>
          <td>Model No</td>
          <td><?php echo $field_value["pro_modelno"] ?></td>
        </tr>
        <tr>
          <td>Quoted Price</td>
          <td>$<?php echo $field_value["pro_quotedprice"] ?> USD</td>
        </tr>        
        <tr>
          <td>MOQ</td>
          <td><?php echo $field_value["pro_moq"] ?></td>
        </tr>
        <tr>
          <td>Actual Order Qty</td>
          <td><?php echo $field_value["pro_orderqty"] ?></td>
        </tr>
        <tr>
          <td>Packing Dimensions</td>
          <td>W<?php echo $field_value["pro_width"] ?> * D<?php echo $field_value["pro_depth"] ?> * H<?php echo $field_value["pro_height"] ?></td>
        </tr>
        <tr>
          <td>CMB</td>
          <td><?php echo $field_value["pro_cmunit"] ?></td>
        </tr>
        <tr>
          <td>Weight per unit</td>
          <td><?php echo $field_value["pro_weightunit"] ?></td>
        </tr>
        <tr>
          <td>Weight Total</td>
          <td><?php echo $field_value["pro_weighttotal"] ?></td>
        </tr>
        <tr>
          <td>Shipping Terms</td>
          <td><?php echo $field_value["pro_shippingterms"] ?></td>
        </tr>
        <tr>
          <td>Freight Type</td>
          <td><?php echo $field_value["pro_freighttype"] ?></td>
        </tr>        
        <tr>        
          <td>Alibaba URL</td>
          <td><a href="<?php echo $field_value["pro_alibabaurl"] ?>">Alibaba URL</a></td>        
        </tr>
        <tr>        
          <td>Retail URL</td>
          <td><a href="<?php echo $field_value["pro_retailurl"] ?>">Retail URL</a></td>        
        </tr>
        <tr>        
          <td>Company URL</td>
          <td><a href="<?php echo $field_value["pro_companyurl"] ?>">Company URL</a></td>        
        </tr>
      </tbody>
    </table>
      
  </div>
</div>
--->
<?php
include(SITE_FOOTER);
?>