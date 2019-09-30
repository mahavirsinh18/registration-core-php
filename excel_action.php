<?php

	include('connect.php');
	require_once("PHPExcel-1.8\PHPExcel-1.8\Classes\PHPExcel.php");
		
	$objPHPExcel = new PHPExcel();

	$search = $_REQUEST['search'];


	if($search != ''){
		$sql = "SELECT * FROM `student` WHERE `name` LIKE '%$search%'";
	}else{
		$sql = "SELECT * FROM `student`";
	}

	$result = mysqli_query($conn, $sql);
	
	$rowCount = 2;

	while($row = mysqli_fetch_assoc($result)){
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['name']);
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['gender']);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['country_id']);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['state_id']);

		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'Name')
		            ->setCellValue('B1', 'Gender')
		            ->setCellValue('C1', 'Country')
		            ->setCellValue('D1', 'State');

		$rowCount++;
	}

	header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
	header('Content-Disposition: attachment;filename="userList.xls"');
	header('Cache-Control: max-age=0');
	header ('Pragma: public');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');

?>