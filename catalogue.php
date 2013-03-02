<?php
	session_start(); 
	include('include/config.php');
	$genre = (!isset($_GET['genre'])) ? ('%%') : ($_GET['genre']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">

	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" /> 
		<meta name="author" content="Thomas Diot" />
		<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
		<title><?php echo $site; ?> - Catalogue des livres</title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="js/sticky.full.js"></script>
	</head>

	<body id="site-wrapper">
	
		<?php
			include('include/no-js.php');
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
					
					// On récupère le numéro de la page courante
					if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1){$page = $_GET['page'];}
					// Si il n'y en a pas, on part de la page 1
					else{$page = 1;}
										
					// On définit le nombre de livres par page
					$pagination = 10;
					// On calcule l'id du premier livre à récupérer
					if($page == 1){
						$limit_start = 0;
					}
					else{
						$limit_start = ((($page - 1) * $pagination) + $page) -1;
					}
					
					$livres = Livre::getByGenre($bdd, $genre, $limit_start, $pagination);
					
					for($i=0;$i<count($livres);$i++)
					{
				?>
				
						<div id="livre">
							<p>
							
								<?php
									echo '<a href="livre.php?id='.$livres[$i]->getId().'">';
										echo '<img src="'.$livres[$i]->getCover().'" width="200" height="300" class="alignleft" />';
									echo '</a>';
								?>
								
								<span class="titre">Titre: </span>
									<?php echo $livres[$i]->getTitle(); ?>
								<br />
								
								<span class="titre">Auteur: </span>
									<?php echo $livres[$i]->getAuthor(); ?>
								<br />
								
								<?php 
									$resume = $livres[$i]->getResume();
									if(!empty($resume)) { ?>
									<span class="titre">Résumé: </span>
										<?php echo $resume; ?>
									<br />
								<?php } ?>
								
							</p>
						</div>
						
						<div class="right">
							<a href="livre.php?id=<?php echo $livres[$i]->getId(); ?>" class="gras">Afficher le livre</a>
						</div>
						
						<br /><br /><br />
				<?php
					}
					
					$nb_total = count(Livre::getByGenre($bdd, $genre, 0,0));

					// Pagination
					$nb_pages = ceil($nb_total / $pagination);
					echo '<div id="tnt_pagination">';
					
					// Bouton précédent, activé si possible
					if($page == 1){echo '<span class="disabled_tnt_pagination">Prec</span>';}
					else{$a = $page - 1;echo '<a href="catalogue.php?genre='.$genre.'&page='.$a.'">Prec</a>';}
					
					// Boucle pour chaque page
					for ($i = 1 ; $i <= $nb_pages ; $i++){
						if ($i == $page){
							echo '<span class="active_tnt_link">'.$i.'</span>';
						}
						else{
							echo '<a href="catalogue.php?genre='.$genre.'&page='.$i.'">'.$i.'</a>';
						}
					}
					
					// Bouton suivant, si possible
					if($page == $nb_pages){echo '<span class="disabled_tnt_pagination">Suiv</span>';}
					else{$a = $page+1;echo '<a href="catalogue.php?genre='.$genre.'&page='.$a.'">Suiv</a>';}
					
					// Fin de la pagination
					echo '</div>';
				?>
				
				
			</div>

			<?php include('include/sidebar_right.inc.php'); ?>

		</div>

		<div id="footer">

			<?php include('include/footer.inc.php'); ?>

		</div>

	</body>
	
</html>