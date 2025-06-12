<?php
include('config/config.php');
//if($_SESSION["verify"] != "RESPONSIVEfilemanager") die('forbiden');
include('include/utils.php');


$storeFolder = $_REQUEST['path'];
$storeFolderThumb = $_REQUEST['path_thumb'];

$path_pos=strpos($storeFolder,$current_path);
$thumb_pos=strpos($_POST['path_thumb'],$thumbs_base_path);

//echo $current_path.' - '.$thumbs_base_path;

/*
if($path_pos!==0 
    || $thumb_pos !==0
    || strpos($storeFolderThumb,'../',strlen($thumbs_base_path))!==FALSE
    || strpos($storeFolderThumb,'./',strlen($thumbs_base_path))!==FALSE
    || strpos($storeFolder,'../',strlen($current_path))!==FALSE
    || strpos($storeFolder,'./',strlen($current_path))!==FALSE )
    die('wrong path');
*/

$path=$storeFolder;
$cycle=true;
$max_cycles=50;
$i=0;
while($cycle && $i<$max_cycles){
    $i++;
    if($path==$current_path)  $cycle=false;
    if(file_exists($path."config.php")){
	require_once($path."config.php");
	$cycle=false;
    }
    $path=fix_dirname($path).'/';
}


if (!empty($_FILES)) {
    $info=pathinfo($_FILES['file']['name']);
    if(in_array(fix_strtolower($info['extension']), $ext)){
	$tempFile = $_FILES['file']['tmp_name'];   
	  
	$targetPath = $storeFolder;
	$targetPathThumb = $storeFolderThumb;
	$_FILES['file']['name'] = fix_filename($_FILES['file']['name'],$transliteration);
	 
	if(file_exists($targetPath.$_FILES['file']['name'])){
	    $i = 1;
	    $info=pathinfo($_FILES['file']['name']);
	    while(file_exists($targetPath.$info['filename']."_".$i.".".$info['extension'])) {
		    $i++;
	    }
	    $_FILES['file']['name']=$info['filename']."_".$i.".".$info['extension'];
	}
	$targetFile =  $targetPath. $_FILES['file']['name']; 
	$targetFileThumb =  $targetPathThumb. $_FILES['file']['name'];

	//echo $targetFileThumb;
	
	if(in_array(fix_strtolower($info['extension']),$ext_img)) $is_img=true;
		else $is_img=false;
	
	
	move_uploaded_file($tempFile,$targetFile);
	chmod($targetFile, 0755);

	
	
	if($is_img){
		
		$memory_error=false;
		
	    if(!create_img_gd($targetFile, $targetFileThumb, 122, 91)){
			$memory_error=false;
	    }else{
			echo 'erro';
	    }		
	    if($memory_error){
			echo 'ent 3';
		//error
		//unlink($targetFile);
		//header('HTTP/1.1 406 Not enought Memory',true,406);
		exit();
	    }
	}
    }else{
	header('HTTP/1.1 406 file not permitted',true,406);
	exit();
    }
}else{
    header('HTTP/1.1 405 Bad Request', true, 405);
    exit();
}

if(isset($_POST['submit'])){
    $query = http_build_query(array(
        'type'      => $_POST['type'],
        'lang'      => $_POST['lang'],
        'popup'     => $_POST['popup'],
        'field_id'  => $_POST['field_id'],
        'fldr'      => $_POST['fldr'],
    ));
    header("location: dialog.php?" . $query);
}

?>      
