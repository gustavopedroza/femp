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
		</ol>
		
		<p><a class="btn btn-info" href="<?php echo $v_url; ?>/eventos_adm.php?ide=0">Novo Evento</a></p>

		<table class="table table-hover">
		<thead>
		<tr>
			<th width='30%'>Evento</th>
			<th width='70%'>Controle</th>
		</tr>
		</thead>
		<tbody>


		<?php
		
		$sql = "SELECT * FROM eventos ORDER BY ide DESC";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			while ($obj = mysqli_fetch_array($res)) {

				
				echo '<tr>';
				
				echo '<td>'.$obj['evento'].'</td>';
				echo '<td>';
				
				echo ' <a class="btn btn-default" href="'.$v_url.'/eventos_adm.php?ide='.$obj['ide'].'">Editar</a> ';
				echo ' <a class="btn btn-default" href="'.$v_url_site.'cadastramento/'.$obj['ide'].'/" target="_blank">Link Cadastramento (Mesa/Celular)</a> ';
				echo ' <a class="btn btn-default" href="'.$v_url_site.'expositor-cadastro/'.$obj['ide'].'/" target="_blank">Auto Cadastramento Expositores</a> ';
				echo ' <a class="btn btn-default" href="'.$v_url.'/eventos-cadastrados/'.$obj['ide'].'/">Cadastrados</a> ';
				echo ' <a class="btn btn-default" href="'.$v_url.'/eventos-expositores/'.$obj['ide'].'/">Expositores</a> ';
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
