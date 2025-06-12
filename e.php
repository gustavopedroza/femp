<?php 
include('ad_ss/conf.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>QR Consulta</title>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- <script src="../../assets/js/ie-emulation-modes-warning.js"></script> -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


  </head>

  <body>

    <div class="container">
		
		<h1 style='text-align: center;'>Controle de Evento<BR>QR Code</h1>


		<?php
			
		$data_atual = date("Y-m-d h:i:s");

		if (isset($_REQUEST['idce'])) {

			$idce = $_REQUEST['idce'];

		}

		if (isset($_REQUEST['sair'])) {

			unset($_SESSION['idexp']);
			unset($_SESSION['nomeexp']);


		}

		if (isset($_REQUEST['senha'])) {


			// obtem evento do registro e verifica se ele realmente é expoxitor para este evento
			
			$ide = "";

			$sql = "SELECT ide FROM cadastro_eventos WHERE idce = '".$idce."'";
			$res = mysqli_query($conn, $sql);
			$total = @mysqli_num_rows($res);
			if ($total) {
				$obj = mysqli_fetch_array($res);
				$ide = $obj['ide'];
			}

			$senha = trim($_REQUEST['senha']);

			if ($ide <> "" && $senha <> "") {
				
				// consulta se expositor existe
				$sql = "SELECT expositores.idexp, expositores.idc, cadastro.nome FROM expositores INNER JOIN cadastro ON cadastro.idc = expositores.idc WHERE ide = '".$ide."' AND senha = '".$senha."'";
				$res = mysqli_query($conn, $sql);
				$total = @mysqli_num_rows($res);
				if ($total) {
					// sem sim, atribui sessão
					$obj = mysqli_fetch_array($res);
					$_SESSION['idexp'] = $obj['idexp'];
					$_SESSION['nomeexp'] = $obj['nome'];
				} else {
					echo "<div class='alert alert-danger'>Dados de evento ou código de acesso inválido!</div>";
				}
				
			} else {
				echo "<div class='alert alert-danger'>Dados de evento ou código de acesso em branco!</div>";
			}

		}

	

		if (isset($_SESSION['idexp'])) {

			$sql = "SELECT cadastro.* FROM cadastro_eventos INNER JOIN cadastro ON cadastro.idc = cadastro_eventos.idc WHERE idce = '".$idce."'";
			$res = mysqli_query($conn, $sql);
			$total = @mysqli_num_rows($res);
			if ($total) {
				$obj = mysqli_fetch_array($res);
				
				// exibir dados
				echo "<h3 style='text-align: center; font-weight: bold;'>".$obj['nome']."</h3>";
				echo "<h2 style='text-align: center; font-weight: bold;'>".$obj['empresa']."</h2>";
				echo "<h2 style='text-align: center; font-weight: bold;'>".$obj['email']."</h2>";
				echo "<h2 style='text-align: center; font-weight: bold;'>".$obj['cel']."</h2>";

				// capturar dados

				
				// verifica se ja nao capturou

				$sql = "SELECT idexp FROM expositores_capturas WHERE idexp = '".$_SESSION['idexp']."' AND idc = '".$obj['idc']."'";
				$res = mysqli_query($conn, $sql);
				$total = @mysqli_num_rows($res);
				if (!$total) {
					$sqli = "INSERT INTO expositores_capturas (idexp, idc, dtc) VALUES ('".$_SESSION['idexp']."', '".$obj['idc']."', '".$data_atual."')";
					if (mysqli_query($conn, $sqli)) {
						echo "<div class='alert alert-success' style='margin-top: 10px;'>Dados capturados com sucesso!</div>";
					}
				} else {
					echo "<div class='alert alert-success' style='margin-top: 10px;'>Dados já capturados!</div>";
				}

			}


			$sql = "SELECT cadastro.nome, idexp FROM expositores INNER JOIN cadastro ON cadastro.idc = expositores.idc WHERE idexp = '".$_SESSION['idexp']."' ";
			$res = mysqli_query($conn, $sql);
			$total = @mysqli_num_rows($res);
			if ($total) {
				$obj = mysqli_fetch_array($res);
					echo "<hr><p align='center'><font size='1'>Logado como ".$obj['nome'].". <a href='https://expoaltotiete.com.br/e.php?idce=".$idce."&sair=1'>Clique para sair</a></font></p>";
			}


		} else {


		?>
		<fieldset>
		<form method='post' action='https://expoaltotiete.com.br/qr/<?php echo $idce; ?>/'>
		<div class='row'>
			<div class='col-md-12'>
				<label>Acesso Expositor</label>
				<input type="text" name="senha" class='form-control'>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-12' style='margin-top: 10px;'>
				<input type="submit" value='Acessar' class='btn btn-success'>
			</div>
		</div>
		<input type="hidden" name="idce" value='<?php echo $idce; ?>'>
		</form>


		<?php

		// se nao possui acesso especial apenas mosta como válido

		$sql = "SELECT cadastro.* FROM cadastro_eventos INNER JOIN cadastro ON cadastro.idc = cadastro_eventos.idc WHERE idce = '".$idce."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			echo "<h3 style='text-align: center;'>Acesso Válido</h3>";
		}


		}
		

		?>

		
    </div> <!-- /container -->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>	
	
  </body>
</html>
