		<div class="left" id="footer-left">
			
			<a href="http://web-diot.fr"><img src="img/logo_small.png" alt="" class="left" /></a>
			
			<p>&copy;
				<?php 
					echo date('Y');
					echo ' - ';
					echo date('Y')+1;
					echo ' '.$site; 
				?>
				. Tous droits réservés
			</p>

			<p class="quiet">Une création originale de <a href="http://connectedbooks.web-diot.fr/">Thomas Diot</a></p>
			
			<div class="clearer">&nbsp;</div>

		</div>
		
		<?php	
			if(!isset($_SESSION['id'])){
		?>
			<script type="text/javascript">
				$(document).ready(function() {
					$('a.login-window').click(function() {
						
						// Getting the variable's value from a link 
						var loginBox = $(this).attr('href');

						//Fade in the Popup and add close button
						$(loginBox).fadeIn(300);
						
						//Set the center alignment padding + border
						var popMargTop = ($(loginBox).height() + 24) / 2; 
						var popMargLeft = ($(loginBox).width() + 24) / 2; 
						
						$(loginBox).css({ 
							'margin-top' : -popMargTop,
							'margin-left' : -popMargLeft
						});
						
						// Add the mask to body
						$('body').append('<div id="mask"></div>');
						$('#mask').fadeIn(300);
						
						return false;
					});
					
					// When clicking on the button close or the mask layer the popup closed
					$('a.close, #mask').live('click', function() {
						  $('#mask , .login-popup').fadeOut(300 , function() {
							$('#mask').remove();  
						}); 
						return false;
					});
				});
			</script>
			<script type="text/javascript">
				$(document).ready(function() {
					
					$("#login").click(function() {
					
						var action = $("#form1").attr('action');
						var form_data = {
							username: $("#username").val(),
							password: $("#password").val(),
							is_ajax: 1
						};
						
						$.ajax({
							type: "POST",
							url: action,
							data: form_data,
							success: function(response)
							{
								if(response == 'success')
									window.location.replace("admin.php?message=7");
								else
									$("#message").html("<br /><p class='error'>Nom d'utilisateur ou mot de passe invalide...</p>");	
							}
						});
						
						return false;
					});
					
				});
			</script>
			<div id="login-box" class="login-popup">
			
				<a href="#" class="close"><img src="img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
				<form method="post" id="form1" class="signin" action="doLogin.php">
				
					<fieldset class="textbox">
					
						<label class="username">
							<span>Nom d'utilisateur</span>
							<input id="username" name="username" value="" type="text" autocomplete="on" placeholder="Nom d'utilisateur">
						</label>
					
						<label class="password">
							<span>Mot de passe</span>
							<input id="password" name="password" value="" type="password" placeholder="Mot de passe">
						</label>
					
						<button class="submit button" id="login" type="button">Se connecter</button>
					
						<p id="message">
							<a class="forgot" href="#">Mot de passe oubli&eacute;?</a>
						</p>
				
					</fieldset>
					
				</form>
			</div>
		<?php
			}
		?>

		
		<div class="right" id="footer-right">

			<p class="large">
				<a href="/blog">Blog</a>
				<span class="text-separator">|</span>
				<a href="catalogue.php">Catalogue</a>
				<span class="text-separator">|</span>
				<?php	
					if(!isset($_SESSION['id'])){
				?>
				<a href="#login-box" class="login-window">Administration</a>
				<span class="text-separator">|</span>
				<?php
					}
					else{
				?>
				<a href="admin.php" class="login-window">Administration</a>
				<span class="text-separator">|</span>
				<?php
					}
				?>
				<strong><a href="contact.php">Nous contacter</a></strong>
				<span class="text-separator">|</span>
				<a href="#top" class="quiet">Haut de page &uarr;</a>
			</p>

		</div>

		<div class="clearer">&nbsp;</div>