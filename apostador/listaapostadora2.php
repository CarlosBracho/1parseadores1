<?php
 require_once('../Connections/conexionbanca.php');
    //$codigoAgente=$_SESSION['MM_cod_agente'];
$codigoAgente=37;
            $where = "WHERE 
			taquilla.tipotaquilla = 3 AND
			taquilla.cod_agencia  = agencia.cod_agencia AND
            agencia.cod_agencia = '$codigoAgente'";
    
    if (!empty($_POST)) {
        $valor = $_POST['campo'];
        if (!empty($valor)) {
            $where = "WHERE 
			taquilla.tipotaquilla = 3 AND
			agencia.cod_agencia = taquilla.cod_agencia AND
            agencia.cod_agencia = '$codigoAgente' AND
			taquilla.nom_taquilla LIKE '%$valor%' ";
        }
    }
    $query_Recordset1 = "/* PARSEADORES1 apostador\listaapostadora2.php - QUERY 1 */ SELECT * FROM taquilla, agencia $where";
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    echo $totalRows_Recordset1;
    
    
?>
<html lang="es">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<script src="../js/jquery-3.3.1.slim.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>	
	</head>
	
	<body>
		
		<div class="container">
			<div class="row">
				<h2 style="text-align:center">Curso de PHP y MySQL</h2>
			</div>
			
			<div class="row">
				<a href="nuevo.php" class="btn btn-primary">Nuevo Registro</a>
				
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
					<b>Nombre: </b><input type="text" id="campo" name="campo" />
					<input type="submit" id="enviar" name="enviar" value="Buscar" class="btn btn-info" />
				</form>
			</div>
			
			<br>
			
			<div class="row table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombre</th>
							<th>Email</th>
							<th>Telefono</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					
					<tbody>
						<?php do { ?>
							<tr>
								<td><?php echo $row_Recordset1['nom_taquilla']; ?></td>
								<td><?php echo $row_Recordset1['nom_taquilla']; ?></td>
								<td><?php echo $row_Recordset1['nom_taquilla']; ?></td>
								<td><?php echo $row_Recordset1['nom_taquilla']; ?></td>
								<td><a href="modificar.php?id=<?php echo $row['nom_taquilla']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
								<td><a href="#" data-href="eliminar.php?id=<?php echo $row['nom_taquilla']; ?>" data-toggle="modal" data-target="#confirm-delete"><span class="glyphicon glyphicon-trash"></span></a></td>
							</tr>
						<?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
					</tbody>
				</table>
			</div>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="confirm-/* PARSEADORES1 apostador\listaapostadora2.php - QUERY 2 */ delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
					</div>
					
					<div class="modal-body">
						¿Desea eliminar este registro?
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<a class="btn btn-danger btn-ok">/* PARSEADORES1 apostador\listaapostadora2.php - QUERY 3 */ Delete</a>
					</div>
				</div>
			</div>
		</div>
		
		<script>
			$('#confirm-delete').on('show.bs.modal', function(e) {
				$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
				
				$('.debug-url').html('/* PARSEADORES1 apostador\listaapostadora2.php - QUERY 4 */ Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
			});
		</script>	
		
	</body>
</html>