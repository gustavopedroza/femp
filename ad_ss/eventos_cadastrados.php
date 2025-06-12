<?php
include('conf.php');
protege();
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo $v_url; ?>/favicon.ico">

    <title><?php echo $v_tit; ?></title>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- <script src="../../assets/js/ie-emulation-modes-warning.js"></script>-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


  </head>

  <body>

    <div class="container">

		<?php include("topo.php"); ?>
			  
		<ol class="breadcrumb">
			<li>Eventos</li>
			<li>Pessoas Cadastradas</li>
		</ol>
		
		<p><a class="btn btn-info" href="<?php echo $v_url; ?>/visitantes_imprimir_etiquetas.php" target="_blank">Imprimir Etiquetas</a></p>

		<?php
		
			

		$ide = $_REQUEST['ide'];
		
		
		$sql = "SELECT pdf, campo_identificacao FROM eventos WHERE ide = '".$ide."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			$pdf = $obj['pdf'];
			$campo_identificacao = $obj['campo_identificacao'];
		}
		
		?>


		<table class="table table-hover">
		<thead>
		<tr>
			<th width='16%'>Nome</th>
			<th width='16%'>CPF</th>
			<th width='16%'>E-mail</th>
			<th width='16%'>Celular</th>
			<th width='16%'><?php echo $campo_identificacao; ?></th>
			<th width='20%'>Controle</th>
		</tr>
		</thead>
		<tbody>



		<?php
		
		$sql = "SELECT cadastro.*, cadastro_eventos.ide FROM cadastro INNER JOIN cadastro_eventos ON cadastro_eventos.idc = cadastro.idc WHERE ide = '".$ide."' ORDER BY cadastro.nome ASC";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			while ($obj = mysqli_fetch_array($res)) {

				$exp = false;
				$sqlv = "SELECT senha FROM expositores WHERE idc = '".$obj['idc']."' AND ide = '".$ide."'";
				$resv = mysqli_query($conn, $sqlv);
				$totalv = @mysqli_num_rows($resv);
				if ($totalv) {
					$exp = true;
				}
							

				echo '<tr>';
				
				echo '<td>'.$obj['nome'].'</td>';
				echo '<td>'.$obj['cpf'].'</td>';
				echo '<td>'.$obj['email'].'</td>';
				echo '<td>'.$obj['cel'].'</td>';
				echo '<td>'.$obj['empresa'].'</td>';
				
				echo '<td>';
				
				if ($exp == true) {
					echo ' <a class="btn btn-info" href="'.$v_url.'/eventos_habilitar_expositor.php?ide='.$ide.'&idc='.$obj['idc'].'">Expositor</a> ';
				} else {
					echo ' <a class="btn btn-default" href="'.$v_url.'/eventos_habilitar_expositor.php?ide='.$ide.'&idc='.$obj['idc'].'">Habilitar Expositor</a> ';
				}
				echo '</td>';

				echo '</tr>';

			}
		}


		?>
		</tbody>
		</table>

		<?php include("rodape.php"); ?>

    </div> <!-- /container -->

	<?php include("scripts.php"); ?>

	
  </body>
</html>
