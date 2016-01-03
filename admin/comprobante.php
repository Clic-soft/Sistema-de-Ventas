<?php
session_start();
if (isset($_SESSION["Usuario"])):
	include_once('print/fpdf.php');
	require_once 'clases/clsReportes.php';
	require_once 'clases/clsNumeroLetras.php';

	$url=$_SERVER['REQUEST_URI'];
	$url=explode('/',$url);

	$Reporte=new Reporte();

	if(!is_numeric($url[5]) || (strlen($url[5])<7) || (strlen($url[5])>7)):
		header("Location: ../ventas");
	else:
		$fila=$Reporte->PrintComprobante($url[5],$url[4]);
		$dc=$Reporte->getdatosCliente($url[5],$url[4]);
	endif;

	if(empty($fila) && empty($dc))
		header("Location: ../ventas");

	$moneda=new EnLetras(); 

	$meses=$Reporte->meses();
	for($mes=1; $mes<=12; $mes++):
		if(date('m')==$mes)
			$month=$meses[$mes];
	endfor;


date_default_timezone_set("America/Lima");
class PDF extends FPDF 
{ 
	function __construct() 
	{        
		//Llama al constructor de su clase Padre. 
		//Modificar aka segun la forma del papel del reporte (P= VERTICAL, L=HORIZONTAL)
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

$inicio=16;
$datos=44;
$pdf->AddPage(); 
$pdf->SetY(20); 
$pdf->SetFont('Arial','',15); 
$pdf->Text($inicio,$pdf->GetY(),iconv('utf-8', 'cp1252','START TEC - PERÚ'));
$pdf->Image('images/www.png' , $inicio ,21, 35 , 20,'png');

//Cuadro de serie y numero correlativo
$pdf->SetXY(135,17);
$pdf->Line(135,17,196,17); 
$pdf->Cell(61, 25, '',"LR",0,"R");
$pdf->Line(135,42,196,42); 

$pdf->SetY(23); 
$pdf->SetFont('Arial','b',14);
$pdf->Text(139,$pdf->GetY(),iconv('utf-8', 'cp1252','R.U.C. N° 20395834584'));
$pdf->SetY(30); 
$pdf->SetTextColor(255,0,0);
if($url[4]=="boleta")
	$pdf->Text(142,$pdf->GetY(),iconv('utf-8', 'cp1252','BOLETA DE VENTA'));
else
	$pdf->Text(153,$pdf->GetY(),iconv('utf-8', 'cp1252','FACTURA'));

$pdf->SetY(38); 
$pdf->SetTextColor(8,3,3);
$pdf->Text(143,$pdf->GetY(),iconv('utf-8', 'cp1252','N° 001'));
$pdf->Text(163,$pdf->GetY(),iconv('utf-8', 'cp1252','-'));
$pdf->Text(169,$pdf->GetY(),iconv('utf-8', 'cp1252',$url[5]));

//Personalizamos los datos de la empresa, asi como también los servicios que ofrece
$pdf->SetY(27); 
$pdf->SetFont('Arial','',10); 
$pdf->Text(60,$pdf->GetY(),iconv('utf-8', 'cp1252','De: Juan Vásquez Ventura'));

$pdf->SetY(33); 
$pdf->Text(68,$pdf->GetY(),iconv('utf-8', 'cp1252','Av: Mariscal Castilla N° 2345'));

$pdf->SetY(37); 
$pdf->Text(60,$pdf->GetY(),iconv('utf-8', 'cp1252','Chiclayo - Lambayeque. Telf: (074) - 654312'));

$pdf->SetY(44); 
$pdf->Text(29,$pdf->GetY(),iconv('utf-8', 'cp1252','Desarrollo de Software, Soporte Técnico de PCs y Laptops,'));
$pdf->SetY(48); 
$pdf->Text(29,$pdf->GetY(),iconv('utf-8', 'cp1252','instalación de sistemas operativos y programas.'));


//Personalizamos los datos para el cliente
$pdf->SetXY(14,52);
$pdf->Cell(182, 19, '',"LR",0,"R");
$pdf->Line(14,52,196,52); 
$pdf->Line(14,71,196,71); 

$pdf->SetY(57); 
$pdf->SetFont('Arial','b',9);

$pdf->Text($inicio,$pdf->GetY(),iconv('utf-8', 'cp1252','CLIENTE'));
$pdf->SetFont('Arial','',9);
$pdf->Text($datos,$pdf->GetY(),iconv('utf-8', 'cp1252',': '.strtoupper($dc[1])));
$pdf->SetFont('Arial','b',9);
if($url[4]=="boleta"):
	$pdf->Text(135,$pdf->GetY(),iconv('utf-8', 'cp1252','D.N.I.'));
	$pdf->SetFont('Arial','',9);
	$pdf->Text(147,$pdf->GetY(),iconv('utf-8', 'cp1252',': '.strtoupper($dc[0])));
else:
	$pdf->Text(135,$pdf->GetY(),iconv('utf-8', 'cp1252','R.U.C.'));
	$pdf->SetFont('Arial','',9);
	$pdf->Text(147,$pdf->GetY(),iconv('utf-8', 'cp1252',': '.strtoupper($dc[0])));
endif;

$pdf->SetFont('Arial','b',9);
$pdf->Text(170,$pdf->GetY(),iconv('utf-8', 'cp1252','Guía'));
$pdf->SetFont('Arial','',9);
$pdf->Text(179,$pdf->GetY(),iconv('utf-8', 'cp1252',': 2321'));
$pdf->Ln(4);

$pdf->SetFont('Arial','b',9);
$pdf->Text($inicio,$pdf->GetY(),iconv('utf-8', 'cp1252','DIRECCIÓN'));
$pdf->SetFont('Arial','',9);
$pdf->Text($datos,$pdf->GetY(),iconv('utf-8', 'cp1252',': '.strtoupper($dc[2])));
$pdf->Text(135,$pdf->GetY(),iconv('utf-8', 'cp1252','Chiclayo, '.date('m').' de '.$month.' del '.date('Y')));
$pdf->Ln(4);

$pdf->SetFont('Arial','b',9);
$pdf->Text($inicio,$pdf->GetY(),iconv('utf-8', 'cp1252','FECHA EMISIÓN'));
$pdf->SetFont('Arial','',9);
$pdf->Text($datos,$pdf->GetY(),': '.date('m/d/Y'));
$pdf->Ln(4);

$pdf->SetFont('Arial','b',9);
$pdf->Text($inicio,$pdf->GetY(),iconv('utf-8', 'cp1252','CONDIC. PAGO'));
$pdf->SetFont('Arial','',9);
$pdf->Text($datos,$pdf->GetY(),': CONTADO');

//Personalizamos 

$pdf->Ln();


//Construcción de la tabla a mostrar
$pdf->SetXY(14,75);
$ancho=12;
$alto=8;
$pdf->Line(14,75,196,75); 
$pdf->SetFont('Arial','b',10);
$pdf->Cell($ancho, $alto, 'ITEM',"LR",0,"C");
$pdf->Cell($ancho, $alto, 'CANT.',"LR",0,"C");
$pdf->Cell(96, $alto, iconv('utf-8', 'cp1252','DESCRIPCIÓN'),"",0,"C");
$pdf->Cell(20, $alto, 'P. UNIT.',"LR",0,"C");
$pdf->Cell(20, $alto, 'I.G.V.',"",0,"C");
$pdf->Cell(22, $alto, 'IMPORTE',"LR",0,"C");
$pdf->Line(14,83,196,83);
$pdf->SetXY(14,83);

$pdf->SetFont('Arial','',9);
$j=0;/*
$arrayName[] = array('cant' => 3, 
	'prod'=> 'Leche Gloria tarro grande Six Pack 40 ml',
	'precio'=>14.80);
$arrayName[] = array('cant' => 5, 
	'prod'=> 'Aceite Capri Botella 1 Lt',
	'precio'=>8.50);
$arrayName[] = array('cant' => 7, 
	'prod'=> 'Aceite Cocinero Galon 5 Lt',
	'precio'=>48.90);
$arrayName[] = array('cant' => 4, 
	'prod'=> 'Aceite Primor Botella 1 Lt',
	'precio'=>6.30);
	*/
$alto=83;
$suma=0;

foreach ($fila as $key) {
	$j=$j+1;
	$pdf->Cell(12, 8, $j,1,0,"C");
	$pdf->Cell(12, 8, $key[2],1,0,"C");
	$pdf->Cell(96, 8, $key[3],1,0,"L");
	$pdf->Cell(20, 8, number_format($key[4],2),1,0,"C");
	$igv=(($key[2])*($key[4])/1.18)*0.18;
	$pdf->Cell(20, 8, number_format($igv,2),1,0,"C");
	$Total=$key[2]*$key[4];
	$pdf->Cell(22, 8, number_format($Total,2),1,0,"C");
	$pdf->Ln();
	$alto=$alto+8;
	$pdf->SetXY(14,$alto);
	$suma=$suma+$Total;
}

//Calculando el SubTotal, Igv y Total a pagar
$SubTotal=($suma/1.18);
$Igv=($SubTotal*0.18);
$arrayTotal[]=array('SUBTOTAL'=>number_format($SubTotal,2),
					'I.G.V.'=>number_format($Igv,2),
					'TOTAL'=>$suma);

// Damos formato al texto en negrita
$pdf->SetFont('Arial','b',9);
$pdf->Cell(120, 5, 'SON:',1,0,"L");
$pdf->Cell(20, 5, 'SUBTOTAL',1,0,"C");
$pdf->Cell(20, 5, 'I.G.V.',1,0,"C");
$pdf->Cell(22, 5, 'TOTAL',1,0,"C");

$pdf->Ln();
$pdf->SetXY(14,$alto+5);
//Recorremos nuestros datos a mostrar
foreach ($arrayTotal as $key) {
	$con_letra=strtoupper($moneda->ValorEnLetras($key['TOTAL'],"con"));
	$pdf->Cell(120, 5, $con_letra,1,0,"L");
	$pdf->Cell(20, 5, $key['SUBTOTAL'],1,0,"C");
	$pdf->Cell(20, 5, $key['I.G.V.'],1,0,"C");
	$pdf->Cell(22, 5, $key['TOTAL'],1,0,"C");
}

$pdf->cell(0,8,'',0,1);
$pdf->Output();
else:
	header( 'Location: ../../index.php' );
endif;
?>