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
		<title><?php echo $site; ?> - Accueil</title>
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
		
		<div id="splash">

			<div class="col3 left">
				<?php
					$book->get($livre_une);
				?>
				
				<h2 class="label label-green">A la une</h2>
				<p class="quiet large"><?php echo write_Date(); ?></p>

				<p><img src="<?php echo $book->getCover(); ?>" width="170" height="250" class="cover" /></p>
				<p><?php echo $book->cutResume(); ?>...</p>
				<p><a href="livre.php?id=<?php echo $book->getId(); ?>" class="more">Consulter la fiche &raquo;</a></p>

			</div>

			<div class="col3-mid left">
				<?php
					$book->get(Livre::getLast($bdd));
				?>
				
				<h2 class="label label-orange">Nouveautés</h2>
				<p class="quiet large">Voici notre dernière entrée:</p>

				<p><img src="<?php echo $book->getCover(); ?>" width="170" height="250" class="cover" /></p>
				<p><?php echo $book->cutResume(); ?>...</p>
				<p><a href="livre.php?id=<?php echo $book->getId(); ?>" class="more">Consulter la fiche &raquo;</a></p>
			</div>

			<div class="col3 right">
				<h2 class="label label-blue">Un livre au hasard</h2>
				<p class="quiet large">Pas d'idée de livre ? Laissez vous guider !</p>
				
				<?php
					$id = Livre::plotBook($bdd);
					$book->get($id);
				?>
				
				<p><img src="<?php echo $book->getCover(); ?>" width="170" height="250" class="cover" /></p>
				<p><?php echo $book->cutResume(); ?>...</p>
				<p><a href="livre.php?id=<?php echo $book->getId(); ?>" class="more">Consulter la fiche &raquo;</a></p>
			</div>

			<div class="clearer">&nbsp;</div>

		</div>
		
		

		<div class="main" id="main-two-columns">

			<div class="left" id="main-content">

				<div class="section">

					<div class="section-title">Les <?php echo $nombre_livre_mieux_notes; ?> livres les mieux notés:</div>
					<div class="section-content">
						<?php
							$array = $book->getByNote($bdd, $nombre_livre_mieux_notes);
							if(!empty($array[0])){
							
							for($i=0;$i<$nombre_livre_mieux_notes;$i++){
								$id = $array[$i]->getId();
								$livre = new Livre($bdd);
								$livre->get($id);
						?>
							<div class="post">
								<div class="post-title"><h2><?php echo $livre->getTitle(); ?></h2></div>
								<div class="post-body">
									<p>
										<?php echo $livre->cutResume(); ?>
									</p>
									<a href="livre.php?id=<?php echo $livre->getId(); ?>" class="more">En savoir plus &#187;</a>
								</div>
							</div>
						<?php
							}}
						?>

						<div class="content-separator"></div>
						<div class="clearer">&nbsp;</div>
					</div>

				</div>		
				
			</div>

			<?php include('include/sidebar_right.inc.php'); ?>

		</div>

		<div id="footer">

			<?php include('include/footer.inc.php'); ?>

		</div>

	</body>
	
</html>