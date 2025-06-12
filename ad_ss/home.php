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
    <link rel="icon" href="favicon.ico">

    <title><?php echo $v_tit; ?></title>

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

		<?php include("topo.php"); ?>
			  
		<ol class="breadcrumb">
			<li>Home</li>
		</ol>
			
		<h5>Bem-Vindo!</h5>
		
		<?php 
		if (isset($_REQUEST['s'])) {
			echo '<p class="alert alert-success">Salvo com sucesso!</p>';
		}

		?>

		<?php include("rodape.php"); ?>

    </div> <!-- /container -->

	<?php include("scripts.php"); ?>

	
  </body>
</html>
