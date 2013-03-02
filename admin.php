<?php
	session_start();
	if(isset($_SESSION['id'])){
?>
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
		<script type="text/javascript" src="http://razorjack.net/quicksand/scripts/main.js"></script>
		<script type="text/javascript">
			function truncateDb(){
				var x;
				var confirm=prompt("Pour confirmer, recopiez textuellement: \"Oui je le veux !\"","");
				if (confirm != 'Oui je le veux !'){
					alert('Vous avez mal recopié !');
					return false;
				}
				else{
					alert('C\'est parti ! Tchuss les données !!');
					window.location.href="livre_base.php?type=4&pass="+confirm;
				}
			}
		</script>

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

				<img src="img/fleche.png"><h2 id="tadmin">&nbsp;Administration de Lire à Stan</h2>
				
				<br /><br />
				<form id="base">
					<fieldset>
						<legend>&nbsp;Edition de la base de données&nbsp;</legend>
						<table>
							<tr>
								<td><a href="livre_nouveau.php"><img src="img/ajouter.png" /></a></td>
								<td><a href="livre_edit.php"><img src="img/modifier.png" /></a></td>
								<td><a href="livre_suppr.php"><img src="img/poubelle.png" /></a></td>
								<td><a href="livre_liste.php"><img src="img/enreg.png" /></a></td>
							</tr>
							<tr>
								<td>Ajouter un nouveau livre</td>
								<td>Modifier un livre enregistré</td>
								<td>Supprimer un livre</td>
								<td>Consulter la liste des livres</td>
							</tr>
						</table>
					</fieldset>
				</form>
				
				<br /><br />
				
				<form id="site">
					<fieldset>
						<legend>&nbsp;Gestion du site&nbsp;</legend>
						<table>
							<tr>
								<td><a href="propos_edit.php"><img src="img/blog.png" /></a></td>
								<td><a href="livre_favori.php"><img src="img/favorite.png" width="48" height="48" /></a></td>
								<td><a href="livre_une.php"><img src="img/pouce.png" /></a></td>
								<td><a href="preferences.php"><img src="img/purge.png" /></a></td>
							</tr>
							<tr>
								<td>Page à propos</td>
								<td>Livres favoris</td>
								<td>Livre à la une</td>
								<td>Préférences</td>
							</tr>
						</table>
					</fieldset>
				</form>
				
				<br /><br />
				
				<form id="compte">
					<fieldset>
						<legend>&nbsp;Votre compte&nbsp;</legend>
						<table>
							<tr>
								<td><a href="infos_compte.php"><img src="img/modif.png" /></a></td>
								<td><a href="#compte" onclick="truncateDb()"><img src="img/supprcompte.png" /></a></td>
								<td><a href="http://connectedbooks.web-diot.fr/"><img src="img/messagerie.png" /></a></td>
								<td><a href="deconnexion.php"><img src="img/deconnexion.png" /></a></td>
							</tr>
							<tr>
								<td>Editer vos informations</td>
								<td>Vider le site</td>
								<td>Obtenir de l'aide</td>
								<td>Se déconnecter</td>
							</tr>
						</table>
					</fieldset>
				</form>
					
			</div> 
			
			<?php include('include/sidebar_right.inc.php'); ?>

		</div>

		<div id="footer">

			<?php include('include/footer.inc.php'); ?>

		</div>

	</body>
	
</html>
<?php
	}
	else{
		echo 'a';
		header('Location: index.php?message=3');
	}
?>