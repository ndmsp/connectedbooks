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
		<title><?php echo $site; ?> - A propos</title>
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
			
				<div id="presentation">
				
					<img src="http://www.plantu.net/img/PF_souris.gif" width="75" height="75" alt="" class="alignleft" />
					
					<?php
						$q = $bdd->query('SELECT value FROM preferences WHERE id = 1');
						$content = $q->fetch();
						echo $content[0];
					?>
					
					<br />
					<legend>
						Ce site est géré par ConnectedBooks
					</legend>
					<br />
					<p>
						ConnectedBooks est une application de gestion de livres sur internet. Le propriétaire de ce site a téléchargé ConnectedBook et l'a installé facilement sur son serveur. Vous voulez faire de même ? Rien de plus simple ! Rendez vous sur , téléchargez, installez et utilisez !!
					</p>
					<br /><br />
									
				</div>		
					
			</div>

			<?php include('include/sidebar_right.inc.php'); ?>

		</div>

		<div id="footer">

			<?php include('include/footer.inc.php'); ?>

		</div>

	</body>
	
</html>