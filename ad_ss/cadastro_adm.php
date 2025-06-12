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
			<li>Cadastro</li>
			<li>Editar</li>
		</ol>

		<?php

		$idc = $_REQUEST['idc'];

		if (isset($_REQUEST['submit'])) {
			
			$idc = $_REQUEST['idc'];

			$nome = $_REQUEST['nome'];
			$email = $_REQUEST['email'];
			$cel = $_REQUEST['cel'];
			$empresa = $_REQUEST['empresa'];
						
			$sqli = "UPDATE cadastro SET nome = '".$nome."', email = '".$email."', cel = '".$cel."', empresa = '".$empresa."' WHERE idc = '".$idc."'";
			if (mysqli_query($conn, $sqli)) {
				echo "<div class='alert alert-success'>Dados salvo com sucesso!<br><a href='".$v_url."/cadastro.php'>Voltar</a></div>";
			}

		}
	
		$nome = "";
		$cpf = "";
		$email = "";
		$cel = "";
		$empresa = "";

		$sql = "SELECT * FROM cadastro WHERE idc = '".$idc."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			$nome = $obj['nome'];
			$cpf = $obj['cpf'];
			$email = $obj['email'];
			$cel = $obj['cel'];
			$empresa = $obj['empresa'];
		}

		?>


		<form method="post" action="<?php echo $v_url; ?>/cadastro_adm.php?idc=<?php echo $idc; ?>">
		<fieldset>
			<div class="row">
				<div class="col-md-3">
					<label>CPF:</label>
					<p><?php echo $cpf; ?></p>
				</div>
				<div class="col-md-5">
					<label>Nome:</label>
					<input type="text" name="nome" id="nome" class="form-control" value='<?php echo $nome; ?>'>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5">
					<label>E-mail:</label>
					<input type="email" name="email" id="email" class="form-control" value='<?php echo $email; ?>'>
				</div>
				<div class="col-md-3">
					<label>Celular:</label>
					<input type="text" name="cel" id="cel" class="form-control" value='<?php echo $cel; ?>'>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<label>Empresa:</label>
					<input type="text" name="empresa" id="empresa" class="form-control" value='<?php echo $empresa; ?>'>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" style="margin-top: 10px;">
					<input type="submit" class="btn btn-success" value="Salvar" name="submit">
				</div>
			</div>
			</fieldset>
		</form>
		</fieldset>

		<?php include("rodape.php"); ?>

    </div> <!-- /container -->

	<?php include("scripts.php"); ?>

	
  </body>
</html>
