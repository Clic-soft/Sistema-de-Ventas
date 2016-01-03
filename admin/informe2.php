<?php
session_start();
if (isset($_SESSION["Usuario"])):
	$url=$_SERVER['REQUEST_URI'];
	$url=explode('/',$url);

	include_once('print/fpdf.php');
	require_once 'clases/clsReportes.php'; 

	$objRep=new Reporte();
	if(isset($url[5]) && !empty($url[5])):
		switch ($url[4]) {
			case 'ingresos':
				$fila=$objRep->getVentasMensual($url[5]);
				if(empty($fila)):
					header('Location: ../ingresos-mensuales');
				endif;
				break;

			case 'egresos':
				$fila=$objRep->getEgresosmensual($url[5]);
				if(empty($fila)):
					header('Location: ../egresos-mensuales');
				endif;
				break;
			
			default:
				header('Location: ../egresos-mensuales');
				break;
		}
		
	else:
		header('Location: ../ingresos-mensuales');
	endif;

date_default_timezone_set("America/Lima");
class PDF extends FPDF 
{ 
	//Cabecera de página 

	function Header() 
	{ 
		$this->Image('images/www.png' , 10 ,8, 65 , 38,'png');
		$this->SetFont('Arial','B',12); 
		//Movernos a la derecha 
		$this->Cell(30); 
		//Título 
		$this->Cell(200,40,iconv('utf-8', 'cp1252','SISTEMA DE COMPRA Y VENTA (JCL SOFT SOLUTION)'),0,1,'C'); 
		$this->SetFont('Arial','B',9); 
		$this->Cell(365,-10,"Fecha: ".date("d/m/Y"),0,1,'C');
		$this->Cell(365,0,"Hora: ".date("h:i:s A"),0,1,'C');
		$this->SetFont('Arial','',9); 
		$this->Cell(100,15,iconv('utf-8', 'cp1252','Dirección: Av. Bolognesi #1527 - Chiclayo'),0,1,'C');
		$this->Cell(73,-5,iconv('utf-8', 'cp1252','Teléfono: (074) 234567'),0,0,'C');
		$this->SetFont('Arial','',9);
		$this->Cell(100,-5,iconv('utf-8', 'cp1252','Visítanos en: '),0,0,'C');
		$this->SetFont('Arial','u',9);
		$this->Cell(-45,-5,iconv('utf-8', 'cp1252','www.softsolution.com.pe'),0,1,'C');
		$this->Line(15,55,200,55); 
		$this->SetY(108);
	} 

	//Pie de página 
	function Footer() 
	{ 
		$this->SetY(-37); 
		//Arial italic 8 
		$this->SetFont('Arial','I',8); 
		//Número de página 
		$this->Cell(0,10,iconv('utf-8', 'cp1252','Página ').$this->PageNo().'/{nb}',0,0,'C'); 
		$this->Line(15,260,200,260); 
	} 

	function __construct() 
	{        
		//Llama al constructor de su clase Padre. 
		//Modificar aka segun la forma del papel del reporte 
		parent::__construct('P','mm','A4'); 
		//parent::__construct('P','mm','Letter'); 
	} 
} 
				
//Creación del objeto de la clase heredada 
$pdf=new PDF(); 
$pdf->SetTopMargin(5.4); 
$pdf->SetLeftMargin(1.5);     
$pdf->AliasNbPages(); 
$pdf->SetFont('Arial','',9); 


$pdf->AddPage();     

$pdf->Ln();
$pdf->SetFont('Arial','u',15); 
$pdf->Text(68,70,iconv('utf-8', 'cp1252','Reporte de '.$url[4].' mensuales')); 

//Construcción de la tabla a mostrar
$pdf->SetY(95);
$pdf->SetFont('Arial','b',11);		         
$pdf->Text(43,85,iconv('utf-8', 'cp1252','N°')); 
$pdf->Text(55,85,iconv('utf-8', 'cp1252','Mes'));
$pdf->Text(95,85,iconv('utf-8', 'cp1252','Año')); 
$pdf->Text(137,85,iconv('utf-8', 'cp1252','Monto Total')); 
$pdf->SetFont('Arial','',10);		         
$pdf->Line(40,87,170,87); 
$pdf->Line(40,88,170,88);


$j=0; $Total=0;
foreach ($fila as $key) {
	$j=$j+1;
	$mes = iconv('utf-8', 'cp1252',$key['Mes']);  
	$SubTotal = iconv('utf-8', 'cp1252',$key['Monto']); 
	$year = $url[5];
	$pdf->Text(43,$pdf->GetY(),($j)); 
	$pdf->Text(55,$pdf->GetY(),$mes);
	$pdf->Text(95,$pdf->GetY(),$year); 
	$pdf->Text(140,$pdf->GetY(),'S/. '.$SubTotal); 
	$pdf->cell(0,6.5,'',0,1); 
	$Total = $Total + $SubTotal;
}

$pdf->Line(100,190,170,190);
$pdf->SetY(195);
$pdf->SetFont('Arial','b',11);
$pdf->Text(110,$pdf->GetY(),'TOTAL:');
$pdf->Text(140,$pdf->GetY(),'S/. '.number_format($Total,2)); 

$pdf->cell(0,8,'',0,1);
$pdf->Output();
else:
	header( 'Location: ../../index.php' );
endif;
?>