<?php
	session_start();
	 if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
	 
		 if(isset($_POST['content']) && !empty($_POST['content'])){
			include('include/config.php');
			$q = $bdd->prepare('UPDATE preferences SET value = ? WHERE id = 1');
			$q->execute(array($_POST['content']));
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
		<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="ckeditor/adapters/jquery.js"></script>
		<?php require_once('include/config.php'); ?>
		<title><?php echo $site; ?> - Editer la page A propos</title>
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
				
				<div class="success"><a href="admin.php">Administration</a> &rarr; <a href="propos_edit.php">Modifier la page à propos</a></div>

				<p>&nbsp;</p>
				
				<form method="post" action="#" id="edit">
				
					<fieldset>
						
						<legend>&nbsp;Modifier la page à propos&nbsp;</legend>
						
						<p>
							<textarea class="ckeditor" id="content" name="content">
								<?php
									$q = $bdd->query('SELECT * FROM preferences WHERE id = 1');
									$donnees = $q->fetch();
									echo $donnees['value'];
								?>
							</textarea>
							
							<script type="text/javascript">
							//<![CDATA[
								CKEDITOR.replace( 'content',{
									skin : 'v2',
									toolbar : 'MyToolbar'
								});
							//]]>
							</script>

							
						</p>
						
					

					</fieldset>
					
					<input class="right" type="submit" name="envoi" id="envoi" value="Sauvegarder la page" />
					
					
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