<?php

include('conf.php'); 

if (isset($_REQUEST['acao'])) {

	$acao = $_REQUEST['acao'];
	
	if ($acao == "slug") {

		$titulo = trim(utf8_decode($_REQUEST["titulo"]));

		$tiulo = tirarAcentos($titulo);
		$slug = slug($titulo);

		echo $slug;

	}

	if ($acao == "contato_envia") {
		
		$nome = utf8_decode($_REQUEST["nome"]);
		$email = utf8_decode($_REQUEST["email"]);
		$empresa = utf8_decode($_REQUEST["empresa"]);
		$tel = utf8_decode($_REQUEST["tel"]);
		$msg = utf8_decode($_REQUEST["msg"]);

	
		$html = $email_cabecalho;
		$html .= '<p align="center">'.$logo_topo.'</p>';
		$html .= "<p>Olá,</p>";
		$html .= "<p>Uma nova mensagem de contato foi enviado através do site:</p>";
		$html .= "<p>Nome: <b>".$nome."</b></p>";
		$html .= "<p>E-mail: <b>".$email."</b></p>";
		$html .= "<p>Empresa: <b>".$empresa."</b></p>";
		$html .= "<p>Telefone: <b>".$tel."</b></p>";
		$html .= "<p>Mensagem: <b>".$msg."</b></p>";
		$html .= $email_rodape;

		$assunto = "Contato do Site";
		

		$email = email("valdileibranco@gmail.com", "Valdilei", $assunto, $html);

		if ($email == 1) {
			echo "Envio realizado!";
		} else {
			echo "Falha no envio: ".$email."";
		}

	}

	if ($acao == "land_item_upload") {

		$echo = "";

		if(isset($_FILES["image"])) {

			$nome_arq = $_FILES["image"]["name"];

			$extensoes_permitidas = array("jpg","png");
			$path_parts = pathinfo($_FILES["image"]["name"]);
			$ext = $path_parts['extension'];

			if(in_array($ext,$extensoes_permitidas)){

				$nome_arq = md5(uniqid(rand(), true)).".".$ext;

				$pasta_upload = $pasta_upload.$nome_arq;
				
				if (move_uploaded_file($_FILES["image"]['tmp_name'], $pasta_upload)) {
					
					$echo = "1|".$nome_arq;

				} else {

					$echo = "0|Falha ao gravar o arquivo";

				}

			} else {
				$echo = "0|Extensão ".$ext." não permitida!";
			}

		} else {
			$echo = "2|";
		}

		echo $echo;


	}

	if ($acao == "upload-arquivo-arq") {

		$echo = "";

		
			$nome_arq = $_FILES["image"]["name"];

			$extensoes_permitidas = array("zip","rar", "pdf", "docx", "mq4", "ex4", "ex5", "mql4", "mql5", "mq5");

			$path_parts = pathinfo($_FILES["image"]["name"]);
			$ext = $path_parts['extension'];

			if(in_array($ext,$extensoes_permitidas)){

				$nome_arq = md5(uniqid(rand(), true)).".".$ext;

				$pasta_upload = $pasta_upload.$nome_arq;
				
				if (move_uploaded_file($_FILES["image"]['tmp_name'], $pasta_upload)) {
					
					$echo = "1|".$nome_arq;

				} else {

					$echo = "0|Falha ao gravar o arquivo";

				}

			} else {
				$echo = "0|Extensão ".$ext." não permitida!";
			}

		

		echo $echo;


	}
	
	if ($acao == "upload-arquivo") {

		$echo = "";

		if(isset($_FILES["image"])) {

			$nome_arq = $_FILES["image"]["name"];

			$path_parts = pathinfo($_FILES["image"]["name"]);
			$ext = $path_parts['extension'];
			
			$pasta_upload = "../arq/";
	
			//$nome_arq = $_FILES["image"]["name"];

			$nome_arq = md5(uniqid(rand(), true)).".".$ext;

			$pasta_upload = $pasta_upload.$nome_arq;
			
			if (move_uploaded_file($_FILES["image"]['tmp_name'], $pasta_upload)) {
				
				$echo = "1|".$nome_arq;

			} else {

				$echo = "0|Falha ao gravar o arquivo";

			}

			
		}
		

		echo $echo;


	}	
	
	if ($acao == "upload-arquivo-d") {

		$echo = "";

		if(isset($_FILES["image"])) {

			$nome_arq = $_FILES["image"]["name"];

			$titulo = utf8_decode($_REQUEST["titulod"]);
			$descr = utf8_decode($_REQUEST["descrd"]);

			$img = utf8_decode($_REQUEST["img"]);

			$extensoes_permitidas = array("jpg","png", "zip", "png", "txt", "pdf");

			$path_parts = pathinfo($_FILES["image"]["name"]);
			$ext = $path_parts['extension'];
			
			$nome_arq_t = $_FILES['image']['name'];
			$nome_arq_t = str_replace(".".$ext, "", $nome_arq_t);
			$nome_arq = slug($nome_arq_t).".".$ext;
			
			$pasta_upload = "../down/";

			if(in_array($ext,$extensoes_permitidas)){

				$pasta_upload = $pasta_upload.$nome_arq;
				
				if (move_uploaded_file($_FILES["image"]['tmp_name'], $pasta_upload)) {
					
					$sql = "INSERT INTO downloads (arq, img, titulo, descr, dt_ins) VALUES ('".$nome_arq."', '".$img."', '".$titulo."', '".$descr."', now())";
					if (mysqli_query($conn, $sql)) {
					
						$echo = "1|".$nome_arq;
					
					} else {
					
						$echo = "0|Falha ao gravar o arquivo no banco de dados ".$sql;
					
					}

				} else {

					$echo = "0|Falha ao gravar o arquivo na pasta";

				}

			} else {
				$echo = "0|Extensão ".$ext." não permitida!";
			}

		} else {
			$echo = "2|";
		}

		echo $echo;


	}

	if ($acao == 'salvar-conteudo-arq') {

		$id = $_REQUEST["id"];
		$titulo = utf8_decode($_REQUEST["titulo"]);
		$tipo = utf8_decode($_REQUEST["tipo"]);
		$img_fundo_s = $_REQUEST["img_fundo_s"];
		$img_fundo1_s = $_REQUEST["img_fundo1_s"];

		if ($id == "novo") {
			$sqli = "INSERT INTO `conteudo_arqs` (titulo) VALUES ('".$titulo."')";
			if (mysqli_query($conn, $sqli)) {
				$id = mysqli_insert_id($conn);
			}
		}
	
		$sqli = "UPDATE `conteudo_arqs` SET titulo = '".$titulo."', tipo = '".$tipo."', img = '".$img_fundo_s."', arq = '".$img_fundo1_s."' WHERE ida = '".$id."'";
		if (mysqli_query($conn, $sqli)) {
			$echo = "1|".$id;
		} else {
			$echo = "0|".mysqli_error($conn);
		}

		echo $echo;

	}


	if ($acao == 'salvar-categoria') {

		$id = $_REQUEST["id"];
		$categoria = utf8_decode($_REQUEST["categoria"]);
		$slug = $_REQUEST["slug"];

		if ($id == "novo") {
			$sqli = "INSERT INTO `blog_cat` (categoria) VALUES ('".$categoria."')";
			if (mysqli_query($conn, $sqli)) {
				$id = mysqli_insert_id($conn);
			}
		}
	
		$sqli = "UPDATE `blog_cat` SET categoria = '".$categoria."', slug = '".$slug."' WHERE idbc = '".$id."'";
		if (mysqli_query($conn, $sqli)) {
			$echo = "1|".$id;
		} else {
			$echo = "0|".mysqli_error($conn);
		}

		echo $echo;

	}

	if ($acao == 'salvar-blog') {

		$id = $_REQUEST["id"];
		$titulo = utf8_decode($_REQUEST["titulo"]);
		$badge = utf8_decode($_REQUEST["badge"]);

		$url_youtube = utf8_decode($_REQUEST["url_youtube"]);
		$url_youtube = str_replace("https://www.youtube.com/watch?v=", "", $url_youtube);
		
		$slug = $_REQUEST["slug"];
		$idbc = $_REQUEST["idbc"];

		$tags = utf8_decode($_REQUEST["tags"]);
		$descr = utf8_decode($_REQUEST["descr"]);
		
		$img_fundo_s = $_REQUEST["img_fundo_s"];

		$dest = "0";
		if (isset($_REQUEST['dest'])) {
			$dest = "1";
		}

		
		$texto = rawurldecode(utf8_decode($_REQUEST["texto_f"]));
		$texto = addslashes($texto);

		if ($id == "novo") {
			$sqli = "INSERT INTO `blog` (titulo) VALUES ('".$titulo."')";
			if (mysqli_query($conn, $sqli)) {
				$id = mysqli_insert_id($conn);
			}
		}
	
		$sqli = "UPDATE `blog` SET titulo = '".$titulo."', dest =  '".$dest."', slug = '".$slug."', idbc = '".$idbc."', texto = '".$texto."', tags = '".$tags."', badge = '".$badge."', url_youtube = '".$url_youtube."', descr = '".$descr."', arq = '".$img_fundo_s."' WHERE idb = '".$id."'";
		if (mysqli_query($conn, $sqli)) {
			$echo = "1|".$id;
		} else {
			$echo = "0|".mysqli_error($conn);
		}

		echo $echo;

	}

	

	if ($acao == 'salvar-pag-seguros') {
		
		$id = "1";

		$titulo = utf8_decode(nl2br($_REQUEST["titulo"]));
		$texto_tit = utf8_decode($_REQUEST["texto_tit"]);
		$texto_descr = utf8_decode(nl2br($_REQUEST["texto_descr"]));
		$texto = utf8_decode(nl2br($_REQUEST["texto"]));

		$pag_tit = utf8_decode($_REQUEST["pag_tit"]);
		$pag_descr = utf8_decode(nl2br($_REQUEST["pag_descr"]));

		$img_fundo = $_REQUEST["img_fundo_s"];
		
		$pag_tit = utf8_decode($_REQUEST["pag_tit"]);
		$pag_descr = utf8_decode($_REQUEST["pag_descr"]);

		$dados_tit = utf8_decode($_REQUEST["dados_tit"]);

		$sqli = "UPDATE pag_seguros SET titulo = '".$titulo."', texto_tit = '".$texto_tit."', texto_descr = '".$texto_descr."', texto = '".$texto."', img_fundo = '".$img_fundo."', dados_tit = '".$dados_tit."', pag_tit = '".$pag_tit."', pag_descr = '".$pag_descr."' WHERE id = '1'";

		$echo = "";

		if (mysqli_query($conn, $sqli)) {
			$echo = "1|".$id;
		} else {
			$echo = "0|".mysqli_error($conn);
		}

		echo $echo;


	}

	if ($acao == 'salvar-pag-conteudo') {

		
		$id = "1";


		$titulo = utf8_decode($_REQUEST["titulo"]);
		$descr = utf8_decode(nl2br($_REQUEST["descr"]));
		
		$img_fundo = $_REQUEST["img_fundo_s"];
		
		$pag_tit = utf8_decode($_REQUEST["pag_tit"]);
		$pag_descr = utf8_decode($_REQUEST["pag_descr"]);

		
		$sqli = "UPDATE conteudo SET titulo = '".$titulo."', descr = '".$descr."', img_fundo = '".$img_fundo."', pag_tit = '".$pag_tit."', pag_descr = '".$pag_descr."' WHERE id = '1'";

		$echo = "";

		if (mysqli_query($conn, $sqli)) {
			$echo = "1|".$id;
		} else {
			$echo = "0|".mysqli_error($conn);
		}

		echo $echo;


	}

	if ($acao == 'salvar-pag-videos') {

		
		$id = "1";

		$titulo = utf8_decode(nl2br($_REQUEST["titulo"]));
		
		$img_fundo = $_REQUEST["img_fundo_s"];
		
		$pag_tit = utf8_decode($_REQUEST["pag_tit"]);
		$pag_descr = utf8_decode($_REQUEST["pag_descr"]);

		
		$sqli = "UPDATE videos SET titulo = '".$titulo."', img_fundo = '".$img_fundo."', pag_tit = '".$pag_tit."', pag_descr = '".$pag_descr."' WHERE id = '1'";

		$echo = "";

		if (mysqli_query($conn, $sqli)) {
			$echo = "1|".$id;
		} else {
			$echo = "0|".mysqli_error($conn);
		}

		echo $echo;


	}

	if ($acao == 'salvar-pag') {
		
		$id = "1";

		$titulo = utf8_decode(nl2br($_REQUEST["titulo"]));
		$texto_tit = utf8_decode($_REQUEST["texto_tit"]);
		$texto_descr = utf8_decode(nl2br($_REQUEST["texto_descr"]));
		$texto = utf8_decode(nl2br($_REQUEST["texto"]));

		$pag_tit = utf8_decode($_REQUEST["pag_tit"]);
		$pag_descr = utf8_decode(nl2br($_REQUEST["pag_descr"]));

		$img_fundo = $_REQUEST["img_fundo_s"];
		$img_fundo2 = $_REQUEST["img_fundo2_s"];
		$img_fundo3 = $_REQUEST["img_fundo3_s"];
		$img_fundo4 = $_REQUEST["img_fundo4_s"];
		$img_fundo5 = $_REQUEST["img_fundo5_s"];
		$img_fundo6 = $_REQUEST["img_fundo6_s"];

		$dados_tit = utf8_decode($_REQUEST["dados_tit"]);
		$dados_tit_sec = utf8_decode($_REQUEST["dados_tit_sec"]);
		
		$contratacao_tit = utf8_decode($_REQUEST["contratacao_tit"]);
		$contratacao_link = utf8_decode($_REQUEST["contratacao_link"]);

		$consultoria_tit = utf8_decode($_REQUEST["consultoria_tit"]);
		$consultoria_descr = utf8_decode(nl2br($_REQUEST["consultoria_descr"]));
		$consultoria_link = $_REQUEST["consultoria_link"];

		$seguradoras_tit = utf8_decode($_REQUEST["seguradoras_tit"]);
		$solucoes_tit = utf8_decode($_REQUEST["solucoes_tit"]);
		$video_tit = utf8_decode($_REQUEST["video_tit"]);
		$video_descr = utf8_decode(nl2br($_REQUEST["video_descr"]));
		
		$video_embed = $_REQUEST["video_embed"];

		$sqli = "UPDATE pag_princ SET titulo = '".$titulo."', texto_tit = '".$texto_tit."', texto_descr = '".$texto_descr."', texto = '".$texto."', img_fundo = '".$img_fundo."', img_fundo2 = '".$img_fundo2."', img_fundo3 = '".$img_fundo3."', img_fundo4 = '".$img_fundo4."', img_fundo5 = '".$img_fundo5."', img_fundo6 = '".$img_fundo6."', dados_tit = '".$dados_tit."', dados_tit_sec = '".$dados_tit_sec."', contratacao_tit = '".$contratacao_tit."', contratacao_link = '".$contratacao_link."',  consultoria_tit = '".$consultoria_tit."', consultoria_descr = '".$consultoria_descr."', consultoria_link = '".$consultoria_link."', seguradoras_tit = '".$seguradoras_tit."', solucoes_tit = '".$solucoes_tit."', video_tit = '".$video_tit."', video_descr = '".$video_descr."', video_embed = '".$video_embed."', pag_tit = '".$pag_tit."', pag_descr = '".$pag_descr."' WHERE id = '1'";

		$echo = "";

		if (mysqli_query($conn, $sqli)) {
			$echo = "1|".$id;
		} else {
			$echo = "0|".mysqli_error($conn);
		}

		echo $echo;


	}

	if ($acao == 'salvar-landing') {

		$id = $_REQUEST["id"];
		$titulo = utf8_decode($_REQUEST["titulo"]);
		$slug = $_REQUEST["slug"];

		$titulo_descr = utf8_decode($_REQUEST["titulo_descr"]);
		$img_fundo = $_REQUEST["img_fundo_s"];
		$img_fundo2 = $_REQUEST["img_fundo_s2"];
		$tags = utf8_decode($_REQUEST["tags"]);

		$video_url = utf8_decode($_REQUEST["video_url"]);
		$video_titulo = utf8_decode($_REQUEST["video_titulo"]);
		$video_subtitulo = utf8_decode($_REQUEST["video_subtitulo"]);
		$video_descr = utf8_decode($_REQUEST["video_descr"]);
		$seguro_quem_precisa_tit = utf8_decode($_REQUEST["seguro_quem_precisa_tit"]);
		$seguro_quem_precisa_descr = utf8_decode(nl2br($_REQUEST["seguro_quem_precisa_descr"]));
		$seguro_contratar_tit = utf8_decode($_REQUEST["seguro_contratar_tit"]);
		$seguro_porque_tit = utf8_decode($_REQUEST["seguro_porque_tit"]);
		$seguro_porque_descr = utf8_decode($_REQUEST["seguro_porque_descr"]);
		$seguro_porque_link = utf8_decode($_REQUEST["seguro_porque_link"]);

		$seguro_quem_pode_tit = utf8_decode($_REQUEST["seguro_quem_pode_tit"]);
		$seguro_quem_pode_descr = utf8_decode($_REQUEST["seguro_quem_pode_descr"]);

		$lat_tit_1 = utf8_decode($_REQUEST["lat_tit_1"]);
		$lat_descr_1 = utf8_decode($_REQUEST["lat_descr_1"]);
		$lat_tit_2 = utf8_decode($_REQUEST["lat_tit_2"]);
		$lat_descr_2 = utf8_decode($_REQUEST["lat_descr_2"]);
		$lat_tit_3 = utf8_decode($_REQUEST["lat_tit_3"]);
		$lat_descr_3 = utf8_decode($_REQUEST["lat_descr_3"]);
		$lat_tit_4 = utf8_decode($_REQUEST["lat_tit_4"]);
		$lat_descr_4 = utf8_decode($_REQUEST["lat_descr_4"]);
		$seguro_como_contratar_tit = utf8_decode($_REQUEST["seguro_como_contratar_tit"]);
		$seguro_contratar_item_tit_1 = utf8_decode($_REQUEST["seguro_contratar_item_tit_1"]);
		$seguro_contratar_item_descr_1 = utf8_decode($_REQUEST["seguro_contratar_item_descr_1"]);
		$seguro_contratar_item_tit_2 = utf8_decode($_REQUEST["seguro_contratar_item_tit_2"]);
		$seguro_contratar_item_descr_2 = utf8_decode($_REQUEST["seguro_contratar_item_descr_2"]);
		$seguro_contratar_item_tit_3 = utf8_decode($_REQUEST["seguro_contratar_item_tit_3"]);
		$seguro_contratar_item_descr_3 = utf8_decode($_REQUEST["seguro_contratar_item_descr_3"]);
		$seguro_contratar_item_tit_4 = utf8_decode($_REQUEST["seguro_contratar_item_tit_4"]);
		$seguro_contratar_item_descr_4 = utf8_decode($_REQUEST["seguro_contratar_item_descr_4"]);
		$seguro_princ_coberturas = utf8_decode($_REQUEST["seguro_princ_coberturas"]);

		$fale_consultores_tit = utf8_decode(nl2br($_REQUEST["fale_consultores_tit"]));
		$fale_consultores_texto = utf8_decode(nl2br($_REQUEST["fale_consultores_texto"]));
		$fale_consultores_contato = utf8_decode(nl2br($_REQUEST["fale_consultores_contato"]));
		$fale_consultores_link = utf8_decode($_REQUEST["fale_consultores_link"]);

		$logo_seguradoras = utf8_decode($_REQUEST["logo_seguradoras"]);

	
		if ($id == "novo") {
			$sqli = "INSERT INTO `landing` (titulo) VALUES ('".$titulo."')";
			if (mysqli_query($conn, $sqli)) {
				$id = mysqli_insert_id($conn);
			}
		}
	
		$sqli = "UPDATE `landing` SET titulo = '".$titulo."', slug = '".$slug."', titulo_descr = '".$titulo_descr."', img_fundo = '".$img_fundo."', img_fundo2 = '".$img_fundo2."', tags = '".$tags."', video_url = '".$video_url."', video_titulo = '".$video_titulo."', video_subtitulo = '".$video_subtitulo."', video_descr = '".$video_descr."', seguro_quem_precisa_tit = '".$seguro_quem_precisa_tit."', seguro_quem_precisa_descr = '".$seguro_quem_precisa_descr."', seguro_contratar_tit = '".$seguro_contratar_tit."', seguro_porque_tit = '".$seguro_porque_tit."', seguro_porque_descr = '".$seguro_porque_descr."', lat_tit_1 = '".$lat_tit_1."', lat_descr_1 = '".$lat_descr_1."', lat_tit_2 = '".$lat_tit_2."', lat_descr_2 = '".$lat_descr_2."', lat_tit_3 = '".$lat_tit_3."', lat_descr_3 = '".$lat_descr_3."', lat_tit_4 = '".$lat_tit_4."', lat_descr_4 = '".$lat_descr_4."', seguro_como_contratar_tit = '".$seguro_como_contratar_tit."', seguro_contratar_item_tit_1 = '".$seguro_contratar_item_tit_1."', seguro_contratar_item_descr_1 = '".$seguro_contratar_item_descr_1."', seguro_contratar_item_tit_2 = '".$seguro_contratar_item_tit_2."', seguro_contratar_item_descr_2 = '".$seguro_contratar_item_descr_2."', seguro_contratar_item_tit_3 = '".$seguro_contratar_item_tit_3."', seguro_contratar_item_descr_3 = '".$seguro_contratar_item_descr_3."', seguro_contratar_item_tit_4 = '".$seguro_contratar_item_tit_4."', seguro_contratar_item_descr_4 = '".$seguro_contratar_item_descr_4."', seguro_quem_pode_tit = '".$seguro_quem_pode_tit."', seguro_quem_pode_descr = '".$seguro_quem_pode_descr."', seguro_princ_coberturas = '".$seguro_princ_coberturas."', fale_consultores_tit = '".$fale_consultores_tit."', fale_consultores_texto = '".$fale_consultores_texto."', fale_consultores_link = '".$fale_consultores_link."', fale_consultores_contato = '".$fale_consultores_contato."', seguro_porque_link = '".$seguro_porque_link."', logo_seguradoras = '".$logo_seguradoras."' WHERE idlp = '".$id."'";

		#echo $sqli;

		if (mysqli_query($conn, $sqli)) {
			$echo = "1|".$id;
		} else {
			$echo = "0|".mysqli_error($conn);
		}

		echo $echo;

	}

	if ($acao == 'salvar-global') {

		$echo = "";

		$endereco = rawurldecode(utf8_decode($_REQUEST["endereco_f"]));
		$endereco = addslashes($endereco);
		
		$contato = rawurldecode(utf8_decode($_REQUEST["contato_f"]));
		$contato = addslashes($contato);

		$contato_contato = rawurldecode(utf8_decode($_REQUEST["contato_contato_f"]));
		$contato_contato = addslashes($contato_contato);

		$img_fundo_s_blog = $_REQUEST["img_fundo_s_blog"];

		$img_fundo_s_downloads = $_REQUEST["img_fundo_s_downloads"];
		

		$img_fundo_l_contato = $_REQUEST["img_fundo_l_contato"];


		$img_slide_inicial = $_REQUEST["img_slide_inicial"];

		$sqli = "UPDATE `global` SET endereco = '".$endereco."', contato = '".$contato."', contato_contato = '".$contato_contato."', img_fundo_s_blog = '".$img_fundo_s_blog."', img_fundo_s_downloads = '".$img_fundo_s_downloads."', img_fundo_l_contato = '".$img_fundo_l_contato."', img_slide_inicial = '".$img_slide_inicial."' WHERE idg = '1'";
		if (mysqli_query($conn, $sqli)) {
			$echo = "1|";
		} else {
			$echo = "0|".mysqli_error($conn)." - ".$img_fundo_s_blog." - ".$sqli;
		}

		echo $echo;

	}

	if ($acao == 'land_item_del') {

		$echo = "";

		$id = $_REQUEST["id"];

		$sql = "SELECT * FROM landing_itens WHERE idli = '".$id."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			
			$img = "";
			
			if ($obj['adc'] <> "") {				
				if (file_exists($caminho_server.$obj['adc'])) {
					$img = $obj['adc'];
				}
			}

			if ($img <> "") {
				if (unlink($caminho_server.$img)) {
					$sqli = "DELETE FROM landing_itens WHERE idli = '".$id."'";
					if (mysqli_query($conn, $sqli)) {
						$echo = "1|";
					} else {
						$echo = "0|".mysqli_error($conn);
					}
				} else {
					$echo = "0|Não foi possível deletar o arquivo ".$obj['img'];
				}
			} else {
				$sqli = "DELETE FROM landing_itens WHERE idli = '".$id."'";
				if (mysqli_query($conn, $sqli)) {
					
					//reordena_itens($ida);
						
					$echo = "1|";

				} else {
					$echo = "0|".mysqli_error($conn);
				}
			}

			
		}

		echo $echo;

	}

	if ($acao == 'tabs-del') {

		$echo = "";

		$id = $_REQUEST["id"];

		$sql = "SELECT * FROM itens WHERE idi = '".$id."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			
			$img = "";
			$ida = $obj['ida'];
			
			if ($obj['img'] <> "") {				
				if (file_exists($caminho_server.$obj['img'])) {
					$img = $obj['img'];
				}
			}

			if ($img <> "") {
				if (unlink($caminho_server.$img)) {
					$sqli = "DELETE FROM itens WHERE idi = '".$id."'";
					if (mysqli_query($conn, $sqli)) {
						$echo = "1|";
					} else {
						$echo = "0|".mysqli_error($conn);
					}
				} else {
					$echo = "0|Não foi possível deletar o arquivo ".$obj['img'];
				}
			} else {
				$sqli = "DELETE FROM itens WHERE idi = '".$id."'";
				if (mysqli_query($conn, $sqli)) {
					
					reordena_itens($ida);
						
					$echo = "1|";
				} else {
					$echo = "0|".mysqli_error($conn);
				}
			}

			
		}

		echo $echo;

	}

	if ($acao == 'tabs-ordem') {

		$ida = $_REQUEST['ida'];
		$t = $_REQUEST['t'];
		$idi = $_REQUEST['idi'];
		$dir = $_REQUEST['dir'];


		# descobrir ordem atual
		$sql = "SELECT ordem FROM itens WHERE idi = '".$idi."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			$ordem_atual = $obj['ordem'];
		}

		if ($dir == 's') {

			$sqlu = "UPDATE itens SET ordem = '".($ordem_atual+1)."' WHERE ordem = '".($ordem_atual-1)."' AND ida = '".$ida."'";
			mysqli_query($conn, $sqlu);

			$sqlu = "UPDATE itens SET ordem = '".($ordem_atual-1)."' WHERE idi = '".$idi."'";
			mysqli_query($conn, $sqlu);

		}

		if ($dir == 'd') {

			$sqlu = "UPDATE itens SET ordem = '".($ordem_atual-1)."' WHERE ordem = '".($ordem_atual+1)."' AND ida = '".$ida."'";
			mysqli_query($conn, $sqlu);

			$sqlu = "UPDATE itens SET ordem = '".($ordem_atual+1)."' WHERE idi = '".$idi."'";
			mysqli_query($conn, $sqlu);

		}

		reordena_itens($ida);


	}

	if ($acao == 'land_item_salvar') {

		$echo = "";

		$idlp = $_REQUEST["idlp"]; 
		$idi = $_REQUEST["idi"];
		$tit = utf8_decode($_REQUEST["tit"]);
		$descr = utf8_decode(nl2br($_REQUEST["descr"]));
		$extra = utf8_decode($_REQUEST["extra"]);
		$tipo = $_REQUEST["t"];

		if ($idi == "0") {
			$sqli = "INSERT INTO landing_itens (idlp, tipo) VALUES ('".$idlp."', '".$tipo."')";
			if (mysqli_query($conn, $sqli)) {
				$idi = mysqli_insert_id($conn);
			}
		}

		$sqlu = "UPDATE landing_itens SET tit = '".$tit."', descr = '".$descr."' WHERE idli = '".$idi."'";
		if (mysqli_query($conn, $sqlu)) {
			
			$id = mysqli_insert_id($conn);

			if (isset($_REQUEST["extra"])) {
				$sqli = "UPDATE landing_itens SET extra = '".$extra."' WHERE idli = '".$idi."'";
				mysqli_query($conn, $sqli);
			}

			if (isset($_REQUEST["adc"])) {
				$sqli = "UPDATE landing_itens SET adc = '".$_REQUEST["adc"]."' WHERE idli = '".$idi."'";
				if (mysqli_query($conn, $sqli)) {
					$echo = "1|";
				} else {
					$echo = "0|".mysqli_error($conn);
				}
			} else {
				$echo = "1|";
			}

		} else {
			$echo = "0|".mysqli_error($conn);
		}
		
		echo $echo;

	}

	if ($acao == 'tabs-salvar-modal') {

		$echo = "";

		$idi = $_REQUEST["idi-atualizar"];
		$nome = utf8_decode($_REQUEST["nome-edt"]);
		$vlr = utf8_decode($_REQUEST["vlr-edt"]);
		$ida = $_REQUEST["id"];


		$sqlu = "UPDATE itens SET nome = '".$nome."', vlr = '".$vlr."' WHERE idi = '".$idi."'";
		if (mysqli_query($conn, $sqlu)) {
			
			$id = mysqli_insert_id($conn);

			if (isset($_REQUEST["img-n-edt"])) {
				$sqli = "UPDATE itens SET img = '".$_REQUEST["img-n-edt"]."' WHERE idi = '".$idi."'";
				if (mysqli_query($conn, $sqli)) {
					$echo = "1|";
				} else {
					$echo = "0|".mysqli_error($conn);
				}
			} else {
				$echo = "1|";
			}

		} else {
			$echo = "0|".mysqli_error($conn);
		}
		
		reordena_itens($ida);

		echo $echo;

	}

	if ($acao == 'tabs-salvar') {

		$echo = "";

		$tipo = $_REQUEST["t"];
		$nome = utf8_decode($_REQUEST["nome-".$tipo]);
		$vlr = utf8_decode($_REQUEST["vlr-".$tipo]);
		$ida = $_REQUEST["id"];

		// obtem ordem maxima
		$ordem = 0;
		$sql = "SELECT max(ordem) as ordem FROM itens WHERE ida = '".$ida."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			$ordem = $obj['ordem'];
		}

		$ordem = $ordem + 1;

		$sqli = "INSERT INTO itens (tipo, nome, vlr, ida, ordem) VALUES ('".$tipo."', '".$nome."', '".$vlr."', '".$ida."', '".$ordem."')";
		if (mysqli_query($conn, $sqli)) {
			
			$id = mysqli_insert_id($conn);

			if (isset($_REQUEST["img-n-".$tipo])) {
				$sqli = "UPDATE itens SET img = '".$_REQUEST["img-n-".$tipo]."' WHERE idi = '".$id."'";
				if (mysqli_query($conn, $sqli)) {
					$echo = "1|";
				} else {
					$echo = "0|".mysqli_error($conn);
				}
			} else {
				$echo = "1|";
			}

		} else {
			$echo = "0|".mysqli_error($conn);
		}
		
		reordena_itens($ida);

		echo $echo;

	}

	if ($acao == 'menu-exc') {

		$idi = $_REQUEST["idi"];
		
		# descobrir ida
		$sql = "SELECT ida FROM itens WHERE idi = '".$idi."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			$ida = $obj['ida'];
		}

		$sqld = "DELETE FROM itens WHERE idi = '".$idi."'";
		if (mysqli_query($conn, $sqld)) {

			# deleta filhos, se possuir
			$sqld = "DELETE FROM itens WHERE ida = '".$idi."'";
			mysqli_query($conn, $sqld);
	
			$echo = "1|";
		} else {
			$echo = "0|".mysqli_error($conn);
		}

		reordena_itens($ida);

		echo $echo;


	}

	if ($acao == 'menu-salvar') {

		$echo = "";

		$ida = $_REQUEST["ida"];
		$tipo = $_REQUEST["tipo"];
		$nome = utf8_decode($_REQUEST["nome"]);
		$vlr = utf8_decode($_REQUEST["vlr"]);

		// obtem ordem maxima
		$ordem = 0;
		$sql = "SELECT max(ordem) as ordem FROM itens WHERE ida = '".$ida."'";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
			$ordem = $obj['ordem'];
		}

		$ordem = $ordem + 1;
		
		$sqli = "INSERT INTO itens (tipo, ida, nome, vlr, ordem) VALUES ('".$tipo."', '".$ida."', '".$nome."', '".$vlr."', '".$ordem."')";
		if (mysqli_query($conn, $sqli)) {
			$echo = "1|";
		} else {
			$echo = "0|".mysqli_error($conn);
		}
			
		reordena_itens($ida);

		echo $echo;

	}

	if ($acao == 'menu-ler') {

		$echo = "";

		$ida = $_REQUEST["ida"];

		$sql = "SELECT * FROM itens WHERE ida = '".$ida."' ORDER BY ordem ASC;";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$i = 1;
			while ($obj = mysqli_fetch_array($res)) {
								
				$echo .= "<p>";
				
				$tipo = "ITEM";
				if ($obj["tipo"] == "6") {
					$tipo = "SUBMENU";
				}

				$echo .= $tipo.": ";
				
				$echo .= "<b>".strtoupper($obj["nome"])."</b> - <i>".$obj["vlr"]."</i> ";

				$echo .= "<input type='button' class='btn btn-default' onclick=\"javascript:tabs_edt('".$obj["tipo"]."','".$obj['idi']."')\" value='Editar'></input> ";

				if ($i > 1) {
					$echo .= "<input type='button' class='btn btn-success' onclick=\"javascript:menu_ordem('".$obj["tipo"]."','".$obj['idi']."', 's', '".$obj['ida']."')\" value='Subir'></input> ";
				}

				if ($i < $total) {
					$echo .= "<input type='button' class='btn btn-info' onclick=\"javascript:menu_ordem('".$obj["tipo"]."','".$obj['idi']."', 'd', '".$obj['ida']."')\" value='Descer'></input> ";
				}

				if ($obj["tipo"] == "6") {
					$echo .= "<input type='button' class='btn btn-warning' onclick=\"javascript:menu_adc_item('".$obj["idi"]."')\" value='+'></input> ";
				}

				$echo .= "<input type='button' class='btn btn-danger' onclick=\"javascript:menu_exc_item('".$obj["idi"]."')\" value='X'></input> ";

				$echo .= "</p>";

				if ($obj["tipo"] == "6") {

					$sqld = "SELECT * FROM itens WHERE ida = '".$obj["idi"]."' ORDER BY ordem ASC;";
					$resd = mysqli_query($conn, $sqld);
					$totald = @mysqli_num_rows($resd);
					if ($totald) {
						$z = 1;
						while ($objd = mysqli_fetch_array($resd)) {
							$echo .= "<p> -- ".strtoupper($objd["nome"])." - <i>".$obj["vlr"]."</i> ";

							$echo .= "<input type='button' class='btn btn-default' onclick=\"javascript:tabs_edt('".$objd["tipo"]."','".$objd['idi']."')\" value='Editar'></input> ";

							if ($z > 1) {
								$echo .= "<input type='button' class='btn btn-success' onclick=\"javascript:menu_ordem('".$objd["tipo"]."','".$objd['idi']."', 's', '".$objd['ida']."')\" value='Subir'></input> ";
							}

							if ($z < $totald) {
								$echo .= "<input type='button' class='btn btn-info' onclick=\"javascript:menu_ordem('".$objd["tipo"]."','".$objd['idi']."', 'd', '".$objd['ida']."')\" value='Descer'></input> ";
							}
										
							$echo .= "<input type='button' class='btn btn-danger' onclick=\"javascript:menu_exc_item('".$objd["idi"]."')\" value='X'></input> ";
							
							$echo .= "</p>";

							$z = $z + 1;

						}
					}

				}

				$i = $i + 1;

			}
		}

		echo $echo;

	}

	if ($acao == 'tabs-edt') {

		$html = '';
		
		$tipo = $_REQUEST['t'];
		$idi = $_REQUEST['id'];

		$sql = "SELECT * FROM itens WHERE idi = '".$idi."';";
		$res = mysqli_query($conn, $sql);
		$total = @mysqli_num_rows($res);
		if ($total) {
			$obj = mysqli_fetch_array($res);
				
			

			$html .= "
				<form id='form-dados-atualizar' action='#' method='POST' role='form' enctype='multipart/form-data'>
				<div class='row'>";
			
			if ($obj["tipo"] == "3" || $obj["tipo"] == "10") {
		

				$html .= "
				
						<div class='col-md-12'>
							<label>Imagem:</label>";

				if ($obj['img'] <> "") {

					$html .= "<p><img src='".$v_url."/upl/".$obj['img']."' width='100'></p>";
				}


				$html .= "<input type='file' name='img-edt' id='img-edt' value='' class='form-control'>
					</div>";

			}

			$html .= "

					<div class='col-md-12'>
						<label>Nome:</label>
						<input type='text' name='nome-edt' id='nome-edt' value='".$obj["nome"]."' class='form-control'>
					</div>

					<div class='col-md-12'>
						<label>URL:</label>
						<input type='text' name='vlr-edt' id='vlr-edt' value='".$obj["vlr"]."' class='form-control'>
					</div>
				
				</div>

				<div class='row'>
					<div class='col-md-12' style='margin-top: 10px; margin-bottom: 20px;'>
						<input type='button' class='btn btn-info' value='Salvar' id='salvar' onclick='javascript:tabs_salvar_modal(".$idi.", ".$obj["tipo"].");'>
					</div>
				</div>
				<input type='hidden' name='idi-atualizar' id='idi' value='".$obj["idi"]."'>
				<input type='hidden' name='ida' id='ida' value='".$obj["ida"]."'>
				</form>
				";
				

		}

		echo $html;

	}

	if ($acao == 'land_item_adm') {

		$html = '';
		
		$tipo = $_REQUEST['t'];

		$idli = "";
		$tit = "";
		$descr = "";
		$adc = "";
		$extra = "";

		if (isset($_REQUEST['id'])) {
			$idli  = $_REQUEST['id'];
		}

		if ($idli <> "0") {
			$sql = "SELECT * FROM landing_itens WHERE idli = '".$idli ."';";
			$res = mysqli_query($conn, $sql);
			$total = @mysqli_num_rows($res);
			if ($total) {
				$obj = mysqli_fetch_array($res);
				$tit = $obj['tit'];
				$descr = str_replace("<br />", "", $obj['descr']);
				$extra = $obj['extra'];
				$adc = $obj['adc'];
			}
		}				

		$html .= "
		<form id='form-dados-atualizar' action='#' method='POST' role='form' enctype='multipart/form-data'>
		<div class='row'>";


		if ($tipo == "1") {
				
			$html .= "
			<div class='col-md-12'>
			<label>Quem pode contratar:</label>
				<input type='text' name='tit' id='tit' value='".$obj["tit"]."' class='form-control'>
			</div>";

		}

		if ($tipo == "5" || $tipo == "10") {
				
			$html .= "
			<div class='col-md-12'>
			<label>Item:</label>
				<input type='text' name='tit' id='tit' value='".$obj["tit"]."' class='form-control'>
			</div>";

		}

		if ($tipo == "6") {
				
			$html .= "
			<div class='col-md-12'>
			<label>Pergunta:</label>
				<input type='text' name='tit' id='tit' value='".$obj["tit"]."' class='form-control'>
			</div>";
			$html .= "
			<div class='col-md-12'>
			<label>Resposta:</label>
				<input type='text' name='descr' id='descr' value='".$descr."' class='form-control'>
			</div>";

		}

		if ($tipo == "7") {
				
			$html .= "
			<div class='col-md-12'>
			<label>Título:</label>
				<input type='text' name='tit' id='tit' value='".$obj["tit"]."' class='form-control'>
			</div>";
			$html .= "
			<div class='col-md-12'>
			<label>Descrição:</label>
				<textarea name='descr' id='descr' rows='5' cols='' class='form-control'>".$descr."</textarea>
			</div>";
			$html .= "
			<div class='col-md-12'>
			<label>Link:</label>
				<input type='text' name='extra' id='extra' value='".$obj["extra"]."' class='form-control'>
			</div>";
			

		}

		if ($tipo == "9") {
				
			$html .= "
			<div class='col-md-12'>
			<label>Título:</label>
				<input type='text' name='tit' id='tit' value='".$obj["tit"]."' class='form-control'>
			</div>";
			$html .= "
			<div class='col-md-12'>
			<label>Link:</label>
				<input type='text' name='extra' id='extra' value='".$obj["extra"]."' class='form-control'>
			</div>";
			

		}

		if ($tipo == "13") {
				
			$html .= "
			<div class='col-md-12'>
			<label>Título:</label>
				<input type='text' name='tit' id='tit' value='".$obj["tit"]."' class='form-control'>
			</div>";
			$html .= "
			<div class='col-md-12'>
			<label>Data:</label>
				<input type='text' name='descr' id='descr' value='".$obj["descr"]."' class='form-control'>
			</div>";
			$html .= "
			<div class='col-md-12'>
			<label>URL:</label>
				<input type='text' name='extra' id='extra' value='".$obj["extra"]."' class='form-control'>
			</div>";
			

		}

		if ($tipo == "11" || $tipo == "12") {
						
			$html .= "
			<div class='col-md-12'>
			<label>Imagem:</label>";

			if ($adc <> "") {
				$html .= "<p><img src='".$v_url."/upl/".$adc."' width='100'></p>";
			}

			$html .= "<input type='file' name='adc' id='adc' value='' class='form-control'>";

			$html .= "
			</div>";
			
			$html .= "
			<div class='col-md-12'>
			<label>Título:</label>
				<input type='text' name='tit' id='tit' value='".$obj["tit"]."' class='form-control'>
			</div>";
			
			$html .= "
			<div class='col-md-12'>
			<label>Descrição:</label>
				<textarea name='descr' id='descr' rows='5' cols='' class='form-control'>".$descr."</textarea>
			</div>";

			$html .= "
			<div class='col-md-12'>
			<label>Link:</label>
				<input type='text' name='extra' id='extra' value='".$obj["extra"]."' class='form-control'>
			</div>";
			

		}

		if ($tipo == "2") {

			$html .= "
			<div class='col-md-12'>
			<label>Imagem:</label>";

			if ($adc <> "") {
				$html .= "<p><img src='".$v_url."/upl/".$adc."' width='100'></p>";
			}

			$html .= "<input type='file' name='adc' id='adc' value='' class='form-control'>";

			$html .= "
			</div>";

			$html .= "
			<div class='col-md-12'>
			<label>Título:</label>
				<input type='text' name='tit' id='tit' value='".$tit."' class='form-control'>
			</div>";

			$html .= "
			<div class='col-md-12'>
			<label>Descrição:</label>
				<textarea name='descr' id='descr' rows='5' cols='' class='form-control'>".$descr."</textarea>
			</div>";

			$html .= "
			<div class='col-md-12'>
			<label>Link:</label>
				<input type='text' name='extra' id='extra' value='".$obj["extra"]."' class='form-control'>
			</div>";

		}

		if ($tipo == "3") {

			$html .= "
			<div class='col-md-12'>
			<label>Imagem:</label>";

			if ($adc <> "") {
				$html .= "<p><img src='".$v_url."/upl/".$adc."' width='100'></p>";
			}

			$html .= "<input type='file' name='adc' id='adc' value='' class='form-control'>";

			$html .= "
			</div>";

			$html .= "
			<div class='col-md-12'>
			<label>Título:</label>
				<input type='text' name='tit' id='tit' value='".$tit."' class='form-control'>
			</div>";

			$html .= "
			<div class='col-md-12'>
			<label>Descrição:</label>
				<input type='text' name='descr' id='descr' value='".$descr."' class='form-control'>
			</div>";

		}

		if ($tipo == "8") {

			$html .= "
			<div class='col-md-12'>
			<label>Imagem:</label>";

			if ($adc <> "") {
				$html .= "<p><img src='".$v_url."/upl/".$adc."' width='100'></p>";
			}

			$html .= "<input type='file' name='adc' id='adc' value='' class='form-control'>";

			$html .= "
			</div>";

			$html .= "
			<div class='col-md-12'>
			<label>Título:</label>
				<input type='text' name='tit' id='tit' value='".$tit."' class='form-control'>
			</div>";


		}


		if ($tipo == "4") {

			$html .= "
			<div class='col-md-12'>
			<label>Logotipo:</label>";

			if ($adc <> "") {
				$html .= "<p><img src='".$v_url."/upl/".$adc."' width='100'></p>";
			}

			$html .= "<input type='file' name='adc' id='adc' value='' class='form-control'>";

			$html .= "
			</div>";

		}
	
	
		$html .= "
		
		</div>

		<div class='row'>
			<div class='col-md-12' style='margin-top: 10px; margin-bottom: 20px;'>
				<input type='button' class='btn btn-info' value='Salvar' id='salvar' onclick='javascript:land_item_salvar(".$idli.", ".$tipo.");'>
			</div>
		</div>
		</form>
		";
			

		echo $html;

	}

	if ($acao == 'tabs-ler') {

		$html = '';
		
		$tipo = $_REQUEST['t'];
		$ida = $_REQUEST['ida'];

		$html .= '<table class="table table-hover"><thead><tr>';

		switch ($tipo) {
			case "1":
				$html .= "<th width='40%'>Rede Social</th><th width='30%'>URL</th>";
				break;
			case "2":
				$html .= "<th width='40%'>Link</th><th width='30%'>URL</th>";
				break;
			case "3":
				$html .= "<th width='10%'>Imagem</th><th width='30%'>Nome</th><th width='20%'>URL</th>";
				break;
			case "7":
				$html .= "<th width='10%'>Imagem</th><th width='30%'>Nome</th><th width='20%'>URL</th>";
				break;
			case "8":
				$html .= "<th width='10%'>Imagem</th><th width='30%'>Nome</th><th width='20%'>URL</th>";
				break;
			case "9":
				$html .= "<th width='10%'>Imagem</th><th width='30%'>Nome</th><th width='20%'>URL</th>";
				break;
			case "10":
				$html .= "<th width='10%'>Imagem</th><th width='30%'>Nome</th><th width='20%'>URL</th>";
				break;
		}

		$html .= "<th width='40%'>Ação</th></tr></thead><tbody>";
		
		if ($ida <> "" && $ida <> 'novo') {
			$sql = "SELECT * FROM itens WHERE tipo = '".$tipo."' AND ida = '".$ida."' ORDER BY ordem ASC;";
			$res = mysqli_query($conn, $sql);
			$total = @mysqli_num_rows($res);
			if ($total) {
				$i = 1;
				while ($obj = mysqli_fetch_array($res)) {

					if ($tipo == "3" || $tipo == "7" || $tipo == "8" || $tipo == "9" || $tipo == "10") {

						$html .= "<tr><td><img src='".$v_url."/upl/".$obj['img']."' width='120'></td><td>".$obj['nome']."</td><td>".$obj['vlr']."</td>";

					} else {
					
						$html .= "<tr><td align='center' valign='center'>".$obj['nome']."</td><td align='center' valign='center'>".$obj['vlr']."</td>";
					
					}

					$html .= "<td>";

					$html .= "<input type='button' class='btn btn-info' onclick=\"javascript:tabs_edt('".$tipo."','".$obj['idi']."')\" value='Editar'></input> ";
					
					$html .= "<input type='button' class='btn btn-danger' onclick=\"javascript:tabs_del('".$tipo."','".$obj['idi']."')\" value='X'></input> ";

					if ($i > 1) {
						$html .= "<input type='button' class='btn btn-success' onclick=\"javascript:tabs_ordem('".$tipo."','".$obj['idi']."', 's')\" value='Subir'></input> ";
					}
					
					if ($i < $total) {
						$html .= "<input type='button' class='btn btn-alert' onclick=\"javascript:tabs_ordem('".$tipo."','".$obj['idi']."', 'd')\" value='Descer'></input> ";
					}
					
					$html .= "</td></tr>";

					$i = $i + 1;

					
				}
			} else {
				
				$html .= "<tr><td colspan='3'>Nenhum item informado até o momento</td></tr>";
			}
		} else {
			$html .= "<tr><td colspan='3'>Nenhum item informado até o momento</td></tr>";
		}

		$html .= "</table>";


		echo $html;
	
	}


	if ($acao == 'itens-listar') {

		$html = '';
		
		$tipo = $_REQUEST['t'];
		$idlp = $_REQUEST['idlp'];

		$html .= '<p><input type="button" value="+" onclick="javascript:land_item_adc(\''.$tipo.'\');"></p>';
		$html .= '<table class="table table-hover"><thead><tr>';

		switch ($tipo) {
			case "1":
				$html .= "<th width='60%'>Quem Pode Contratar?</th>";
				break;
			case "2":
				$html .= "<th width='20%'>Imagem</th><th width='20%'>Título</th><th width='20%'>Descrição</th><th width='20%'>Link</th>";
				break;
			case "3":
				$html .= "<th width='20%'>Imagem</th><th width='20%'>Título</th><th width='20%'>Descrição</th>";
				break;
			case "4":
				$html .= "<th width='60%'>Logotipo</th>";
				break;
			case "5":
				$html .= "<th width='60%'>Item</th>";
				break;
			case "6":
				$html .= "<th width='20%'>Pergunta</th><th width='40%'>Resposta</th>";
				break;
			case "7":
				$html .= "<th width='20%'>Título</th><th width='20%'>Descrição</th><th width='20%'>Link</th>";
				break;
			case "8":
				$html .= "<th width='40%'>Item</th><th width='40%'>Imagem</th>";
				break;
			case "9":
				$html .= "<th width='30%'>Item</th><th width='30%'>Link</th>";
				break;
			case "10":
				$html .= "<th width='20%'>Item</th>";
				break;
			case "11":
				$html .= "<th width='20%'>Título</th><th width='20%'>Descrição</th><th width='20%'>Imagem</th><th width='20%'>Link</th>";
				break;
			case "12":
				$html .= "<th width='20%'>Título</th><th width='20%'>Descrição</th><th width='20%'>Imagem</th><th width='20%'>Link</th>";
				break;
			case "13":
				$html .= "<th width='50%'>Título</th><th width='30%'>Data</th>";
				break;

		}

		$html .= "<th width='40%'>Ação</th></tr></thead><tbody>";
		
		if ($idlp <> "") {
			$sql = "SELECT * FROM landing_itens WHERE tipo = '".$tipo."' AND idlp = '".$idlp."' ORDER BY idli ASC;";
			$res = mysqli_query($conn, $sql);
			$total = @mysqli_num_rows($res);
			if ($total) {
				$i = 1;
				while ($obj = mysqli_fetch_array($res)) {

					if ($tipo == "1") {
						$html .= "<tr><td>".$obj['tit']."</td>";
					} 

					if ($tipo == "5") {
						$html .= "<tr><td>".$obj['tit']."</td>";
					} 

					if ($tipo == "2" || $tipo == "3") {

						$img = "";

						if ($obj['adc'] <> "") {
							$img = "<img src='".$v_url."/upl/".$obj['adc']."' width='120'>";
						}
							
						$html .= "<tr><td>".$img."</td><td>".$obj['tit']."</td><td>".$obj['descr']."</td><td>".$obj['extra']."</td>";
					}

					if ($tipo == "4") {
						$html .= "<tr><td><img src='".$v_url."/upl/".$obj['adc']."' width='120'></td>";
					}

					if ($tipo == "6") {
						$html .= "<tr><td>".$obj['tit']."</td><td>".$obj['descr']."</td>";
					} 

					if ($tipo == "7") {
						$html .= "<tr><td>".$obj['tit']."</td><td>".$obj['descr']."</td><td>".$obj['extra']."</td>";
					} 
					
					if ($tipo == "8") {
						$html .= "<tr><td>".$obj['tit']."</td><td><img src='".$v_url."/upl/".$obj['adc']."' width='120'></td>";
					} 

					if ($tipo == "9") {
						$html .= "<tr><td>".$obj['tit']."</td><td>".$obj['extra']."</td>";
					} 
					
					if ($tipo == "10") {
						$html .= "<tr><td>".$obj['tit']."</td>";
					} 

					if ($tipo == "11") {
						$html .= "<tr><td>".$obj['tit']."</td><td>".$obj['descr']."</td><td><img src='".$v_url."/upl/".$obj['adc']."' width='120'></td><td>".$obj['extra']."</td>";
					} 

					if ($tipo == "12") {
						$html .= "<tr><td>".$obj['tit']."</td><td>".$obj['descr']."</td><td><img src='".$v_url."/upl/".$obj['adc']."' width='120'></td><td>".$obj['extra']."</td>";
					} 

					if ($tipo == "9") {
						$html .= "<tr><td>".$obj['tit']."</td><td>".$obj['extra']."</td>";
					}

					
					if ($tipo == "13") {
						$html .= "<tr><td>".$obj['tit']."</td><td>".$obj['descr']."</td>";
					} 

					/*

					if ($tipo == "3" || $tipo == "7" || $tipo == "8" || $tipo == "9" || $tipo == "10") {

						$html .= "<tr><td><img src='".$v_url."/upl/".$obj['img']."' width='120'></td><td>".$obj['nome']."</td><td>".$obj['vlr']."</td>";

					} else {
					
						$html .= "<tr><td align='center' valign='center'>".$obj['nome']."</td><td align='center' valign='center'>".$obj['vlr']."</td>";
					
					}

					*/

					$html .= "<td align='right'>";

					$html .= "<input type='button' class='btn btn-info' onclick=\"javascript:land_item_adm('".$tipo."','".$obj['idli']."')\" value='Editar'></input> ";
					
					$html .= "<input type='button' class='btn btn-danger' onclick=\"javascript:land_item_del('".$tipo."','".$obj['idli']."')\" value='X'></input> ";

					/*

					if ($i > 1) {
						$html .= "<input type='button' class='btn btn-success' onclick=\"javascript:tabs_ordem('".$tipo."','".$obj['idi']."', 's')\" value='Subir'></input> ";
					}
					
					if ($i < $total) {
						$html .= "<input type='button' class='btn btn-alert' onclick=\"javascript:tabs_ordem('".$tipo."','".$obj['idi']."', 'd')\" value='Descer'></input> ";
					}
					
					*/

					$html .= "</td></tr>";

					$i = $i + 1;

					
				}
			} else {
				$html .= "<tr><td colspan='3'>Nenhum item informado até o momento</td></tr>";
			}
		} else {
			$html .= "<tr><td colspan='3'>Nenhum item informado até o momento</td></tr>";
		}

		$html .= "</table>";


		echo $html;
	
	}


}

?>