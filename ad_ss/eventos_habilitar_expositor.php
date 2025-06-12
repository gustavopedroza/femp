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
			<li>Habilitar Expositor</li>
		</ol>

		<?php

		$ide = $_REQUEST['ide'];
		$idc = $_REQUEST['idc'];

		?>

		<p><a href='https://expoaltotiete.com.br/ad_ss/eventos_cadastrados.php?ide=<?php echo $ide; ?>' class='btn btn-info'>Voltar</a></p>


		<?php

		if (isset($_REQUEST['senha'])) {
			
			$ide = $_REQUEST['ide'];
			$idc = $_REQUEST['idc'];
			$senha = trim($_REQUEST['senha']);

			$sql = "SELECT idexp FROM expositores WHERE idc = '".$idc."' AND ide = '".$ide."'";
			$res = mysqli_query($conn, $sql);
			$total = @mysqli_num_rows($res);
			if ($total) {
				$obj = mysqli_fetch_array($res);
				$sqli = "UPDATE expositores SET senha = '".$senha."' WHERE idexp = '".$obj['idexp']."'";
			} else {
				$sqli = "INSERT INTO expositores (ide, idc, senha) VALUES ('".$ide."', '".$idc."', '".$senha."')";
			}

			if (mysqli_query($conn, $sqli)) {
				echo "<div class='alert alert-success'>Dados salvo com sucesso!</div>";
			}

		}


	
		$nome = "";

		$sql = "SELECT nome FROM cadastro WHERE idc = '".$idc."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			$nome = $obj['nome'];
		}

		$senha = "";

		$sql = "SELECT senha FROM expositores WHERE idc = '".$idc."' AND ide = '".$ide."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			$senha = $obj['senha'];
		}

		?>

		<h2>Definir Acesso de Expositor [<?php echo $nome; ?>]</h2>
	
		<form method="post" action="eventos_habilitar_expositor.php">
		<div class='row'>
			<div class='col-md-3'>
				<label>Código de Acesso:</label>
				<input type="text" name="senha" class="form-control" value='<?php echo $senha; ?>'>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-12' style='margin-top: 10px;'>
				<input type="submit" class="btn btn-success" value="Salvar">
			</div>
		</div>
		<input type="hidden" name="idc" value="<?php echo $idc; ?>">
		<input type="hidden" name="ide" value="<?php echo $ide; ?>">
		</form>

		<?php include("rodape.php"); ?>

    </div> <!-- /container -->

	<?php include("scripts.php"); ?>

	
  </body>
</html>
