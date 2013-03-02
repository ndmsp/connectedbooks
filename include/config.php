<?php

	include('include/connexion.php');
	
	// Connexion à la base de données
	try{$bdd = new PDO('mysql:host='.$hote.';dbname='.$base.'', ''.$user.'', ''.$pass.'');}
	catch(Exception $e){die('Erreur : ' . $e->getMessage());}
	
	// Insertion des bibliothèques
	require_once('include/function.inc.php');
	require_once('class/livre.class.php');
	
	// Préférences du site
	$q = $bdd->query('SELECT * FROM preferences');
	$pref = $q->fetchAll();
	$site = $pref[1]['value'];
	$nombre = Livre::numberBook($bdd);
	$livres_recents = ($nombre > $pref[2]['value']) ? ($pref[2]['value']) : ($nombre);
	$nombre_livre_mieux_notes = ($nombre > $pref[3]['value']) ? ($pref[3]['value']) : ($nombre);
	$livre_une = $pref[4]['value'];
	$nb = Livre::getFavorite($bdd,100000);
	$favorite_books = ($nb > $pref[5]['value']) ? ($pref[5]['value']) : ($nombre);
	
	// Messages d'erreurs
	$message = array(
		1 => 'Votre réservation a bien été enregistrée',
		2 => 'Vous êtes maintenant déconnecté',
		3 => 'Désolé, mais vous ne pouvez pas accéder à cette page...',
		4 => 'Votre compte est désormais créé',
		5 => 'Le livre a bien été enregistré !',
		6 => 'La modification a bien été enregistrée',
		7 => 'Vous êtes maintenant connecté',
		8 => 'Les mots clés ont bien été mis à jour !',
		9 => 'Une erreur a été rencontrée... Merci de recommencer',
		10 => 'Le livre a bien été supprimé !',
		11 => 'La base de données a correctement été vidée !'
	);
	
	// Affichage des messages d'erreur
	if(!empty($_GET['message']) && $_GET['message'] > 0 && array_key_exists($_GET['message'], $message)){
		echo "<script> $(document).ready(function(){ $.sticky(' ";
		echo $message[$_GET['message']];
		echo "');});</script>";
	}
	
	
?>