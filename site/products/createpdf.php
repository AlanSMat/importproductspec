<?php
require DOC_ROOT . '/vendor/autoload.php';

/*$dbs = new DB_SELECT("SELECT
                        shq_shippingquote.shq_id AS quoteid,
                        shq_shippingquote.shq_contact AS shipping_contact,
                        pro_product.pro_productname AS product_name,
                        shc_shippingcompany.shc_shcompanyname AS shipping_company
                        FROM pro_product
                        INNER JOIN shq_shippingquote
                        ON pro_product.pro_id = shq_shippingquote.shq_productid    
                        INNER JOIN shc_shippingcompany 
                        ON shc_shippingcompany.shc_id = shq_shippingquote.shq_shippingcompanyid                  
                      ");*/

$dbs = new DB_SELECT("SELECT * 
                      FROM shc_shippingcompany 
                      WHERE shc_id=" . $_POST["shcompanyid"] . "");
$shc_data = $dbs->get_form_data("shc_shippingcompany");

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf();

//used in the quote id
$company_substr = substr(strtoupper($shc_data["shc_shcompanyname"]), 0, 3);

$html = "<link rel=\"stylesheet\" type=\"text/css\" href=\"pdf.css\"/>";
$html .= "<div class=\"companyHeader\">";
$html .= "Steven Mather<br>";
$html .= "Tel: 0467 972 595<br>";
$html .= "Email: steve@asmather.com<br>";
$html .= "ABN: 57 061 998 393<br>";
$html .= "Quote ID: " . substr(strtoupper($shc_data["shc_shcompanyname"]), 0, 3) . $quote_id;
$html .= "</div >";

$html .= "<div class=\"shippingCompanyHeader\">";
$html .= $shc_data["shc_shcompanyname"] . "<br>";
$html .= $shc_data["shc_shphone"] . "<br>";
$html .= $shc_data["shc_shemail"] . "<br>";
//$html .= "Tel: 0467 972 595<br>";
$html .= "</div >";

$html .= "<p class=\"header\">Shipping Quote Request</p>";
$html .= "<table>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">From Country:</td>";
$html .= "<td>China</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">Port of Origin:</td>";
$html .= "<td>China</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">Goods:</td>";
$html .= "<td>" . $_POST["producttype"] . "</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">To Country:</td>";
$html .= "<td>Australia</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">Destination Port:</td>";
$html .= "<td>Port Botany</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">Value of Goods (total):</td>";
$html .= "<td>$" . $_POST["totalprice"] . " USD</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">Type of freight:</td>";
$html .= "<td>" . $_POST["freighttype"] . "</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">Shipping Terms:</td>";
$html .= "<td>" . $_POST["shippingterms"] . "</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">Dimensions:</td>";
$html .= "<td>W" . $_POST["width"] . " * D" . $_POST["depth"] . " * H" . $_POST["height"] . "</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">Total Weight:</td>";
$html .= "<td>" . $_POST["weighttotal"] . "KG</td>";
$html .= "</tr>";
$html .= "</table> ";

$html2pdf->writeHTML($html);
$html2pdf->output();
//$html2pdf->output("shipquote_" . $company_substr . $_POST["shcompanyid"] . ".pdf", 'D');

exit;
?>