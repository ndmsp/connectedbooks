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
		<title><?php echo $site; ?> - Contact</title>
		
		<link href="css/uni-form.css" media="screen" rel="stylesheet"/>
		<link href="css/default.uni-form.css" id="formStyle" title="Default Style" media="screen" rel="stylesheet"/>

		<!--[if lte ie 7]>
		  <style type="text/css" media="screen">s
			.uniForm, .uniForm fieldset, .uniForm .ctrlHolder, .uniForm .formHint, .uniForm .buttonHolder, .uniForm .ctrlHolder ul{ zoom:1; }
		  </style>
		<![endif]-->
		
		<script type="text/javascript" src="js/uni-form.jquery.js"></script>
		<script type="text/javascript">
		  $(function(){
			$('form.uniForm').uniform();
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

				<form method="post" action="contact.php" class="uniForm">
      
					<div class="header">
						<?php
							if(!empty($_POST['name']) && !empty($_POST['mail']) && !empty($_POST['message']))
								{
								
									$q = $bdd->query('SELECT email FROM isbn_admin WHERE id = 1');
									$q = $q->fetchAll();
									
									$message = '<html><body>';
									$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
									$message .= "<tr style='background: #eee;'><td><strong>Nom:</strong> </td><td>" . strip_tags($_POST['name']) . "</td></tr>";
									$message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($_POST['mail']) . "</td></tr>";
									$curText = htmlentities($_POST['message']);           
									$message .= "<tr><td><strong>Message:</strong> </td><td>" . $curText . "</td></tr>";
									$message .= "</table>";
									$message .= "</body></html>";
									
									envoi_mail($q[0]['email'], $_POST['name'],  'Demande de contact', $message);
									echo '<div id="okMsg">
										<p>
											Le message a bien été envoyé !
										</p>
									</div>';
								}
							else{
						?>
					
						<fieldset>
							<h3>Nous contacter</h3>
							
							<div class="ctrlHolder">
								<label for=""><em>*</em> Votre nom</label>
								<input name="name" id="name" data-default-value="Votre nom et prénom complet" size="35" maxlength="50" type="text" class="textInput large"/>
								<p class="formHint">Gardons un peu d'intimité, non ?</p>
							</div>
							
							<div class="ctrlHolder">
								<label for=""><em>*</em> Votre adresse mail</label>
								<input name="mail" id="mail" data-default-value="nom@adresse.fr" size="35" maxlength="50" type="text" class="textInput large"/>
								<p class="formHint">Merci d'entrer une adresse email valide</p>
							</div>
							
							<div class="ctrlHolder">
								<label for=""><em>*</em> Votre message</label>
								<textarea name="message" id="message" rows="25" cols="25" data-default-value="Entrons dans le vif du sujet !!"></textarea>
								<p class="formHint">Nous vous répondrons le plus rapidement possible.</p>
							</div>
        
						</fieldset>

						<div class="buttonHolder">
							<button type="reset" class="secondaryAction">? Annuler</button>
							<button type="submit" class="primaryAction">Envoyer !!</button>
						</div>
						<?php
					}
				?>
					</div>
					
				</form>
				
				
			</div>

			<?php include('include/sidebar_right.inc.php'); ?>

		</div>

		<div id="footer">

			<?php include('include/footer.inc.php'); ?>

		</div>

	</body>
	
</html>