<?php
	include('include/config.php');
	$txt = '';
	$nb = Livre::numberBook($bdd);
	if($nb<50){$str = 4;}
	elseif($nb<100){$str = 5;}
	else{$str = 7;}
		
	
	// 1. Get all the resume in a var
	$array = Livre::getList($bdd);
	foreach($array as $value)
	{
		$txt .= $value->getResume();
	}
	
	// 2. Clean the var
	$txt = suppraccent($txt);
	$txt = preg_replace('#  #', '', $txt);
	$txt = preg_replace('#, #', ' ', $txt);
	
	// 3. Cut the variable, return an array
	$txt = explode(' ', $txt);
	
	// 4. Create a new array whitout any duplicate data
	$withoutDuplicates = array_unique(array_map("strtoupper", $txt));
	
	// 5. Create a new array whith all the duplicate data
	$duplicates = array_diff($txt, $withoutDuplicates);
	$duplicates = array_merge($duplicates);
	$duplicates = array_map("strtolower", $duplicates);
	
	// 6. Count how many times a same word appears
	$counts = array_count_values($duplicates);
	array_multisort($counts, SORT_ASC);
	
	// 7. Delete words who come only 1 time
	$i = 0;
	$end = array();
	foreach($counts as $key => $value){
		if($value > 1 && strlen($key) > $str){
			$end[] = array($i, $key, $value);
		}
		$i++;
	}
	array_multisort($end, SORT_DESC);
	
	// 8. Save the words in the database
	$i = 0;
	$q = $bdd->exec('TRUNCATE TABLE mots_cles');
	foreach($end as $key => $value){
		if($i<15){
			// echo 'Le mot <b>'.$value[1].'</b> revient <b>'.$value[2].'</b> fois !<br />';
			$action = $bdd->prepare('INSERT INTO mots_cles(mot, compte) VALUES(:mot, :compte)');
			$action->execute(array('mot' => $value[1], 'compte' => $value[2]));
			$i++;
		}
	}
	
	header('Location: admin.php?message=8');
?>