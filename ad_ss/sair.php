<?php 
include("conf.php");

$v_saida = $v_url;

unset($_SESSION['id']);
unset($_SESSION['nome']);

header("location: ".$v_saida."");

?>