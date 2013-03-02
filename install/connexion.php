<?php

if(!empty($_POST['hote']) && !empty($_POST['base']) && !empty($_POST['login'])){
	$infos = "<?php
	\$hote = '";
	$infos .= $_POST['hote'];
	$infos .= "';
	\$base = '";
	$infos .= $_POST['base'];
	$infos .= "';
	\$user = '";
	$infos .= $_POST['login'];
	$infos .= "';
	\$pass = '";
	$infos .= $_POST['pass'];
	$infos .= "';";

				
	$txt = fopen('../include/connexion.php', 'w+');
	fseek($txt, 0);
	fputs($txt, $infos);
	fclose($txt);
	
	try{$bdd = new PDO('mysql:host='.$_POST['hote'].';dbname='.$_POST['base'].'', ''.$_POST['login'].'', ''.$_POST['pass'].'');}
	catch(Exception $e){
		$error = 'Erreur : ' . $e->getMessage();
	}
	
	if(empty($error))
	{
		header('Location: etape2.php');
	}
	else{
		header('Location: etape1.php?error='.$error);
	}
}
else{
	header('Location: etape1.php');
}