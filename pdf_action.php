<?php

include "connect.php";
require_once "FPDF-master/FPDF-master/fpdf.php";
$pdf = new FPDF();

$search = $_REQUEST['search'];

if($search != ''){
	$sql = "SELECT * FROM `student` WHERE `name` LIKE '%$search%'";
}else{
	$sql = "SELECT * FROM `student`";
}

$result = mysqli_query($conn, $sql);

$pdf->AddPage();		

$pdf->SetFont('Arial','',12);
$pdf->Cell(30,12,'ID',1);
$pdf->Cell(30,12,'Name',1);
$pdf->Cell(30,12,'Gender',1);
$pdf->Cell(30,12,'Country',1);
$pdf->Cell(30,12,'State',1);
$pdf->Cell(30,12,'Image',1);

foreach($result as $row){
	/*$pdf->SetFont('Arial','',12);
	$pdf->Ln();
	foreach($row as $column)
	{		
		$pdf->Cell(30,12,$column,1);
	}*/
	$pdf->SetFont('Arial','',12);
	$pdf->Ln();
	$pdf->Cell(30,12,$row['id'],1);
	$pdf->Cell(30,12,$row['name'],1);
	$pdf->Cell(30,12,$row['gender'],1);
	$pdf->Cell(30,12,$row['country_id'],1);
	$pdf->Cell(30,12,$row['state_id'],1);
	$pdf->Cell(30,12,$row['stud_image'],1);
}

$pdf->Output('D','StudentDetail.pdf');

?>