<?php
	if(!empty($_POST['login']) && !empty($_POST['pass']) && !empty($_POST['email']))
	{
				require_once('../include/connexion.php');
				try{$bdd = new PDO('mysql:host='.$hote.';dbname='.$base.'', ''.$user.'', ''.$pass.'');}
				catch(Exception $e){die('Erreur : ' . $e->getMessage);}
				
				$q = $bdd->prepare('INSERT INTO isbn_admin(login, mdp, email) VALUES(?,?,?)');
				$q->execute(array($_POST['login'], sha1($_POST['pass']), $_POST['email']));
				header('Location: end.php');
	}
	else{
		header('Location: etape3.php');
	}