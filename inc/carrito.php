<?php
session_start();
$_SESSION['carrito'];
if(isset($_SESSION['carrito'])):
	if(isset($_POST['IdProd']) && $_POST['action']=="Eliminar"):
		$arreglo=$_SESSION['carrito'];
		$enc=false;
		$num=0;
			
		for($i=0;$i<count($arreglo);$i++):
			if($arreglo[$i]['Id']==$_POST['IdProd']):
				$enc=true;
				$num=$i;
			endif;
		endfor;

		if($enc==true):
			unset($arreglo[$num]);
				//Ordenamos nuestro indice de nuestro array despues de eliminar un item
			$arreglo=array_values($arreglo);
				//Actualizamos nuestro carrito de compras despues de haber eliminado un item
			$_SESSION['carrito']=$arreglo;
		endif;
	endif;

	//Verificar, si no funciona cambiar variable ok
	if(isset($_POST['IdP'])):
		$arreglo=$_SESSION['carrito'];
		$encontro=false;
		$numero=0;
		for($i=0;$i<count($arreglo);$i++):
			if($arreglo[$i]['Id']==$_POST['IdP']):
				$encontro=true;
				$numero=$i;
			endif;
		endfor;

		if($encontro==true):
			$arreglo[$numero]['Cantidad']=$arreglo[$numero]['Cantidad']+$_POST['cant'];
			$SubTotal = $arreglo[$numero]['Cantidad'] * $arreglo[$numero]['Precio'];
			$Igv=(($SubTotal / 1.18) * 0.18);
			$arreglo[$numero]['SubTotal']=$SubTotal;
			$arreglo[$numero]['Igv']=$Igv;
			$_SESSION['carrito']=$arreglo;
		else:
			$SubTotal = $_POST['precio'] * $_POST['cant'];
			$Igv=(($SubTotal / 1.18) * 0.18);
			$datosNuevos=array('Id'=>$_POST['IdP'],
							'Producto'=>$_POST['prodTexto'],
							'Precio'=>$_POST['precio'],
							'Cantidad'=>$_POST['cant'],
							'SubTotal'=>$SubTotal,
							'Igv'=>$Igv);

			array_push($arreglo, $datosNuevos);
			$_SESSION['carrito']=$arreglo;
		endif;

	else:
		if(isset($_POST['IdProd']) && $_POST['action']=='Quitar'):
			$arreglo=$_SESSION['carrito'];
			$encontro=false;
			$numero=0;
			for($i=0;$i<count($arreglo);$i++):
				if($arreglo[$i]['Id']==$_POST['IdProd']):
					$encontro=true;
					$numero=$i;
				endif;
			endfor;

			if($encontro==true):
				if($arreglo[$numero]['Cantidad']>=2):
					$arreglo[$numero]['Cantidad']=$arreglo[$numero]['Cantidad']-1;
					$SubTotal = $arreglo[$numero]['Cantidad'] * $arreglo[$numero]['Precio'];
					$Igv=(($SubTotal / 1.18) * 0.18);
					$arreglo[$numero]['SubTotal']=$SubTotal;
					$arreglo[$numero]['Igv']=$Igv;
					$_SESSION['carrito']=$arreglo;
				endif;
			endif;
		else:
			if(isset($_POST['IdProd']) && $_POST['action']=='Agregar'):
				$arreglo=$_SESSION['carrito'];
				$encontro=false;
				$numero=0;
				for($i=0;$i<count($arreglo);$i++):
					if($arreglo[$i]['Id']==$_POST['IdProd']):
						$encontro=true;
						$numero=$i;
					endif;
				endfor;

				if($encontro==true):
					$arreglo[$numero]['Cantidad']=$arreglo[$numero]['Cantidad']+1;
					$SubTotal = $arreglo[$numero]['Cantidad'] * $arreglo[$numero]['Precio'];
					$Igv=(($SubTotal / 1.18) * 0.18);
					$arreglo[$numero]['SubTotal']=$SubTotal;
					$arreglo[$numero]['Igv']=$Igv;
					$_SESSION['carrito']=$arreglo;
				endif;
			endif;
		endif;
	endif;
else:
	if(isset($_POST['IdP']) && empty($_SESSION['carrito'])):
		$SubTotal = $_POST['precio'] * $_POST['cant'];
		$Igv=(($SubTotal / 1.18) * 0.18);
		$arreglo[]=array('Id'=>$_POST['IdP'],
						'Producto'=>$_POST['prodTexto'],
						'Precio'=>$_POST['precio'],
						'Cantidad'=>$_POST['cant'],
						'SubTotal'=>$SubTotal,
						'Igv'=>$Igv);
		$_SESSION['carrito']=$arreglo;
	endif;
endif;
?>
<table class='table table-striped table-bordered table-condensed table-hover'>
	<thead class="alert alert-info thead">
		<tr>
			<th class="text-center">Item</th>
			<th>Producto</th>
			<th class="text-center">P. Compra</th>
			<th class="text-center">Cantidad</th>
			<th class="text-center">I.G.V</th>
			<th class="text-center">Importe</th>
			<th class="text-center">Opciones</th>
		</tr>
	</thead>
	<tbody>
	<?php if(!empty($_SESSION['carrito'])): ?>
		<?php $sum=0; $cant=0; ?>
		<?php foreach ($_SESSION['carrito'] as $key):?>
		<?php $sum= ($sum+ $key['SubTotal']); 
			$cant=$cant+1;?>
		<tr>
			<td class="text-center"><?=$cant?></td>
			<td><?=$key['Producto']?></td>
			<td class="text-center">S/. <?=number_format($key['Precio'],2)?></td>
			<td class="text-center"><?=$key['Cantidad']?></td>
			<td class="text-center">S/. <?=number_format($key['Igv'],2)?></td>
			<td class="text-center">S/. <?=number_format($key['SubTotal'],2)?></td>
			<td class="text-center">
				<span title="Incrementar Item" class="btn btn-xs btn-success" onclick="Agregarmas('<?=$key['Id']?>','Agregar')">
					<i class="glyphicon glyphicon-plus"></i>
				</span>
				<span title="Disminuir Item" class="btn btn-xs btn-warning" onclick="Quitarmenos('<?=$key['Id']?>','Quitar')">
					<i class="glyphicon glyphicon-minus"></i>
				</span>
				<span title="Borrar Item" class="btn btn-xs btn-danger" onclick="Eliminar('<?=$key['Id']?>','Eliminar')">
					<i class="glyphicon glyphicon-trash"></i>
				</span>
			</td>
		</tr>
		<?php endforeach; 
		else:?>
		<tr>
			<td colspan="7" class="text-center"><span class="text-danger">Carrito Vacío</span></td>
		</tr>
	<?php endif; ?>
	<?php 
		$SubTotal=($sum / 1.18); 
		$Igv=($SubTotal*0.18)
	?>	
	</tbody>
</table>
<table class='table table-striped table-bordered table-condensed table-hover'>
	<!--<caption class="text-center calculo">Datos Generales</caption>-->
	<thead>
		<tr>
			<th class="text-center">SUBTOTAL</th>
			<th class="text-center">I.G.V</th>
			<th class="text-center">TOTAL</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="text-center">S/. <?=number_format($SubTotal,2)?></td>
			<td class="text-center">S/. <?=number_format($Igv,2)?></td>
			<td class="text-center">S/. <?=number_format($sum,2)?></td>
		</tr>
	</tbody>
</table>