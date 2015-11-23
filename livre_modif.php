<?php
	session_start();
	if(isset($_SESSION['id'])){
		include('include/config.php');
		if(!empty($_GET['id']) && Livre::isExist($bdd, $_GET['id'])){
			$book = new Livre($bdd);
			$book->get($_GET['id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">

	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" /> 
		<meta name="author" content="Thomas Diot" />
		<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="js/sticky.full.js"></script>
		<title><?php echo $site.' - '.$book->getTitle(); ?></title>
		
		<script type="text/javascript">
				$(document).ready(function() {

					$("ul.notes-echelle").addClass("js");
					$("ul.notes-echelle li").addClass("note-off");
					
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
						.click(function() {
							$(this).parents("ul.notes-echelle").find("li").removeClass("note-checked");
							$(this).parent("li").addClass("note-checked");
						});
						
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
					
					// If the field is fill, delete the error class to inform the user its ok
					$('#isbn').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#titre').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#auteur').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#annee').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#collection').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#cover').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#resume').keyup(function(e){ e.preventDefault(); $(this).removeClass('error'); $(this).addClass('text'); });
					$('#genre').change(function(e){ e.preventDefault(); $("#genre").removeClass('error'); });
					
					$("#modif").submit(function(){
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

				<form method="post" action="livre_base.php" id="modif">
					
					<!-- Ne pas toucher !! -->
					<input type="hidden" name="type" id="type" value="2" />
			
					<div class="success">
						<a href="admin.php">Administration</a> &rarr; <a href="livre_edit.php">Modifier un livre</a> &rarr; <?php echo $book->getTitle(); ?>
					</div>

					<fieldset>
						<legend>Ajouter un nouveau livre</legend>
						
						<table>
						
							<tr>
								<td>
									<label for="isbn">Numéro ISBN</label>
								</td>
								<td>
									<input type="text" name="isbn" id="isbn" class="text" value="<?php echo $book->getIsbn(); ?>" />
									<input type="hidden" name="id" id="id" class="text" value="<?php echo $book->getId(); ?>" />
								</td>
							</tr>
						
							<tr>
								<td>
									<label for="titre">Titre</label>
								</td>
								<td>
									<input type="text" name="titre" id="titre" class="text" value="<?php echo $book->getTitle(); ?>" />
								</td>
							</tr>
							
							<tr>
								<td>
									<label for="auteur">Nom de l'auteur</label>
								</td>
								<td>
									<input type="text" name="auteur" id="auteur" class="text" value="<?php echo $book->getAuthor(); ?>" />
								</td>
							</tr>
							
							<tr>
								<td>
									<label for="annee">Année de parution</label>
								</td>
								<td>
									<input type="text" name="annee" id="annee" class="text" value="<?php echo $book->getYear(); ?>" />
								</td>
							</tr>
							
							<tr>
								<td>
									<label for="collection">Collection</label>
								</td>
								<td>
									<input type="text" name="collection" id="collection" class="text" value="<?php echo $book->getCollection(); ?>" />
								</td>
							</tr>
							
							<tr>
								<td>
									<label for="cover">Cover</label>
								</td>
								<td>
									<input type="text" name="cover" id="cover" class="text" value="<?php echo $book->getCover(); ?>" />
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
												echo '<option value="'.$key[$i].'" ';
												if($book->getGenre() == $key[$i]){echo 'selected';}
												echo '>';
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
									<textarea name="resume" id="resume" rows="10" cols="70"><?php echo $book->getResume(); ?></textarea>
								</td>
							</tr>
							
							<tr>
								<td>
									<label for="note">Note du livre</label>
								</td>
								<td>
									<ul class="notes-echelle">
										<li>
											<label for="note01" title="Note : 1 sur 5">1</label>
											<input type="radio" name="note" id="note01" value="1" <?php if($book->getNote() == '1'){echo 'checked';} ?> />
										</li>
										<li>
											<label for="note02" title="Note : 2 sur 5">2</label>
											<input type="radio" name="note" id="note02" value="2" <?php if($book->getNote() == '2'){echo 'checked';} ?> />
										</li>
										<li>
											<label for="note03" title="Note : 3 sur 5">3</label>
											<input type="radio" name="note" id="note03" value="3" <?php if($book->getNote() == '3'){echo 'checked';} ?> />
										</li>
										<li>
											<label for="note04" title="Note : 4 sur 5">4</label>
											<input type="radio" name="note" id="note04" value="4" <?php if($book->getNote() == '4'){echo 'checked';} ?> />
										</li>
										<li>
											<label for="note05" title="Note : 5 sur 5">5</label>
											<input type="radio" name="note" id="note05" value="5" <?php if($book->getNote() == '5'){echo 'checked';} ?> />
										</li>
									</ul>
								</td>
							</tr>
							
						</table>
						
					</fieldset>
					
					<div id="class"></div>
				
					<input class="right" type="submit" name="envoi" value="Sauvegarder le livre" />
		
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
		header('Location: livre_edit.php?message=9');
	}
	
}
else{
	header('Location: index.php?message=3');
}
?>
