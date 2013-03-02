<?php
	require_once('include/config.php');
	
	$_GET['isbn'] = preg_replace('#-#', '', $_GET['isbn']);
	$book = new Livre($bdd);
	$book->scanIsbn($_GET['isbn']);
	echo $book->outXml();
?>