<?php
session_start();
if (isset($_SESSION["Usuario"])):
	include_once('print/fpdf.php');
	require_once 'clases/clsReportes.php'; 

	$objRep=new Reporte();
	$fila=$objRep->getStockminimo();
	if(empty($fila)):
		header('Location: ../productos-stock-minimo');
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
		$this->Ln(10); 
		$this->SetFont('Arial','u',15);
		$this->Text(60,70,iconv('utf-8', 'cp1252','Reporte de productos con stock mínimo')); 
		$this->Ln(); 
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


//Construcción de la tabla a mostrar
$pdf->SetY(90);
$pdf->SetFont('Arial','b',11);		         
$pdf->Text(20,80,iconv('utf-8', 'cp1252','N°')); 
$pdf->Text(30,80,iconv('utf-8', 'cp1252','Categoría'));
$pdf->Text(60,80,iconv('utf-8', 'cp1252','Descripción')); 
$pdf->Text(145,80,iconv('utf-8', 'cp1252','P. Venta')); 
$pdf->Text(179,80,'Stock'); 
$pdf->SetFont('Arial','',10);		         
$pdf->Line(20,82,190,82); 
$pdf->Line(20,83,190,83);


$j=0; $Total=0;
foreach ($fila as $key) {
	$j=$j+1;
	$categoria = iconv('utf-8', 'cp1252',$key[1]);  
	$producto = iconv('utf-8', 'cp1252',$key[2]); 
	$precio = $key[3];
	$stock=$key[4];
	$pdf->Text(20,$pdf->GetY(),($j)); 
	$pdf->Text(28,$pdf->GetY(),$categoria);
	$pdf->Text(60,$pdf->GetY(),$producto); 
	$pdf->Text(145,$pdf->GetY(),'S/. '.$precio);
	$pdf->Text(184,$pdf->GetY(),$stock); 
	$pdf->cell(0,6.5,'',0,1); 
}

$pdf->cell(0,8,'',0,1);
$pdf->Output();
else:
	header( 'Location: ../../index.php' );
endif;
?>