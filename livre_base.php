<?php
	
	if( (isset($_POST['type']) && !empty($_POST['type'])) || (isset($_GET['type']) && !empty($_GET['type'])))
	{
	
		require_once('include/config.php');
		$type = (!empty($_POST['type'])) ? ($_POST['type']) : ($_GET['type']);
		
		// Add a new book in the db
		if($type == 1 && !empty($_POST['titre']) AND !empty($_POST['auteur'])){
				header('Location: livre_nouveau.php?message=5');
				
				$book = new Livre($bdd);
				$book->setTitle($_POST['titre']);
				$book->setAuthor($_POST['auteur']);
				$book->setAuthor($_POST['auteur']);
				$book->setGenre($_POST['genre']);
				$book->setYear($_POST['annee']);
				$book->setResume($_POST['resume']);
				$book->setCover($_POST['cover']);
				$book->setNote($_POST['note']);
				$book->setIsbn($_POST['isbn']);
				$book->setCollection($_POST['collection']);
				$book->add();
				
		}
		elseif($type == 1){
			echo 'a';
			header('Location: livre_nouveau.php?message=9');
		}
		
		
		// Update a book
		if($type == 2 && !empty($_POST['id']) AND !empty($_POST['id'])){
			header('Location: livre_edit.php?message=6');
			
			$book = new Livre($bdd);
			$book->setId($_POST['id']);
			$book->setTitle($_POST['titre']);
			$book->setAuthor($_POST['auteur']);
			$book->setAuthor($_POST['auteur']);
			$book->setGenre($_POST['genre']);
			$book->setYear($_POST['annee']);
			$book->setResume($_POST['resume']);
			$book->setCover($_POST['cover']);
			$book->setNote($_POST['note']);
			$book->setIsbn($_POST['isbn']);
			$book->setCollection($_POST['collection']);
			$book->update();
		}
		elseif($type == 2){
			echo 'a';
			header('Location: livre_edit.php?message=9');
		}
		
		// Delete a book
		if($type == 3 && !empty($_GET['id']) ){
			Livre::deleteFromDb($bdd, $_GET['id']);
			header('Location: livre_suppr.php?message=10');
		}
		
		// Truncate database
		if($type == 4 && $_GET['pass'] == 'Oui je le veux !'){
			$truncate = Livre::truncateDb($bdd);
			$message = (is_array($truncate)) ? (11) : (9);
			header('Location: admin.php?message='.$message);
		}
		elseif($type == 4){
			header('Location: admin.php?message=9');
		}
		
		// Livre a la une
		if($type == 5 && !empty($_GET['id'])){
			$q = $bdd->prepare('UPDATE preferences SET value = ? WHERE id = 5');
			$q->execute(array($_GET['id']));
			header('Location: admin.php?message=6');
		}
		elseif($type == 5){
			header('Location: admin.php?message=9');
		}
		
		// Add a Favorite book
		if($type == 6 && !empty($_GET['id'])){
			$q = $bdd->prepare('INSERT INTO favorite_books(id_livre) VALUES(?)');
			$q->execute(array($_GET['id']));
			
			$id = $bdd->lastInsertId('id');
			$book = new Livre($bdd);
			$book->get($_GET['id']);
			
			echo '<BookObject><BookData>
				<ID>'.$id.'</ID>
				<Title>'.$book->getTitle().'</Title>
				<Author>'.$book->getAuthor().'</Author>
			</BookData></BookObject>';
		}
		elseif($type == 6){
			header('Location: admin.php?message=9');
		}
		
		// Delete a Favorite book
		if($type == 7 && !empty($_GET['id'])){
			$q = $bdd->prepare('DELETE FROM favorite_books WHERE id = ?');
			$q->execute(array($_GET['id']));
		}
		elseif($type == 7){
			header('Location: admin.php?message=9');
		}
			
	}
		
?>