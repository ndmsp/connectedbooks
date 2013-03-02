<?php
	session_start();
	 if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
		if(!empty($_POST['site'])){
			include('include/config.php');
			$q = $bdd->prepare('UPDATE preferences SET value = ? WHERE id = 2');
			$q->execute(array($_POST['site']));
			$q = $bdd->prepare('UPDATE preferences SET value = ? WHERE id = 3');
			$q->execute(array($_POST['recents']));
			$q = $bdd->prepare('UPDATE preferences SET value = ? WHERE id = 4');
			$q->execute(array($_POST['notes']));
			$q = $bdd->prepare('UPDATE preferences SET value = ? WHERE id = 6');
			$q->execute(array($_POST['favorite']));
			header('Location: admin.php?message=6');
		}
		if(!empty($_POST['cat1'])){
			include('include/config.php');
			for($i=1;$i<13;$i++)
			{
				$q = $bdd->prepare('UPDATE categories SET titre = ? WHERE id = '.$i);
				$q->execute(array($_POST['cat'.$i]));
			}
			header('Location: admin.php?message=6');
		}
		else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" /> 
		<meta name="author" content="Thomas Diot" />
		<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="js/sticky.full.js"></script>
		<?php require_once('include/config.php'); ?>
		<title><?php echo $site; ?> - Préférences du site</title>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#cat1').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#cat2').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#cat3').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#cat4').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#cat5').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#cat6').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#cat7').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#cat8').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#cat9').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#cat10').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#cat11').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#cat12').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });

				$("#modif").submit(function(){
					if( $("#cat1").val() == "" || $("#cat2").val() == "" || $("#cat3").val() == "" || $("#cat4").val() == "" || $("#cat5").val() == "" || $("#cat6").val() == "" || $("#cat7").val() == "" || $("#cat8").val() == "" || $("#cat9").val() == "" || $("#cat10").val() == "" || $("#cat11").val() == "" || $("#cat12").val() == "")
					{
						if( $("#cat1").val() == "" ){ $("#cat1").removeClass('text'); $("#cat1").addClass('error'); }
						if( $("#cat2").val() == "" ){ $("#cat2").removeClass('text'); $("#cat2").addClass('error'); }
						if( $("#cat3").val() == "" ){ $("#cat3").removeClass('text'); $("#cat3").addClass('error'); }
						if( $("#cat4").val() == "" ){ $("#cat4").removeClass('text'); $("#cat4").addClass('error'); }
						if( $("#cat5").val() == "" ){ $("#cat5").removeClass('text'); $("#cat5").addClass('error'); }
						if( $("#cat6").val() == "" ){ $("#cat6").removeClass('text'); $("#cat6").addClass('error'); }
						if( $("#cat7").val() == "" ){ $("#cat7").removeClass('text'); $("#cat7").addClass('error'); }
						if( $("#cat8").val() == "" ){ $("#cat8").removeClass('text'); $("#cat8").addClass('error'); }
						if( $("#cat9").val() == "" ){ $("#cat9").removeClass('text'); $("#cat9").addClass('error'); }
						if( $("#cat10").val() == "" ){ $("#cat10").removeClass('text'); $("#cat10").addClass('error'); }
						if( $("#cat11").val() == "" ){ $("#cat11").removeClass('text'); $("#cat11").addClass('error'); }
						if( $("#cat12").val() == "" ){ $("#cat12").removeClass('text'); $("#cat12").addClass('error'); }
						
						return false;
					}
				});
			});
		</script>
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
				
				<div class="success"><a href="admin.php">Administration</a> &rarr; <a href="livre.php">Ajouter un livre</a></div>

				<form method="post" action="preferences.php" id="ajout">
					
					<fieldset>
						
						<legend>&nbsp;Modifier les préférences du site&nbsp;</legend>
						
						<?php
							$q = $bdd->query('SELECT * FROM preferences');
							$pref = $q->fetchAll();
						?>
						
						<table>
							
							<tr>
								 <td>
									  <label for="site">Nom du site</label>
								 </td>
								 <td>
									  <input type="text" name="site" value="<?php echo $pref[1]['value']; ?>" id="site" class="text" />
								 </td>
							</tr>
							
							<tr>
								<td>
									<label for="recents">Nombre entrées récentes</label>
								</td>
								<td>
									<select name="recents" id="recents">
										<option value="5" <?php if($pref[2]['value'] == 5){echo 'selected';} ?>>5</option>
										<option value="10" <?php if($pref[2]['value'] == 10){echo 'selected';} ?>>10</option>
										<option value="15" <?php if($pref[2]['value'] == 15){echo 'selected';} ?>>15</option>
									</select>
								 </td>
							</tr>
							
							<tr>
								<td>
									<label for="notes">Nombres de livres mieux notés (accueil)</label>
								</td>
								<td>
									<select name="notes" id="notes">
										<option value="5" <?php if($pref[3]['value'] == 5){echo 'selected';} ?>>5</option>
										<option value="10" <?php if($pref[3]['value'] == 10){echo 'selected';} ?>>10</option>
										<option value="15" <?php if($pref[3]['value'] == 15){echo 'selected';} ?>>15</option>
									</select>
								 </td>
							</tr>
							
							<tr>
								<td>
									<label for="favorite">Nombres de livres favoris</label>
								</td>
								<td>
									<select name="favorite" id="favorite">
										<option value="5" <?php if($pref[4]['value'] == 5){echo 'selected';} ?>>5</option>
										<option value="10" <?php if($pref[4]['value'] == 10){echo 'selected';} ?>>10</option>
										<option value="15" <?php if($pref[4]['value'] == 15){echo 'selected';} ?>>15</option>
									</select>
								 </td>
							</tr>
							
							<tr>
								 <td>
									  <label for="mots_cles">Mettre à jour les mots clés</label>
								 </td>
								 <td>
									 <a href="clef.php" title="Lancer la mise à jour !"><img src="img/arrow_rotate_anticlockwise.png" /></a>
								</td>
							</tr>


					   </table>

					   </fieldset>

					   <div id="class"></div>

					   <input class="right" type="submit" name="envoi" id="envoi" value="Sauvegarder les paramètres" />
					   
				  </form>
				  
				  
				  <br /><br />
				  
				  
				  <form method="post" action="preferences.php" id="modif">
					
					<fieldset>
						
						<legend>&nbsp;Modifier les catégories&nbsp;</legend>
						
						<table>
						
							<?php
								$q = $bdd->query('SELECT * FROM categories');
								$cat = $q->fetchAll();
								$i = 1;
								foreach($cat as $value){
								
									echo '<tr>';
										echo '<td>';
											echo '<label for="cat'.$i.'">Catégorie '.$i.'</label>';
										echo '</td>';
										
										echo '<td>';
											echo '<input type="text" class="text" name="cat'.$i.'" id="cat'.$i.'" value="'.$value['titre'].'" />';
										echo '</td>';
									echo '</tr>';
									
									$i++;
									
								}
							?>
						
					   </table>

					   </fieldset>

					   <div id="class"></div>

					   <input class="right" type="submit" name="envoi" id="envoi" value="Sauvegarder les modifications" />
					   
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
   }}
   else{
		echo 'a';
		header('Location: index.php?message=3');
   }
?>