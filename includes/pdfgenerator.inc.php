<?php

require_once ("fpdf/fpdf.php");
// require_once("functions.inc.php");

class PDF extends FPDF
{
  
function Header()
{  
    $this->Image('../images/logo.jpeg',10,6,30);   
    $this->SetFont('Arial','B',15);   
    $this->Cell(80);   
    $this->SetDrawColor(80,150,255);
    $this->Cell(30,10,'Factura','B',1,'C');  
    $this->Ln(2);
    
}

// Page footer
function Footer()
{    
    $this->SetY(-15);   
    $this->SetFont('Arial','I',8);   
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
$now = date("Y-m-d");
$nrfact = nrFactura();
$pdf = new PDF();

$pdf->SetLineWidth(0.4);
$pdf->AliasNbPages();
$pdf -> AddPage();

$pdf->SetFont('Arial','',8);
$pdf->Cell(75);
$pdf->Cell(30,4,'Numar factura: '.$nrfact,0,1,'L');
$pdf->Cell(75);
$pdf->Cell(30,4,'Data(an,luna,zi): '.$now,0,1,'L');
$pdf->Cell(75);
$pdf->Cell(30,4,'Cota T.V.A.: 19%',0,1,'L');
$pdf->Ln(20);


$y_rect2=$pdf->GetY();
$lat=190;


$pdf->SetFont('Arial','',10);
$text = '../meniuri/preturi.txt';
$id = $idcda;
createPdf($conn,$id,$pdf,$lat,$text);



$pdf -> output('F','../meniuri/factura.pdf');
