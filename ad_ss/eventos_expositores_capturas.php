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
			<li>Expositores</li>
			<li>Capturas</li>
		</ol>

		<?php

		$ide = $_REQUEST['ide'];
		$idexp = $_REQUEST['idexp'];

		?>

		<p><a href='https://expoaltotiete.com.br/ad_ss/eventos-expositores/<?php echo $ide; ?>/' class='btn btn-info'>Voltar</a> <a href='https://expoaltotiete.com.br/ad_ss/exportar_xls.php?idexp=<?php echo $idexp; ?>' target='_blank' class='btn btn-success'>Exportar Excel</a></p>

		
		<table class="table table-hover">
		<thead>
		<tr>
			<th width='16%'>Data/Hora</th>
			<th width='16%'>Nome</th>
			<th width='16%'>E-mail</th>
			<th width='16%'>Celular</th>
			<th width='16%'>Empresa</th>
		</tr>
		</thead>
		<tbody>


		<?php

		$sql = "SELECT cadastro.*, expositores_capturas.dtc FROM cadastro INNER JOIN expositores_capturas ON expositores_capturas.idc = cadastro.idc WHERE expositores_capturas.idexp = '".$idexp."' ORDER BY cadastro.nome ASC";
		
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			while ($obj = mysqli_fetch_array($res)) {
					
				echo '<tr>';

				echo '<td>'.date("d/m/Y h:i:s", strtotime($obj['dtc'])).'</td>';
				echo '<td>'.$obj['nome'].'</td>';
				echo '<td>'.$obj['email'].'</td>';
				echo '<td>'.$obj['cel'].'</td>';
				echo '<td>'.$obj['empresa'].'</td>';
				

				echo '</tr>';

			}
		} else {
			echo "<tr><td colspan='5'>Nenhum capturado</td></tr>";
		}


		?>
		</tbody>
		</table>

		<?php include("rodape.php"); ?>

    </div> <!-- /container -->

	<?php include("scripts.php"); ?>

	
  </body>
</html>
