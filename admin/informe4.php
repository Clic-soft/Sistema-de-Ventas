<?php
session_start();
if (isset($_SESSION["Usuario"])):
	include_once('print/fpdf.php');
	require_once 'clases/clsProveedor.php'; 

	$objProv=new Proveedores();
	$fila=$objProv->get_Proveedores();
	if(empty($fila)):
		header('Location: ../proveedores');
	endif;

date_default_timezone_set("America/Lima");
class PDF extends FPDF 
{ 
	//Cabecera de página 
	function Header() 
	{ 
		$this->Image('images/www.png' , 22 ,8, 65 , 38,'png');
		$this->SetFont('Arial','B',12); 
		//Movernos a la derecha 
		$this->Cell(30); 
		//Título 
		$this->Cell(280,40,iconv('utf-8', 'cp1252','SISTEMA DE COMPRA Y VENTA (JCL SOFT SOLUTION)'),0,1,'C'); 
		$this->SetFont('Arial','B',9); 
		$this->Cell(520,-10,"Fecha: ".date("d/m/Y"),0,1,'C');
		$this->Cell(520,0,"Hora: ".date("h:i:s A"),0,1,'C');
		$this->SetFont('Arial','',9); 
		$this->Cell(100,15,iconv('utf-8', 'cp1252','Dirección: Av. Bolognesi #1527 - Chiclayo'),0,1,'C');
		$this->Cell(73,-5,iconv('utf-8', 'cp1252','Teléfono: (074) 234567'),0,0,'C');
		$this->SetFont('Arial','',9);
		$this->Cell(200,-5,iconv('utf-8', 'cp1252','Visítanos en: '),0,0,'C');
		$this->SetFont('Arial','u',9);
		$this->Cell(-140,-5,iconv('utf-8', 'cp1252','www.softsolution.com.pe'),0,1,'C');
		$this->Line(20,55,275,55); 
		$this->Ln(10); 
		$this->SetFont('Arial','u',15);
		$this->Text(115,67,iconv('utf-8', 'cp1252','Listado de Proveedores')); 
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
		//Modificar aka segun la forma del papel del reporte (P= VERTICAL, L=HORIZONTAL)
		parent::__construct('L','mm','A4'); 
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
$pdf->SetFont('Arial','b',10);		         
$pdf->Text(20,80,iconv('utf-8', 'cp1252','N°')); 
$pdf->Text(28,80,iconv('utf-8', 'cp1252','R.U.C'));
$pdf->Text(50,80,iconv('utf-8', 'cp1252','Razón Social')); 
$pdf->Text(110,80,iconv('utf-8', 'cp1252','Dirección')); 
$pdf->Text(175,80,iconv('utf-8', 'cp1252','Teléfono'));
$pdf->Text(200,80,iconv('utf-8', 'cp1252','E-mail'));
$pdf->Text(263,80,iconv('utf-8', 'cp1252','Estado')); 
$pdf->SetFont('Arial','',8);		         
$pdf->Line(20,82,275,82); 
$pdf->Line(20,83,275,83);


$j=0; $Total=0;
foreach ($fila as $key) {
	$j=$j+1;
	$pdf->Text(20,$pdf->GetY(),($j)); 
	$pdf->Text(28,$pdf->GetY(),iconv('utf-8', 'cp1252',$key[0]));
	$pdf->Text(50,$pdf->GetY(),iconv('utf-8', 'cp1252',$key[1])); 
	$pdf->Text(110,$pdf->GetY(),iconv('utf-8', 'cp1252',$key[2]));
	$pdf->Text(175,$pdf->GetY(),iconv('utf-8', 'cp1252',empty($key[3]) ? '-':$key[3])); 
	$pdf->Text(200,$pdf->GetY(),iconv('utf-8', 'cp1252',empty($key[4]) ? '-':$key[4]));
	$pdf->Text(264,$pdf->GetY(),iconv('utf-8', 'cp1252',$key[5]));
	$pdf->cell(0,6.5,'',0,1); 
}

$pdf->cell(0,8,'',0,1);
$pdf->Output();
else:
	header( 'Location: ../../index.php' );
endif;
?>