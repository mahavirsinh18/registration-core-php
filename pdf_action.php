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
///////////////////////////////////////////////////////////////////////////////////////////////////////
?>








<?php  
 function fetch_data()  
 {  
      $output = '';  
      $conn = mysqli_connect("localhost", "root", "", "tut");  
      $sql = "SELECT * FROM pdf_export ORDER BY id ASC";  
      $result = mysqli_query($conn, $sql);  
      while($row = mysqli_fetch_array($result))  
      {       
      $output .= '<tr>  
                          <td>'.$row["id"].'</td>  
                          <td>'.$row["name"].'</td>  
                          <td>'.$row["age"].'</td>  
                          <td>'.$row["email"].'</td>  
                     </tr>  
                          ';  
      }  
      return $output;  
 }  
 if(isset($_POST["generate_pdf"]))  
 {  
      require_once('tcpdf/tcpdf.php');  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Generate HTML Table Data To PDF From MySQL Database Using TCPDF In PHP");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 11);  
      $obj_pdf->AddPage();  
      $content = '';  
      $content .= '  
      <h4 align="center">Generate HTML Table Data To PDF From MySQL Database Using TCPDF In PHP</h4><br /> 
      <table border="1" cellspacing="0" cellpadding="3">  
           <tr>  
                <th width="5%">Id</th>  
                <th width="30%">Name</th>  
                <th width="15%">Age</th>  
                <th width="50%">Email</th>  
           </tr>  
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('file.pdf', 'I');  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>SoftAOX | Generate HTML Table Data To PDF From MySQL Database Using TCPDF In PHP</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />            
      </head>  
      <body>  
           <br />
           <div class="container">  
                <h4 align="center"> Generate HTML Table Data To PDF From MySQL Database Using TCPDF In PHP</h4><br />  
                <div class="table-responsive">  
                	<div class="col-md-12" align="right">
                     <form method="post">  
                          <input type="submit" name="generate_pdf" class="btn btn-success" value="Generate PDF" />  
                     </form>  
                     </div>
                     <br/>
                     <br/>
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="5%">Id</th>  
                               <th width="30%">Name</th>  
                               <th width="15%">Age</th>  
                               <th width="50%">Email</th>  
                          </tr>  
                     <?php  
                     echo fetch_data();  
                     ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
</html>