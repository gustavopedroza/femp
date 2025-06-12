<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('America/Sao_Paulo');

/*
if (! isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] == 'off' ) {

	$dom = $_SERVER['HTTP_HOST'];

	$redirect_url = "https://satreseguros.com.br/"; 
	if ($dom == "segurocombustivel.com.br") {
		$redirect_url = "https://satreseguros.com.br/seguro-combustivel/"; 
	}
	header("Location: $redirect_url");
    exit();
}
*/

session_start();
header ('Content-type: text/html; charset=ISO-8859-1');
include("class.phpmailer.php");


$conn = mysqli_connect('localhost','u139844934_usuexpo','U8279381kd@#','u139844934_bdexpo') or die ("Nao e possivel conectar a base de dados");
mysqli_set_charset( $conn  , "latin1" );

$v_tit = 'Administraзгo de Eventos';

$v_url = 'https://expoaltotiete.com.br/ad_ss';
$v_url_site = 'https://expoaltotiete.com.br/';
$pasta_upload = "../arq/";
$caminho_server = "/home/u139844934/domains/expoaltotiete.com.br/public_html/arq/";

$url_princ = "https://expoaltotiete.com.br/";

function nomepag() {
	return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

function gerasenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	$retorno = '';
	$caracteres = '';
	#$caracteres .= $lmin;
	#if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	#if ($simbolos) $caracteres .= $simb;
	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) {
	$rand = mt_rand(1, $len);
	$retorno .= $caracteres[$rand-1];
	}
	return $retorno;
}

function protege() {
	if (!isset($_SESSION['id'])) {
		header("location: ".$v_url."/sair/");
	}
}

function email($para_email, $para_nome, $assunto, $html) {

	$mail2 = new PHPMailer;
	$mail2->IsSMTP();
	$mail2->SMTPAuth   = true;
	$mail2->Port       = 587;

	$mail2->Host       = "smtp.hostinger.com";
	$mail2->Username =   "site@satreseguros.com.br";
	$mail2->Password =   "Valdi21+";
	$mail2->Subject  =   $assunto;
	$mail2->From = "site@satreseguros.com.br";
	$mail2->FromName = "SATRE SEGUROS";

	#$mail2->SMTPDebug = true;
	//$mail2->AddAddress('valdileibranco@gmail.com', 'Valdilei Branco');
	$mail2->AddAddress($para_email, $para_nome);	
	$mail2->Subject = $assunto;
	$mail2->AltBody = "Para ver essa mensagem, use um programa compatнvel com HTML!"; // optional, comment out and test
	$mail2->MsgHTML($html);
	if ($mail2->Send()) {
		return 1;
	} else {
		return $mail2->ErrorInfo;
	}
}

function tirarAcentos($string){
    return preg_replace(array("/(б|а|г|в|д)/","/(Б|А|Г|В|Д)/","/(й|и|к|л)/","/(Й|И|К|Л)/","/(н|м|о|п)/","/(Н|М|О|П)/","/(у|т|х|ф|ц)/","/(У|Т|Х|Ф|Ц)/","/(ъ|щ|ы|ь)/","/(Ъ|Щ|Ы|Ь)/","/(с)/","/(С)/"),explode(" ","a A e E i I o O u U n N"),$string);
}

function is_utf8($string) {
 
    // From http://w3.org/International/questions/qa-forms-utf-8.html
    return preg_match('%^(?: [x09x0Ax0Dx20-x7E] # ASCII
    | [xC2-xDF][x80-xBF] # non-overlong 2-byte
    | xE0[xA0-xBF][x80-xBF] # excluding overlongs
    | [xE1-xECxEExEF][x80-xBF]{2} # straight 3-byte
    | xED[x80-x9F][x80-xBF] # excluding surrogates
    | xF0[x90-xBF][x80-xBF]{2} # planes 1-3
    | [xF1-xF3][x80-xBF]{3} # planes 4-15
    | xF4[x80-x8F][x80-xBF]{2} # plane 16
    )*$%xs', $string);
}

function slug($string, $slug = "-") {
 
    //Setamos o localidade
    setlocale(LC_ALL, 'pt_BR');
 
    //Verificamos se a string й UTF-8
    if (is_utf8($string))
        $string = utf8_decode($string);
 
    //Se a flag 'slug' for verdadeira, transformamos o texto para lowercase
    if ($slug)
        $string = strtolower($string);
 
    // Cуdigo ASCII das vogais
    $ascii['a'] = range(224, 230);
    $ascii['e'] = range(232, 235);
    $ascii['i'] = range(236, 239);
    $ascii['o'] = array_merge(range(242, 246), array(240, 248));
    $ascii['u'] = range(249, 252);
 
    // Cуdigo ASCII dos outros caracteres
    $ascii['b'] = array(223);
    $ascii['c'] = array(231);
    $ascii['d'] = array(208);
    $ascii['n'] = array(241);
    $ascii['y'] = array(253, 255);
 
    //Fazemos um loop para criar as regras de troca dos caracteres acentuados
    foreach ($ascii as $key => $item) {
 
        $acentos = '';
        foreach ($item AS $codigo)
            $acentos .= chr($codigo);
        $troca[$key] = '/[' . $acentos . ']/i';
    }
 
    //Aplicamos o replace com expressao regular
    $string = preg_replace(array_values($troca), array_keys($troca), $string);
 
        //Se a flag 'slug' for verdadeira...
    if ($slug) {
 
        //Troca tudo que nгo for letra ou nъmero por um caractere ($slug)
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
 
        //Tira os caracteres ($slug) repetidos
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);
    }
 
    return trim($string);
}

function reordena_itens($ida) {
	global $conn;
	$sql = "SELECT idi FROM itens WHERE ida = '".$ida."' ORDER BY ordem ASC;";
	$res = mysqli_query($conn, $sql);
	$total = @mysqli_num_rows($res);
	if ($total) {
		$ordem = 1;
		while ($obj = mysqli_fetch_array($res)) {
			
			$sqlu = "UPDATE itens SET ordem = '".$ordem."' WHERE idi = '".$obj['idi']."'";
			mysqli_query($conn, $sqlu);

			$ordem = $ordem + 1;
		
		}
	}
}

?>