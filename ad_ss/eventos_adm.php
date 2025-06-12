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
			<li>Editar</li>
		</ol>

		<?php

		$ide = $_REQUEST['ide'];

		if (isset($_REQUEST['submit'])) {
			
			$evento = $_REQUEST['evento'];
			$pdf = $_REQUEST['pdf_s'];
			$logo = $_REQUEST['logo_s'];
			$img_fundo = $_REQUEST['img_fundo_s'];
			$campo_identificacao = $_REQUEST['campo_identificacao'];
			
			if ($ide == "0") {
				$sqli = "INSERT INTO eventos (evento, pdf, logo, img_fundo) VALUES ('".$evento."', '".$pdf."', '".$logo."', '".$img_fundo."')";
			} else {
				$sqli = "UPDATE eventos SET evento = '".$evento."', logo = '".$logo."', pdf = '".$pdf."', img_fundo  = '".$img_fundo."', campo_identificacao = '".$campo_identificacao."' WHERE ide = '".$ide."'";
			}

			if (mysqli_query($conn, $sqli)) {
				echo "<div class='alert alert-success'>Dados salvo com sucesso!<br><a href='".$v_url."/eventos/'>Voltar</a></div>";
			}

		}
	
		$evento = "";
		$pdf = "";
		$logo = "";
		$img_fundo = "";
		
		$logo_s = "";
		$img_fundo_s = "";
		$pdf_s = "";
		$campo_identificacao = "Empresa";
		
		$sql = "SELECT * FROM eventos WHERE ide = '".$ide."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			$evento = $obj['evento'];
			$pdf = $obj['pdf'];
			$logo = $obj['logo'];
			$img_fundo = $obj['img_fundo'];
			$campo_identificacao = $obj['campo_identificacao'];

			
			if ($logo <> "") {
				$logo_s = "<img src='https://expoaltotiete.com.br/arq/".$logo."' width='200'>";			
			}

			
			if ($img_fundo <> "") {
				$img_fundo_s = "<img src='https://expoaltotiete.com.br/arq/".$img_fundo."' width='200'>";			
			}

			$pdf_s = "<a href='https://expoaltotiete.com.br/arq/".$pdf."' target='_blank'>".$pdf."</a>";

			


		}

		?>
			

		<div id="salvar-aviso" style="background-color: #FFF; padding: 10px; position: fixed; margin-top: 50px; width: 200px; color: #000;"></div>

		<form method="post" action="<?php echo $v_url; ?>/eventos_adm.php?ide=<?php echo $ide; ?>">
		<fieldset>
			<div class="row">
				<div class="col-md-5">
					<label>Nome do Evento:</label>
					<input type="text" name="evento" id="evento" class="form-control" value='<?php echo $evento; ?>'>
				</div>
			</div>

			<div class="row">
				<div class="col-md-5">
					<label>Nome do campo de Identificação:</label>
					<input type="text" name="campo_identificacao" id="campo_identificacao" class="form-control" value='<?php echo $campo_identificacao; ?>'>
				</div>
			</div>

			<div class='row'>
				<div class='col-md-12'>
					<label>Logo:</label>
					<input type="file" name="logo" id="logo" multiple>
					
					<br><div id="logo_a"><?php echo $logo_s; ?></div>

				</div>
			</div>
			
			<div class='row'>
				<div class='col-md-12'>
					<label>PDF LGPD:</label>
					<input type="file" name="pdf" id="pdf" multiple>
					
					<br><div id="pdf_a"><?php echo $pdf_s; ?></div>

				</div>
			</div>
			
			<div class='row'>
				<div class='col-md-12'>
					<label>Imagem Fundo:</label>
					<input type="file" name="img_fundo" id="img_fundo" multiple>
					
					<br><div id="img_fundo_a"><?php echo $img_fundo_s; ?></div>
				</div>
			</div>

			
			<div class="row">
				<div class="col-md-12" style="margin-top: 10px;">
					<input type="submit" class="btn btn-success" value="Salvar" name="submit">
				</div>
			</div>
		
		
		
		<input type="hidden" name="id" id="ide" value="<?php echo $ide; ?>">

		<input type="hidden" name="pdf_s" id="pdf_s" value="<?php echo $pdf; ?>">
		<input type="hidden" name="img_fundo_s" id="img_fundo_s" value="<?php echo $img_fundo; ?>">
		<input type="hidden" name="logo_s" id="logo_s" value="<?php echo $logo; ?>">
		
		</fieldset>
		</form>
		

		<?php include("rodape.php"); ?>

    </div> <!-- /container -->

	<?php include("scripts.php"); ?>

	<script>
	$(document).ready( function() {

		$("#img_fundo").change(function (){
		   
			var formData = new FormData();

			$("#img_fundo_a").html("Processando...");

			formData.append('image', $('#img_fundo').prop('files')[0]);
			
			$.ajax({
				url: '<?php echo $v_url; ?>/core.php?acao=upload-arquivo',
				data: formData,
				type: 'post',
				success: function(response)
				{

					var obj = response.split("|");
					if (obj[0] == 1) {
						$("#img_fundo_s").val(obj[1]);
						$("#img_fundo_a").html("<img src='https://expoaltotiete.com.br/arq/"+obj[1]+"' width='100'>");	
					} else {
						alert("Erro! " + obj[1]);
						$("#img_fundo_a").html("");
					}
				},
				processData: false,
				cache: false,
				contentType: false
			 });

		 });

		$("#logo").change(function (){
		   
			var formData = new FormData();

			alert("entr");
			
			formData.append('image', $('#logo').prop('files')[0]);
			$.ajax({
				url: 'https://expoaltotiete.com.br/ad_ss/core.php?acao=upload-arquivo',
				data: formData,
				type: 'post',
				success: function(response)
				{
					
					alert(response);
					
					var obj = response.split("|");

					if (obj[0] == 1) {
						$("#logo_s").val(obj[1]);
						$("#logo_a").html("<img src='https://expoaltotiete.com.br/arq/"+obj[1]+"' width='100'>");	
					} else {
						alert("Erro! " + obj[1]);
					}
				},
				processData: false,
				cache: false,
				contentType: false
			 });

		 });

		 $("#pdf").change(function (){
		   
			var formData = new FormData();
			
			formData.append('image', $('#pdf').prop('files')[0]);
			$.ajax({
				url: '<?php echo $v_url; ?>/core.php?acao=upload-arquivo',
				data: formData,
				type: 'post',
				success: function(response)
				{
					var obj = response.split("|");

					if (obj[0] == 1) {
						$("#pdf_s").val(obj[1]);
						$("#pdf_a").html("https://expoaltotiete.com.br/arq/"+obj[1]+"");
					} else {
						alert("Erro! " + obj[1]);
					}
				},
				processData: false,
				cache: false,
				contentType: false
			 });

		 });


	
		
	});
	</script>

	
  </body>
</html>
