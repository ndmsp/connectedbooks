<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">

	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" /> 
		<meta name="author" content="Thomas Diot" />
		<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="js/sticky.full.js"></script>
		<?php include('include/config.php'); ?>
		<title><?php echo $site; ?> - Recherche</title>
	</head>

	<body id="site-wrapper">
	
		<?php
			include('include/no-js.php');
			$book = new Livre($bdd);
		?>

		<div id="header">
			
			<?php 
				include('include/top.inc.php'); 
				include('include/menu.inc.php');
			?>
			
		</div>

		<div class="main" id="main-two-columns">

			<div class="left" id="main-content">

				<?php
				
					if(!empty($_POST['recherche']) OR !empty($_GET['mot']) OR !empty($_POST['isbn']) OR !empty($_POST['title']) OR !empty($_POST['author']) OR !empty($_POST['year']) OR !empty($_POST['collection']) OR !empty($_POST['resume']))
					{
						
						if(!empty($_POST['recherche']) OR !empty($_GET['mot']))
						{
							$a = 1;
							$search = !empty($_POST['recherche']) ? $_POST['recherche'] : $_GET['mot'];
							$result = Livre::search($bdd, $search);
						}
						elseif(!empty($_POST['isbn']) OR !empty($_POST['title']) OR !empty($_POST['author']) OR !empty($_POST['year']) OR !empty($_POST['collection']) OR !empty($_POST['resume']))
						{
							$a = 2;
							$search = array(
								'isbn' => $_POST['isbn'],
								'title' => $_POST['title'],
								'author' => $_POST['author'],
								'year' => $_POST['year'],
								'collection' => $_POST['collection'],
								'resume' => $_POST['resume']
							);
							array_walk($search, 'add_search', '%');
							$result = Livre::searchBy($bdd, $search);
						}
						
						$nb_result = count($result);
						echo ($nb_result > 0) ? ('Nous avons trouvé <b>'.$nb_result.'</b> résultats:') : ('Nous n\'avons pas trouvé de résultats... Merci de réessayer avec d\'autres termes !');
						
						foreach($result as $value){
							$book = new Livre($bdd);
							$book->get($value);
							
							if($a == 1){
								$title = bold($search, $book->getTitle());
								$author = bold($search, $book->getAuthor());
								$resume = bold($search, $book->getResume());
							}
							
							else{
								$title = bold($search['title'], $book->getTitle());
								$author = bold($search['author'], $book->getAuthor());
								$resume = bold($search['resume'], $book->getResume());
							}
							
							
							echo '
								<div id="livre">
									<p>
								
											<a href="livre.php?id='.$book->getId().'">
												<img src="'.$book->getCover().'" width="200" height="300" class="alignleft" />
											</a>
									
										<span class="titre">Titre: </span>'.$title.'
										<br />
										
										<span class="titre">Auteur: </span>'.$author.'
										<br />
										
										<span class="titre">Résumé: </span>'.$resume.'
										<br />
									
									</p>
								</div>
							
								<div class="right">
									<a href="livre.php?id='.$book->getId().'" class="gras">Afficher le livre</a>
								</div>';
							echo '<p>&nbsp;</p><p>&nbsp;</p>';
							}
						
					}
					
					
					
					
					
					else{
				?>
						
						<form method="post" action="recherche.php">
							<fieldset>
								<legend>Rechercher un document</legend>
									<table>
										<tr>
											<td>
												<label for="isbn">Numéro ISBN</label>
											</td>
											<td>
												<input type="text" name="isbn" id="isbn" class="text" />
											</td>
										</tr>
										<tr>
											<td>
												<label for="title">Titre</label>
											</td>
											<td>
												<input type="text" name="title" id="title" class="text" />
											</td>
										</tr>
										<tr>
											<td>
												<label for="author">Nom de l'auteur</label>
											</td>
											<td>
												<input type="text" name="author" id="author" class="text" />
											</td>
										</tr>
										<tr>
											<td>
												<label for="year">Année de parution</label>
											</td>
											<td>
												<input type="text" name="year" id="year" class="text" />
											</td>
										</tr>
										<tr>
											<td>
												<label for="collection">Collection</label>
											</td>
											<td>
												<input type="text" name="collection" id="collection" class="text" />
											</td>
										</tr>
										<tr>
											<td>
												<label for="resume">Sujet de l'oeuvre</label>
											</td>
											<td>
												<input type="text" name="resume" id="resume" class="text" />
											</td>
										</tr>
									</table>
							</fieldset>
							<input class="right" type="submit" name="envoi" value="Lancer la recherche" />
						</form>
				<?php
					}
				?>
				
			</div>

			<?php include('include/sidebar_right.inc.php'); ?>

		</div>

		<div id="footer">

			<?php include('include/footer.inc.php'); ?>

		</div>

	</body>
	
</html>