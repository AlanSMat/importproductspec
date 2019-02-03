<?php
//include("../../globals.php");
require(CLASSES_PATH . '/fpdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    //$this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Shipping Quote Request Form',0,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',14);

$json_file_string = file_get_contents("quote_fields.json");      
$json_array = json_decode($json_file_string, true);

foreach($json_array as $nav_item) {       
    $nav_item[0]["page_title"];
    $nav_item[0]["dir"];
} 

$quote_array = //array(
    array(
        "Name" => "Steven Mather",
        "Contact Number" => "0467 972 595",
        "Email Address" => "steve@asmather.com",
        "From Country" => "China",
        "Port of Origin" => "China",
        "Goods" => $_POST["producttype"],
        "To Country" => "Australia",
        "Destination Port" => "Port Botany",
        "Value of Goods (total)" => "",
        "Type of freight" => $_POST["freighttype"],
        "Shipping Terms" => $_POST["shippingterms"],
        "Dimensions" => "W" . $_POST["width"] . " * D" . $_POST["depth"] . " * H" . $_POST["height"],
        "Total Weight" => $_POST["weighttotal"] . "KG"
    )
;

//var_dump($quote_array);

foreach($quote_array as $key => $value)
    $pdf->Cell(0,10,$key . ":  " . $value,0,1);
$pdf->Output();

// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',14);
// $pdf->Cell(180,10,'Shipping Quote Request Form',0,1,'C');
// // $pdf->SetFont('Arial','',14);
// // $pdf->Cell(40,40,'Name:');
// // $pdf->Cell(40,40,'Steven Mather',0,1,'C');
// // $pdf->Cell(40,1,'Contact Number:');
// // $pdf->Cell(40,1,'0467972595',0,1,'C');
// // $pdf->Cell(40,20,'Email Address:');
// // $pdf->Cell(40,20,'steve@asmather.com',0,1,'C');
// //$pdf->Cell(60,10,'Powered by FPDF.',0,1,'C');
// //$pdf->Cell(60,10,'Powered by FPDF.',0,1,'C');
// $pdf->SetFont('Arial','',14);
// $pdf->Cell(40,40,'Hello World!');
// $pdf->Cell(60,40,'Powered by FPDF.',0,1,'C');
// $pdf->Cell(40,10,'Hello World!');
// $pdf->Cell(60,10,'Powered by FPDF.',0,1,'C');
// // $pdf->Cell(40,10,'Hello World!');
// // $pdf->Cell(60,10,'Powered by FPDF.',0,1,'C');
// $pdf->Output();
exit;
?>