<?php
	
	function bold($word, $pattern){
		// Affiche les résultats en gras
		$reg = '<b>'.$word.'</b>';
		return preg_replace('#'.$word.'#i', $reg, $pattern);
	}
	
	function levder($recherche){
		// Utilisation de l'algorithme de Damerau-Levensthein pour affiner la recherche en cas de refus
		$hote = 'localhost';
		$base = 'isbn';
		$user = 'root';
		$pass = '';
		$bdd = new PDO('mysql:host='.$hote.';dbname='.$base.'', ''.$user.'', ''.$pass.'');
		
		// Suppression des accents pour la recherche
		$recherche = $recherche;
		// On initialise les deux variables qui contiendront les informations
		$texte = '';
		$tableau_distance = array();
		
		// On récupère tous les titres de la base
		$req = $bdd->query('SELECT title FROM livres');
		while($donnees = $req->fetch()){
			// On compile tous ces titres dans une variables, de façcon à former un texte complet
			$texte .= $donnees['title'];
		}
		
		// On sépare chaque mot, que l'on enregistre dans un tableau
		$mots = explode(" ", $texte);
		$z = sizeof($mots);
		
		
		// On vérifie que chaque mot fais de plus de 4 caractères, et on calcule sa distance avec le mot recherché
		$z = sizeof($mots);
		// Boucle simple, qui s'arrête à la fin du tableau...
		for($i=0;$i<$z;$i++){
			// On compte le nombre de caractère de chaque mot
			$lenght = strlen($mots[$i]);
			if($lenght < 4){
				// Si le mot est trop court (moins de 4 caractères), on le supprime et on réindèxe le tableau pour la suite
				unset($mots[$i]);
				$mots = array_values($mots);
			}
			
			// On calcule la distance de Levensthein-Deremau ...
			$distance = levenshtein($mots[$i], $recherche);
			// ... Et on l'enregistre dans un tableau pour la réexploiter ensuite
			$tableau_distance[$i] = $distance;
		}
		
		
		// On cherche la plus petite distance de Levensthein trouvée entre chaque mot et la recherche
		$min = min($tableau_distance);
		// On vérifie que cette distance est inférieure à 5, pour ne pas afficher des résultats trop loin et sans intérêt...
		if($min <= 5){
			// On repère sa clé dans les deux tableaux
			$key = array_search($min, $tableau_distance);
			// On renvoie le mot à la page demandeuse
			return $mots[$key];
		}
		// Si le mot est trop loin de tous les résultats, on renvoie que l'on a rien trouvé...
		else{
			return false;
		}
	}
	
	function envoi_mail($mail_adress, $nom, $subject, $message){

		$headers = "From: " . strip_tags($mail_adress) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($mail_adress) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		$subject = utf8_decode($subject);
		
		mail($mail_adress,$subject,$message,$headers);
		
	}
	
	function verifmail($mail){
		$expr = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
		return (preg_match($expr, $mail)) ? true : false;
	}
	
	function verifnom($nom, $taille){
		$long = strlen($nom);
		return ($long >= $taille) ? true : false;
	}
	
	function write_Date()
	{
		$tab_jours = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
		$mois = date('F');
		switch($mois) {
			case 'January': $mois = 'janvier'; break;
			case 'February': $mois = 'février'; break;
			case 'March': $mois = 'mars'; break;
			case 'April': $mois = 'avril'; break;
			case 'May': $mois = 'mai'; break;
			case 'June': $mois = 'juin'; break;
			case 'July': $mois = 'juillet'; break;
			case 'August': $mois = 'août'; break;
			case 'September': $mois = 'septembre'; break;
			case 'October': $mois = 'octobre'; break;
			case 'November': $mois = 'novembre'; break;
			case 'December': $mois = 'decembre'; break;
			default: $mois =''; break;}
			
		return $tab_jours[date('w', mktime(0,0,0,date('m'),date('d'),date('Y')))].'&nbsp'.date('d').'&nbsp;'.$mois.'&nbsp'.date('Y');
	}
	
	function convertMonths($date){
		$date = date('m', $date);
		if($date == 0){$date = "janv";}
		if($date == 1){$date = "janv";}
		if($date == 2){$date = "fevr";}
		if($date == 3){$date = "mars";}
		if($date == 4){$date = "avril";}
		if($date == 5){$date = "mai";}
		if($date == 6){$date = "juin";}
		if($date == 7){$date = "juil";}
		if($date == 8){$date = "aout";}
		if($date == 9){$date = "sept";}
		if($date == 10){$date = "oct";}
		if($date == 11){$date = "nov";}
		if($date == 12){$date = "dec";}
		return $date;
	}
	
	function suppraccent($str){
		$str = preg_replace('#&eacute;#', 'e', $str);
		$str = preg_replace('#&ecirc;#', 'e', $str);
		$str = preg_replace('#&egrave;#', 'e', $str);
		$str = preg_replace('#&euml;#', 'e', $str);
		
		$str = preg_replace('#&laquo;#', '"', $str);
		$str = preg_replace('#&raquo;#', '"', $str);
		$str = preg_replace('#&quot;#', '\'', $str);
		
		$str = preg_replace('#&agrave;#', 'a', $str);
		$str = preg_replace('#&agrave;#', 'a', $str);
		$str = preg_replace('#&acirc;#', 'a', $str);
		$str = preg_replace('#&auml;#', 'a', $str);
		$str = preg_replace('#&Auml;#', 'a', $str);
		
		$str = preg_replace('#&ccedil;#', 'c', $str);
		$str = preg_replace('#&euro;#', 'EUR', $str);
		$str = preg_replace('#&deg;#', 'o', $str);
		
		$str = preg_replace('#&icirc;#', 'i', $str);
		$str = preg_replace('#&ugrave;#', 'u', $str);
		$str = preg_replace('#&ucirc;#', 'u', $str);
		$str = preg_replace('#&oelig;#', 'oe', $str);
		
		$str = preg_replace('#&amp;#', 'o&', $str);
		
		return $str;
	}
	
	function add_search(&$item1, $key, $prefix)
	{
		$item1 = "$prefix$item1$prefix";
	}
	
?>