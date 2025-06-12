<?php
include('ad_ss/conf.php');

$data_atual = date("Y-m-d h:i:s");

if (isset($_REQUEST['acao'])) {

	$acao = $_REQUEST['acao'];

	if ($acao == "cadastrar") {

		$ide = $_REQUEST["ide"];
		$cpf = $_REQUEST["c_cpf"];
		$nome = utf8_decode($_REQUEST["c_nome"]);
		$email = $_REQUEST["c_email"];
		$cel = $_REQUEST["c_cel"];
		$empresa = utf8_decode($_REQUEST["c_empresa"]);
		
		$sqli = "INSERT INTO cadastro (cpf, nome, email, cel, empresa, dtins) VALUES ('".$cpf."', '".$nome."', '".$email."', '".$cel."', '".$empresa."', '".$data_atual."')";
		if (mysqli_query($conn, $sqli)) {
			echo "1";
		} else {
			echo "0";
		}

	}

	if ($acao == "cpf_pesquisar") {

		$cpf = $_REQUEST["cpf"];
		$ide = $_REQUEST["ide"];
		

		$sql = "SELECT pdf, campo_identificacao FROM eventos WHERE ide = '".$ide."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			$pdf = $obj['pdf'];
			$campo_identificacao = $obj['campo_identificacao'];
		}


		$sql = "SELECT * FROM cadastro WHERE cpf = '".$cpf."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			while ($obj = mysqli_fetch_array($res)) {

				// localizou pessoa
				$idc = $obj['idc'];
				
				echo "<div class='row'>";
				echo "<div class='col-md-12' style='border: 1px solid #fff; padding: 20px; font-size: 20px; font-weight: bold;'>";
				echo $obj['nome'].'<br>';
				echo $obj['empresa'].'<br>';
				echo "</div>";
				echo "</div>";
				
				// verifica se já deu entrada no evento, se não, dá entrada
				$sql = "SELECT * FROM cadastro_eventos WHERE idc = '".$idc."' AND ide = '".$ide."'";
				$res = mysqli_query($conn, $sql);
				$total2 = @mysqli_num_rows($res);
				if (!$total2) {
					$sqli = "INSERT INTO cadastro_eventos (idc, ide, dt) VALUES ('".$idc."', '".$ide."', '".$data_atual."')";
					if (mysqli_query($conn, $sqli)) {
						$idce = mysqli_insert_id($conn);
						echo "<div class='row'><div class='col-md-12'>";
							echo "<div class='alert alert-success'>Vinculado com Sucesso!</div>";
						echo "</div></div>";
					}
				} else {
					$obj = mysqli_fetch_array($res);
					$idce = $obj['idce'];
					echo "<div class='row'><div class='alert alert-warning'>Já vinculado em ".date("d/m/Y H:i:s", strtotime($obj['dt']))."</div></div>";
				
				}

				// se sim, avisa e botao imprime crachá

				echo "<a href='https://expoaltotiete.com.br/cadastramento_imprimir.php?idce=".$idce."' target='_blank' class='btn btn-success'>Imprimir Etiqueta</a>";

				
			}
		}


		if ($total == 0) {
			
			// tela para cadastrar pessoa

			$echo = '


			<h4 style="margin-top: 20px;">Pessoa não cadastrada. Preencha abaixo para cadastrar</h4>

			<div class="form-painel">
			<form id="form-dados" method="post" >
			<fieldset>
				<div class="row">
					<div class="col-md-3">
						<label>CPF:</label>
						<p>'.$cpf.'</p>
					</div>
					<div class="col-md-5">
						<label>Nome:</label>
						<input type="text" name="c_nome" id="c_nome" value="" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="col-md-5">
						<label>E-mail:</label>
						<input type="email" name="c_email" id="c_email" value="" class="form-control">
					</div>
					<div class="col-md-3">
						<label>Celular:</label>
						<input type="text" name="c_cel" id="c_cel" value="" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<label>'.$campo_identificacao.':</label>
						<input type="text" name="c_empresa" id="c_empresa" value="" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="margin-top: 10px;">
						<input type="button" class="btn btn-success" value="Cadastrar" onclick="cadastrar();">
					</div>
				</div>
				</fieldset>
				<input type="hidden" name="c_cpf" id="c_cpf" value="'.$cpf.'">
				</form>
			';

			
			echo $echo;		
			

		
		}

	}


	if ($acao == "expositor_cpf_pesquisar") {

		$cpf = $_REQUEST["cpf"];
		$ide = $_REQUEST["ide"];
		$email = "";
		$nome = "";
		
		$sql = "SELECT pdf, campo_identificacao FROM eventos WHERE ide = '".$ide."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			$pdf = $obj['pdf'];
			$campo_identificacao = $obj['campo_identificacao'];
		}

		$sql = "SELECT * FROM cadastro WHERE cpf = '".$cpf."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);

			// localizou pessoa
			$idc = $obj['idc'];
			$email = $obj['email'];
			$nome = $obj['nome'];

			// verifica se já deu entrada no evento, se não, dá entrada
			$sql = "SELECT * FROM cadastro_eventos WHERE idc = '".$idc."' AND ide = '".$ide."'";
			$res = mysqli_query($conn, $sql);
			$total2 = @mysqli_num_rows($res);
			if (!$total2) {
				$sqli = "INSERT INTO cadastro_eventos (idc, ide, dt) VALUES ('".$idc."', '".$ide."', '".$data_atual."')";
				mysqli_query($conn, $sqli);
			}

			// verifica se já cadastrada como expositor
			$sql = "SELECT * FROM expositores WHERE idc = '".$idc."' AND ide = '".$ide."'";
			$res = mysqli_query($conn, $sql);
			$total2 = @mysqli_num_rows($res);
			if (!$total2) {
				
				$senha = $cpf;
				$senha = str_replace(".","",$senha);
				$senha = str_replace("-","",$senha);
				$senha = str_replace("/","",$senha);
				$senha = str_replace(" ","",$senha);

				$senha = "E".$ide.$senha;

				$sqli = "INSERT INTO expositores (idc, ide, senha) VALUES ('".$idc."', '".$ide."', '".$senha."')";
				if (mysqli_query($conn, $sqli)) {

					$idce = mysqli_insert_id($conn);
					echo "<div class='row'><div class='col-md-12'>";
						echo "<div class='alert alert-success'>Acesso de expositor criado com sucesso!<br>Seu código de acesso é: ".$senha."<br>Um email com o código de acesso também foi enviado para o seu e-mail ".$email."</div>";
					echo "</div></div>";

					$html = 
				
				"
				<html>
				<body>
					<font face='tahoma' size='2'>
						<p>Olá ".$nome."</p>
						<p>Seu cadastro de expositor foi criado com sucesso.</p>
						<p>Para capturar dados de visitantes, utilize o código <b>".$senha."</b> na tela de leitura de QR Code.</p>

						<p><b>Importante:</b> Lembramos da importância de considerar os documentos abaixo:</p>
						
						<p><a href='https://expoaltotiete.com.br/arq/".$pdf."'>POLÍTICA DE PRIVACIDADE</a></p>
						<p><a href='https://expoaltotiete.com.br/docs/termo-compartilhamento-sigilo-info.pdf'>TERMO DE COMPARTILHAMENTO DE DADOS E SIGILO DE INFORMAÇÃO</a></p>


				</body>
				</html>

				";
				
				

				$end = array();
				array_push($end, array('address' => ['email'=>utf8_encode($email)]));


				$json = array();
				$json["options"]["sandbox"] = false;
				$json["recipients"] = $end;
				$json["content"]["from"]["name"] = "AEXPO";
				$json["content"]["from"]["email"] = "contato@expoaltotiete.com.br";

				$json["content"]["subject"] = "Cadastro de Expositor";
				$json["content"]["html"] = utf8_encode($html);
				$ch = curl_init("https://api.sparkpost.com/api/v1/transmissions");
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Authorization: 28fbd7c45098de46b3ac4b547ca33758a49cc85c',
				'Content-Type: application/json'
				));

				$data = curl_exec($ch);
				curl_close($ch);

				$retorno = json_decode($data);
				
			

				}
			} else {

				echo "<div class='row'>";
				echo "<div class='col-md-12' style='border: 1px solid #fff; padding: 20px; font-size: 20px; font-weight: bold;'>";
				echo "Pessoa já cadastrada como expositor!";
				echo "</div>";
				echo "</div>";
			
			}				

			
		}


		if ($total == 0) {
			
			// tela para cadastrar pessoa

			$echo = '


			<h4 style="margin-top: 20px;">Pessoa não cadastrada. Preencha abaixo para cadastrar</h4>

			<div class="form-painel">
			<form id="form-dados" method="post" >
			<fieldset>
				<div class="row">
					<div class="col-md-3">
						<label>CPF:</label>
						<p>'.$cpf.'</p>
					</div>
					<div class="col-md-5">
						<label>Nome:</label>
						<input type="text" name="c_nome" id="c_nome" value="" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="col-md-5">
						<label>E-mail:</label>
						<input type="email" name="c_email" id="c_email" value="" class="form-control">
					</div>
					<div class="col-md-3">
						<label>Celular:</label>
						<input type="text" name="c_cel" id="c_cel" value="" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<label>'.$campo_identificacao.':</label>
						<input type="text" name="c_empresa" id="c_empresa" value="" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="margin-top: 10px;">
						<input type="button" class="btn btn-success" value="Cadastrar" onclick="cadastrar();">
					</div>
				</div>
				</fieldset>
				<input type="hidden" name="c_cpf" id="c_cpf" value="'.$cpf.'">
				</form>
			';

			
			echo $echo;		
			

		
		}

	}

	if ($acao == "expositor_cadastro") {

		$ide = $_REQUEST["ide"];
		$cpf = $_REQUEST["c_cpf"];
		$nome = $_REQUEST["c_nome"];
		$email = $_REQUEST["c_email"];
		$cel = $_REQUEST["c_cel"];
		$empresa = $_REQUEST["c_empresa"];

		
		$sqli = "INSERT INTO cadastro (cpf, nome, email, cel, empresa, dtins) VALUES ('".$cpf."', '".$nome."', '".$email."', '".$cel."', '".$empresa."', '".$data_atual."')";
		if (mysqli_query($conn, $sqli)) {
			$idc = mysqli_insert_id($conn);
		}

		if ($idc <> "") {

			// verifica se já deu entrada no evento, se não, dá entrada
			$sql = "SELECT * FROM cadastro_eventos WHERE idc = '".$idc."' AND ide = '".$ide."'";
			$res = mysqli_query($conn, $sql);
			$total2 = @mysqli_num_rows($res);
			if (!$total2) {
				$sqli = "INSERT INTO cadastro_eventos (idc, ide, dt) VALUES ('".$idc."', '".$ide."', '".$data_atual."')";
				mysqli_query($conn, $sqli);
			}

			// verifica se já cadastrada como expositor
			$sql = "SELECT * FROM expositores WHERE idc = '".$idc."' AND ide = '".$ide."'";
			$res = mysqli_query($conn, $sql);
			$total2 = @mysqli_num_rows($res);
			if (!$total2) {
				
				$senha = $cpf;
				$senha = str_replace(".","",$senha);
				$senha = str_replace("-","",$senha);
				$senha = str_replace("/","",$senha);
				$senha = str_replace(" ","",$senha);

				$senha = "E".$ide.$senha;

				$sqli = "INSERT INTO expositores (idc, ide, senha) VALUES ('".$idc."', '".$ide."', '".$senha."')";
				if (mysqli_query($conn, $sqli)) {

					$idce = mysqli_insert_id($conn);
					echo "<div class='row'><div class='col-md-12'>";
						echo "<div class='alert alert-success'>Acesso de expositor criado com sucesso!<br>Anote o seu código de acesso para o evento: ".$senha."<br>Um email com o código de acesso também foi enviado para o seu e-mail ".$email."</div>";
					echo "</div></div>";

					$html = 
					
					"
					<html>
					<body>
						<font face='tahoma' size='2'>
							<p>Olá ".$nome."</p>
							<p>Seu cadastro de expositor foi criado com sucesso.</p>
							<p>Para capturar dados de visitantes, utilize o código <b>".$senha."</b> na tela de leitura de QR Code.</p>

							<p><b>Importante:</b> Lembramos da importância de considerar os documentos abaixo:</p>
							
							<p><a href='https://expoaltotiete.com.br/docs/politica-privacidade-aexpo.pdf'>POLÍTICA DE PRIVACIDADE</a></p>
							<p><a href='https://expoaltotiete.com.br/docs/termo-compartilhamento-sigilo-info.pdf'>TERMO DE COMPARTILHAMENTO DE DADOS E SIGILO DE INFORMAÇÃO</a></p>


					</body>
					</html>

					";


					$end = array();
					array_push($end, array('address' => ['email'=>utf8_encode($email)]));


					$json = array();
					$json["options"]["sandbox"] = false;
					$json["recipients"] = $end;
					$json["content"]["from"]["name"] = "AEXPO";
					$json["content"]["from"]["email"] = "contato@expoaltotiete.com.br";

					$json["content"]["subject"] = "Cadastro de Expositor";
					$json["content"]["html"] = utf8_encode($html);
					$ch = curl_init("https://api.sparkpost.com/api/v1/transmissions");
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Authorization: 28fbd7c45098de46b3ac4b547ca33758a49cc85c',
					'Content-Type: application/json'
					));

					$data = curl_exec($ch);
					curl_close($ch);

					$retorno = json_decode($data);
				
				
				}

			} else {

				echo "<div class='row'>";
				echo "<div class='col-md-12' style='border: 1px solid #fff; padding: 20px; font-size: 20px; font-weight: bold;'>";
				echo "Pessoa já cadastrada como expositor!";
				echo "</div>";
				echo "</div>";
			
			}				

		}


	}

}