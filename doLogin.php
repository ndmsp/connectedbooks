<?php
	$is_ajax = $_REQUEST['is_ajax'];
	if(isset($is_ajax) && $is_ajax)
	{
		$username = $_REQUEST['username'];
		$password = sha1($_REQUEST['password']);
		
		include('include/config.php');
		
		$req = $bdd->prepare('SELECT id, login FROM isbn_admin WHERE login = :login AND mdp = :mdp');
		$req->execute(array('login' => $username, 'mdp' => $password));
		
		$resultat = $req->fetch();
		
		if($resultat)
		{
			session_start();
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['login'] = $resultat['login'];
			echo "success";
		}
	}
?>