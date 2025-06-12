<?php
include('conf.php');
protege();

if (isset($_REQUEST['idexp'])) {

	$idexp = $_REQUEST['idexp'];

	# montar cabecalho
	$test = '';
	$test .= '<table border="1" cellpadding="2" cellspacing="1">';
	$test .= '<tr>';
	$test .= '
	
	
		<td>Data/Hora</th>
		<td>Nome</th>
		<td>E-mail</th>
		<td>Celular</th>
		<td>Empresa</th>
	
	
	';
	
	
	$test .= '</tr>';


	$sql = "SELECT cadastro.*, expositores_capturas.dtc FROM cadastro INNER JOIN expositores_capturas ON expositores_capturas.idc = cadastro.idc WHERE expositores_capturas.idexp = '".$idexp."' ORDER BY cadastro.nome ASC";		
	$res = mysqli_query($conn, $sql);
	$total = @mysqli_num_rows($res);
	if ($total) {
		while ($obj = mysqli_fetch_array($res)) {


			$test .=  '<tr>';

			$test .=  '<td>'.date("d/m/Y h:i:s", strtotime($obj['dtc'])).'</td>';
			$test .=  '<td>'.$obj['nome'].'</td>';
			$test .=  '<td>'.$obj['email'].'</td>';
			$test .=  '<td>'.$obj['cel'].'</td>';
			$test .=  '<td>'.$obj['empresa'].'</td>';
			

			$test .=  '</tr>';

			
		}
	}

	$test .= '</table>';

	$file = "exportacao_expositor_".date("d")."_".date("m")."_".date("Y")."_".rand(1, 10000).".xls";

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	
	echo $test;

}
?>
