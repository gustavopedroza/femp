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

    <title>Cadastramento</title>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- <script src="../../assets/js/ie-emulation-modes-warning.js"></script>
 -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


  </head>

  <body>

    <div class="container">

	
		
		<?php 

		$ide = $_REQUEST['ide'];
		$evento_nome = "";

		$sql = "SELECT * FROM eventos WHERE ide = '".$ide."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			$evento_nome = $obj['evento'];
			$campo_identificacao = $obj['campo_identificacao'];

		}

		?>

		<h3>Cadastro - <?php echo $evento_nome; ?></h3>
		<hr>

		<div class='alert alert-warning'>
			<p><b>Importante:</b> Lembramos da importância de considerar os documentos abaixo:</p>				
			<p><a href='https://expoaltotiete.com.br/docs/politica-privacidade-aexpo.pdf' target='_blank'>POLÍTICA DE PRIVACIDADE</a></p>
			<p><a href='https://expoaltotiete.com.br/docs/termo-compartilhamento-sigilo-info.pdf' target='_blank'>TERMO DE COMPARTILHAMENTO DE DADOS E SIGILO DE INFORMAÇÃO</a></p>
		</div>


		<div class='row'>
			<div class='col-md-2'>
				<label>CPF:</label>
				<input type="text" name="cpf" id="cpf">
			</div>
				<div class='col-md-2' style='padding-top: 20px;'>

				<input type="button" value="Pesquisa" onclick="cpf_pesquisar();" class="btn btn-default">
			</div>
		</div>

		<div class='row'>
			<div class='col-md-12' id='area_pesquisa'>
		</div>


		
    </div> <!-- /container -->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="<?php echo $v_url_site; ?>/ad_ss/js/jquery-ui.js?i=83446353"></script>
	<script src="<?php echo $v_url_site; ?>/ad_ss/js/jquery.maskedinput.min.js?i=8362353"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css?i=8344611353">

	<script>
	$(document).ready( function() {

		$("#cpf").mask("999.999.999-99");

		cpf_pesquisar = function() {
			
			var cpf = $("#cpf").val();

			if (cpf == "") {
				alert("Informe o CPF para pesquisar!");
			} else {

				$.ajax({
					method : 'post',
					url    : '<?php echo $v_url_site; ?>/core.php?acao=expositor_cpf_pesquisar&cpf='+cpf+'&ide=<?php echo $ide; ?>',
					success : function(retorno){
						$("#area_pesquisa").html(retorno);
						
						$('#c_cel').mask("(99) 99999-999?9")
						.focusout(function (event) {  
						var target, phone, element;  
						target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
						phone = target.value.replace(/\D/g, '');
						element = $(target);  
						element.unmask();  
						if(phone.length > 10) {  
							element.mask("(99) 99999-999?9");  
						} else {  
							element.mask("(99) 9999-9999?9");  
						}  
					});
					
					}
				});

			}

		}


		cadastrar = function() {

			var c_cpf = $("#c_cpf").val();
			var c_nome = $("#c_email").val();
			var c_email = $("#c_email").val();
			var c_cel = $("#c_cel").val();
			var c_empresa = $("#c_empresa").val();

			var erro = "";

			if (c_cpf == "") {
				erro = "O campo CPF deve ser informado!";
			}

			if (c_nome == "") {
				erro = "O campo NOME deve ser informado!";
			}

			if (c_email == "") {
				erro = "O campo E-MAIL deve ser informado!";
			}

			if (c_cel == "") {
				erro = "O campo CELULAR deve ser informado!";
			}

			if (c_empresa == "") {
				erro = "Todos os campos são obrigatórios!";
			}

			if (erro != "") {
				alert(erro);
			} else {

				$.ajax({
					method : 'post',
					data: $("#form-dados").serialize(),
					url    : '<?php echo $v_url_site; ?>/core.php?acao=expositor_cadastro&ide=<?php echo $ide; ?>',
					success : function(retorno){
						$("#area_pesquisa").html("");
						$("#area_pesquisa").html(retorno);
						
					}
				});

			}
		}


	});
	</script>

	
	
  </body>
</html>
