<?php
require DOC_ROOT . '/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf();

$html = "<link rel=\"stylesheet\" type=\"text/css\" href=\"pdf.css\"/>";
$html .= "<div class=\"companyHeader\">";
$html .= "Steven Mather<br>";
$html .= "Tel: 0467 972 595<br>";
$html .= "Email: steve@asmather.com<br>";
$html .= "ABN: 57 061 998 393<br>";

$dbs = new DB_SELECT("SELECT shc_shcompanyname,
                             shc_shphone,
                             shc_shemail          
                      FROM shc_shippingcompany 
                      WHERE shc_id=" . $_POST["shcompanyid"] . "");
$shc_data = $dbs->get_form_data("shc_shippingcompany");

$html .= "Quote ID: " . substr(strtoupper($shc_data["shc_shcompanyname"]), 0, 3) . $quote_id;
$html .= "</div >";

$html .= "<div class=\"shippingCompanyHeader\">";
$html .= $shc_data["shc_shcompanyname"] . "<br>";
$html .= $shc_data["shc_shphone"] . "<br>";
$html .= $shc_data["shc_shemail"] . "<br>";
$html .= "</div >";

//$html .= "<p class=\"header\">Shipping Quote Request</p>";
$html .= "<table>";
$html .= "<tr>";
$html .= "<td colspan=\"2\">Please provide a shipping quote based on the following information.</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">From Country:</td>";
$html .= "<td>China</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">From Port:</td>";

$dbs = new DB_SELECT("SELECT * 
                      FROM com_company 
                      WHERE com_id=" . $_POST["companyid"] . "");
$shc_data = $dbs->get_form_data("com_company");

$html .= "<td>" . $shc_data["com_port"] . "</td>";
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
$html .= "<td>Port Botany, Sydney</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td class=\"leftCell\">Total Packages:</td>";
$html .= "<td>" . $_POST["orderqty"] . "</td>";
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
$html .= "<td class=\"leftCell\">Dimensions (per package):</td>";
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