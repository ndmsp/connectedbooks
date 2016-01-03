<?php
	session_start();
	 if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
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
		<title><?php echo $site; ?> - Ajouter un nouveau livre</title>
		
		<script type="text/javascript">
			$(document).ready(function() {
				
				var note = false;
				
				$("ul.notes-echelle").addClass("js");
				$("ul.notes-echelle li").addClass("note-off");
				$("ul.notes-echelle li").mouseover(function() {
					$(this).nextAll("li").addClass("note-off");
					$(this).prevAll("li").removeClass("note-off");
					$(this).removeClass("note-off");
				});
				$("ul.notes-echelle").mouseout(function() {
					$(this).children("li").addClass("note-off");
					$(this).find("li input:checked").parent("li").trigger("mouseover");
				});
				$("ul.notes-echelle input:checked").parent("li").trigger("mouseover");
				$("ul.notes-echelle input:checked").trigger("click");

				 
				  
				$("ul.notes-echelle input")
					.focus(function() {
						$(this).parents("ul.notes-echelle").find("li").removeClass("note-focus");
						$(this).parent("li").addClass("note-focus");
						$(this).parent("li").nextAll("li").addClass("note-off");
						$(this).parent("li").prevAll("li").removeClass("note-off");
						$(this).parent("li").removeClass("note-off");
					})
					.blur(function() {
						$(this).parents("ul.notes-echelle").find("li").removeClass("note-focus");
						if($(this).parents("ul.notes-echelle").find("li input:checked").length == 0) {
							$(this).parents("ul.notes-echelle").find("li").addClass("note-off");
						}
					})
					.click(function(){
						$(this).parents("ul.notes-echelle").find("li").removeClass("note-checked");
						$(this).parent("li").addClass("note-checked");
						note = true;
						$("#note").removeClass('error');
					});
					
						
					$("#ajout").keypress(function(e) {
						if (e.which == 13) {
							return false;
						}
					});
					
					$('#isbn').focusout(function() {isbn()});
					
					$('#isbn').change(function() {
						// alert('Handler for .change() called.');
					});
					
					
					function isbn()
					{
						$('#load').show();
						$('#preload').hide();
							$.ajax({
								url: "isbn.php",
								data: "isbn="+$('#isbn').val(), // données ? transmettre
								success: function(xml)
								{
								   $(xml).find('BookData').each(
								   function()
								   {
										var isbn = $('#isbn').val();
										$('#isbn').removeClass('error');
										$('#isbn').addClass('text');
										
										var title = $(this).find('Title').text();
										$("#titre").val(title);
										$("#titre").removeClass('error');
										$("#titre").addClass('text');

										var author = $(this).find('Author').text();
										$("#auteur").val(author);
										$('#auteur').removeClass('error');
										$('#auteur').addClass('text');

										var annee = $(this).find('Year').text();
										$("#annee").val(annee);
										$('#annee').removeClass('error');
										$('#annee').addClass('text');										

										var publisher = $(this).find('Publisher').text();
										$("#collection").val(publisher);
										$('#collection').removeClass('error');
										$('#collection').addClass('text');
										
										var cover = $(this).find('Cover').text();
										$("#cover").val(cover);
										$('#cover').removeClass('error');
										$('#cover').addClass('text');
										
										var description = $(this).find('Description').text();
										$("#resume").val(description);
										$('#resume').removeClass('error');
										$('#resume').addClass('text');
										
										var titre = encodeURIComponent(title);
										
										var fnac = "<a href=\"http://recherche.fnac.com/Search/SearchResult.aspx?SCat=0%211&Search="+titre+"&sft=1&submitbtn=Ok\" target=\"_blank\" title=\"Consulter ce livre sur fnac.com\"><img class=\"ok\" src=\"img/fnac.jpg\" height=\"25\" width=\"25\" /></a><br /> <br /><br /><a href=\"http://books.google.fr/books?isbn="+isbn+"\" target=\"_blank\" title=\"Consulter ce livre sur Google Books\"><img class=\"ok\" src=\"img/books.jpg\" height=\"25\" width=\"25\" /></a><br />"
										
										$("#fnac").html(fnac);

										$('#load').hide();
										$('#preload').show();
									});
								}
							});
						return false;
					}
										
					// If the field is fill, delete the error class to inform the user its ok
					$('#isbn').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#titre').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#auteur').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#annee').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#collection').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#cover').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#resume').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#genre').change(function(e){ e.preventDefault(); $("#genre").removeClass('error'); });
					
	
					$("#ajout").submit(function(){
						// Check every data validity
						if( $("#isbn").val() == "" || $("#titre").val() == "" || $("#auteur").val() == "" || $("#annee").val() == "" || $("#collection").val() == "" || $("#cover").val() == "" || $("#resume").val() == "")
						{
							if( $("#isbn").val() == "" ){ $("#isbn").removeClass('text'); $("#isbn").addClass('error'); }
							if( $("#titre").val() == ""){ $("#titre").removeClass('text'); $("#titre").addClass('error');}
							if( $("#auteur").val() == ""){ $("#auteur").removeClass('text'); $("#auteur").addClass('error');}
							if( $("#annee").val() == ""){ $("#annee").removeClass('text'); $("#annee").addClass('error');}
							if( $("#collection").val() == ""){ $("#collection").removeClass('text'); $("#collection").addClass('error');}
							if( $("#cover").val() == ""){ $("#cover").removeClass('text'); $("#cover").addClass('error');}
							if( $("#resume").val() == ""){ $("#resume").addClass('error');}
							
							return false;
						}
						
						if( $("#genre").val() == 0 && note == false ){
							$("#genre").addClass('error');
							$("#note").addClass('error');
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
				
				<div class="success"><a href="admin.php">Administration</a> &rarr; Ajouter un livre</div>
				
				<form method="post" action="livre_base.php" id="ajout">
				
					<fieldset>
					
						<!-- Ne pas toucher !! -->
						<input type="hidden" name="type" id="type" value="1" />
					
						<legend>Ajouter un nouveau livre</legend>

						<table>

							<tr>
								 <td>
									  <label for="isbn">Numéro ISBN</label>
								 </td>
								 <td>
									  <input type="text" name="isbn" id="isbn" class="text" autocomplete="off" />
								 </td>
								 <td id="preload">
									  <img  class="ok" src="img/calculator_add.png" title="Cliquer pour télécharger les données" src="" />
								 </td>
								 <td id="load" style="display: none;">
									  <img src="img/arrow_refresh.png" title="Chargement en cours..." />
								 </td>
							</tr>

							<tr>
								 <td>
									  <label for="titre">Titre</label>
								 </td>
								 <td>
									  <input type="text" name="titre" id="titre" class="text" />
								 </td>
							</tr>

							<tr>
								 <td>
									  <label for="auteur">Nom de l'auteur</label>
								 </td>
								 <td>
									  <input type="text" name="auteur" id="auteur" class="text" />
								 </td>
							</tr>

							<tr>
								 <td>
									  <label for="annee">Année de parution</label>
								 </td>
								 <td>
									  <input type="text" name="annee" id="annee" class="text" />
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
									  <label for="cover">Cover</label>
								 </td>
								 <td>
									  <input type="text" name="cover" id="cover" class="text" />
								 </td>
							</tr>

							<tr>
								<td>
									<label for="genre">Genre</label>
								</td>
								<td>
								<?php
									$categories = Livre::getCategories($bdd);
									$key = array_keys($categories);
								?>
									<select name="genre" id="genre">
										<option value="0">-- Choisir --</option>
										<?php
											for($i=0;$i<count($categories);$i++){
												echo '<option value="'.$key[$i].'">';
												echo $categories[$key[$i]].'</option>';
											}
										?>
									</select>
								</td>
							</tr>

							<tr>
								 <td>
									  <label for="resume">Résumé de l'oeuvre</label>
								 </td>
								 <td>
									  <textarea name="resume" id="resume" rows="10" cols="70"></textarea>
								 </td>
								 <td id="fnac">
									
								 </td>
							</tr>

							<tr>
								 <td>
									  <label for="note">Note du livre</label>
								 </td>
								 <td id="note">
									  <ul class="notes-echelle">
										   <li>
										   <label for="note01" title="Note : 1 sur 5">1</label>
										   <input type="radio" name="note" id="note01" value="1" />
										   </li>
										   <li>
										   <label for="note02" title="Note : 2 sur 5">2</label>
										   <input type="radio" name="note" id="note02" value="2" />
										   </li>
										   <li>
										   <label for="note03" title="Note : 3 sur 5">3</label>
										   <input type="radio" name="note" id="note03" value="3" />
										   </li>
										   <li>
										   <label for="note04" title="Note : 4 sur 5">4</label>
										   <input type="radio" name="note" id="note04" value="4" />
										   </li>
										   <li>
										   <label for="note05" title="Note : 5 sur 5">5</label>
										   <input type="radio" name="note" id="note05" value="5" />
										   </li>
									  </ul>
								 </td>
							</tr>

						</table>
	
					</fieldset>

				   <div id="class"></div>

				   <input class="right" type="submit" name="envoi" id="envoi" value="Sauvegarder le livre" />

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
