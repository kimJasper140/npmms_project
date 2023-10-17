
<?php
require('fpdf/fpdf.php');
include("config/config.php");

$pdf = new FPDF();
///var_dump(get_class_methods($pdf));

$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->Cell(50,10,'Date:'.date('d-m-Y').'',0,"R");
$pdf->Ln(15);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Accounts',1,1,"C");
$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,8,'No.',1);
$pdf->Cell(45,8,'Id',1);
$pdf->Cell(45,8,' Name',1);
$pdf->Cell(45,8,'Account type',1);
$pdf->Cell(45,8,'Status',1);


$query="SELECT * FROM user";
$result = mysqli_query($mysqli, $query);
$no=0;
while($row = mysqli_fetch_array($result)){
	$no=$no+1;
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(10,8,$no,1);
	$pdf->Cell(45,8,$row['user_id'],1);
	$pdf->Cell(45,8,$row['name'],1);
	$pdf->Cell(45,8,$row['roles'],1);
	$pdf->Cell(45,8,$row['status'],1);
	
	
}
$pdf->Output();
?>