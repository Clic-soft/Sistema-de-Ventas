<div class="m-left z-1 fixed inline-flex col-md-2">
	<div id="m">
		<?php require_once 'inc/menu.php'; ?>
	</div>
</div>
<div class="menu--top container-fluid col-md-10 col-md-offset-2">
	<div class="row">
		<div class="nav-top-menu">
			<div class="col-xs-6">
				<strong><?=$_SESSION['usuario']?></strong>
			</div>
			<div class="col-xs-6">
            	<a class="float-right" href="inc/CerrarSesion.php">Cerrar Sesión</a>
            </div>
		</div>
		<div id="more-menu" class="more-menu">
           	<span class="glyphicon glyphicon-chevron-down"></span>
        </div>	
        <script type="text/javascript">
       		$("#more-menu").click(function(){
       			$(".m-left").toggle();
       		});
        </script>
	</div>
</div>