<?php
include('conf.php'); 
$var_acesso = '';

if (isset($_POST['email'])) {

	$email =  mysqli_real_escape_string($conn,$_POST['email']);
	$senha =  mysqli_real_escape_string($conn,$_POST['senha']);

	$sql = "SELECT * FROM usu WHERE email = '".$email."' AND senha = '".$senha."'";
	$res = mysqli_query($conn, $sql);
	$total = @mysqli_num_rows($res);
	if ($total) {
		$obj = @mysqli_fetch_array($res);
		$v_permite_login = True;
		$_SESSION['id'] = $obj['idu'];
		$_SESSION['acesso'] = 'usu';
		$_SESSION['nome'] = $obj['nome'];
		header("location: ".$v_url."/inicio/");
	} else {
		$var_acesso = 1;
	}
}

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $v_tit; ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <link href="<?php echo $v_url; ?>/css/signin.css" rel="stylesheet">

	</head>

  <body>

    <div class="container">


      <form class="form-signin" id="login" method="post" action="<?php echo $v_url; ?>/">
	    <center><h1><?php echo $v_tit; ?></h1></center>
        <p>Por favor, informe seus dados:</p>
        <input type="text" class="form-control" name="email" placeholder="e-mail" required autofocus>
        <input type="password" class="form-control" name="senha" placeholder="Senha" required>
		<input type="submit" class="btn btn-lg btn-danger btn-block" value="Acessar" style='margin-top: 5px;'>
		</br>
		<?php
		if ($var_acesso == 1) {
			echo '<div class="alert alert-danger" role="alert">E-mail/Senha n&atilde;o conferem!</div>';
		}
		?>
      </form>
	  
    </div> 

		<?php include("scripts.php"); ?>

			<script>
			$().ready(function() {

			$('input').keydown( function(e) {
				var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
				if(key == 13) {
					e.preventDefault();
					var inputs = $(this).closest('form').find(':input:visible');
					inputs.eq( inputs.index(this)+ 1 ).focus();
				}
			});

		});
	</script>

  </body>
</html>