
<?php
	session_start();
	 if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
		include('include/config.php');
		$q = $bdd->query('SELECT * FROM isbn_admin');
		$q = $q->fetchAll();
		$erreur = array();
		if(!empty($_POST['login']) && !empty($_POST['mail']) && !empty($_POST['apass']) && $q[0]['mdp'] == sha1($_POST['apass']) ){
			
			if(empty($_POST['npass1']) && empty($_POST['npass2'])){
				$q = $bdd->prepare('UPDATE isbn_admin SET login = ?, email = ?');
				$q->execute(array($_POST['login'], $_POST['mail']));
				header('Location: admin.php?message=6');
			}
			elseif($_POST['npass1'] == $_POST['npass2'])
			{
				$q = $bdd->prepare('UPDATE isbn_admin SET login = ?, mdp = ?, email = ?');
				$q->execute(array($_POST['login'], sha1($_POST['npass1']), $_POST['mail']));
				header('Location: admin.php?message=6');
			}
			
		}
		if(!empty($_POST['npass1']) && $_POST['npass1'] != $_POST['npass2']){
			$erreur[] = 'Les mots de passe ne concordent pas...';
		}
		if(isset($_POST['apass']) && $q[0]['mdp'] != sha1($_POST['apass'])){
			$erreur[] = 'Le mot de passe indiqué est faux...';
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
		<title><?php echo $site; ?> - Mon compte</title>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#login').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#mail').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#apass').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#npass1').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
				$('#npass2').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });

				$("#ajout").submit(function(){
					// Check every data validity
					if( $("#login").val() == "" || $("#mail").val() == "" || $("#apass").val() == "")
					{
							if( $("#login").val() == "" ){ $("#login").removeClass('text'); $("#login").addClass('error'); }
							if( $("#mail").val() == ""){ $("#mail").removeClass('text'); $("#mail").addClass('error');}
							if( $("#apass").val() == ""){ $("#apass").removeClass('text'); $("#apass").addClass('error');}
							
							return false;
					}
					
					if(($("#npass1").val() != "" && $("#npass2").val() == "") || $("#npass2").val() != "" && $("#npass1").val() == "")
					{
						if($("#npass1").val() != "" && $("#npass2").val() == "")
						{
							if( $("#npass2").val() == ""){ $("#npass2").removeClass('text'); $("#npass2").addClass('error');}
						}
						if($("#npass2").val() != "" && $("#npass1").val() == "")
						{
							if( $("#npass1").val() == ""){ $("#npass1").removeClass('text'); $("#npass1").addClass('error');}
						}
						return false;
					}
						
					else{
						return true;
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
				
				<div class="success"><a href="admin.php">Administration</a> &rarr; <a href="livre.php">Mon compte</a></div>
				
				<form method="post" action="#" id="ajout">
					
					<fieldset>
						
						<legend>&nbsp;Editer mon compte&nbsp;</legend>
						
						<?php
							$q = $bdd->query('SELECT * FROM isbn_admin');
							$admin = $q->fetchAll();
							
							if(!empty($erreur)){
								foreach($erreur as $value){
									echo '<p id="error">'.$value.'</p>';
									echo '<br />';
								}
							}
						?>
						
						<table>
							
							<tr>
								 <td>
									  <label for="login">Pseudo</label>
								 </td>
								 <td>
									  <input type="text" name="login" value="<?php echo $admin[0]['login']; ?>" id="login" class="text" />
								 </td>
							</tr>
							
							<tr>
								<td>
									<label for="mail">Adresse mail</label>
								</td>
								<td>
									<input name="mail" class="text" id="mail" type="text" value="<?php echo $admin[0]['email']; ?>" />
								 </td>
							</tr>
							
							<tr>
								<td>
									<label for="apass">Ancien mot de passe</label>
								</td>
								<td>
									<input type="password" class="text" name="apass" id="apass" />
								 </td>
							</tr>
							
							<tr>
								<td>
									<label for="npass1">Nouveau mot de passe</label>
								</td>
								<td>
									<input type="password" class="text" name="npass1" id="npass1" /> 
								 </td>
							</tr>
							
							<tr>
								<td>
									<label for="npass2">Répétez le mot de passe</label>
								</td>
								<td>
									<input name="npass2" class="text" id="npass2" type="password" />
								 </td>
							</tr>
							
					   </table>

					   </fieldset>

					   <div id="class"></div>

					   <input class="right" type="submit" name="envoi" id="envoi" value="Sauvegarder les paramètres" />
					   
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