<?php
include('conf.php'); 


	define('MPDF_PATH', 'mpdf60/');
	include(MPDF_PATH.'mpdf.php');

	$mpdf=new mPDF('utf-8', array(110,50));

	$mpdf->WriteHTML('	
			<style>
			@page {
				margin-top: 0.2cm;
				margin-bottom: 0.1cm;
				margin-left: 0.1cm;
				margin-right: 0.1cm;
				footer: html_letterfooter2;
				font-family: tahoma, verdana;
				font-size: 10pt;
				font-family: arial;
			}
			td {font-family: arial;}
			
		</style>');
	
	$nome = "";
	$empresa = "";

	$html = "";
	
	$sql = "SELECT cadastro.*, cadastro_eventos.idce FROM cadastro_eventos INNER JOIN cadastro ON cadastro.idc = cadastro_eventos.idc  ORDER BY cadastro.nome ASC";
	echo $sql;
	$res = mysqli_query($conn, $sql);
	$total = @mysqli_num_rows($res);
	if ($total) {
	while ($obj = mysqli_fetch_array($res)) {
		
		
		$nome = trim($obj['nome']);
		$empresa = trim($obj['empresa']);
		$idce = $obj['idce'];
		if (strlen($nome) > 15) {
			$nome = substr($nome,0,15);
		}

		if (strlen($empresa) > 30) {
			$empresa = substr($empresa,0,30);
		}

		$code = '<barcode code="https://expoaltotiete.com.br/qr/'.$idce.'/" size="1" type="QR" error="M" class="barcode" />';

		$html = $html . '<table style="margin-top: 0px;" width="95%" align="center" border="0" cellspacing="1" cellpadding="2"><tr><td align="center" valign="top"><br>'.$code.'</td><td align="center" style="text-align: center; font-size: 20pt; font-weight: bold; margin: 0px;">'.utf8_encode($nome).'<br><span style="margin: 0px; font-size:12pt; text-align: center; font-weight: bold;">'.utf8_encode($empresa).'</span></td></tr></table>';


	}

	
	
}


$mpdf->WriteHTML($html);

$mpdf->Output();
exit();





?>