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
		<?php require_once('include/config.php'); ?>
		<title><?php echo $site; ?> - Livre favoris</title>
		<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
		<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
		<script type="text/javascript" src="js/chili-1.8b.js"></script>
		<script type="text/javascript" src="js/docs.js"></script>
		<script type="text/javascript">
			$(function() {
				<?php
					$array = Livre::getList($bdd);
					for($i=0;$i<count($array);$i++)
					{
						echo '$("#livre'.$array[$i]->getId().'").click(function () {
							$.ajax({
								url: "livre_base.php",
								data: "type=6&id='.$array[$i]->getId().'",
								success: function(xml)
								{
									$(xml).find("BookData").each(
									function()
									{
										var id = $(this).find("ID").text();
										var title = $(this).find("Title").text();
										var author = $(this).find("Author").text();
										
										var txt = \' <div class="book" id="book\' + id + \' "> \' + title + \' de \' + author +
											\' </div> \';
										
										$("#favorite").append(txt);
										
									});
								}
							});
						});'."\n";
					}
					
					$q = $bdd->query('SELECT * FROM favorite_books');
					$array = $q->fetchAll();
					foreach($array as $value)
					{
						$key = $value['id'];
						$id = $value['id_livre'];
						$value = new Livre($bdd);
						$value->get($key);
						echo '$("#book'.$key.' .right").click(function () {
							$.ajax({
								url: "livre_base.php",
								data: "type=7&id='.$key.'",
								success: function(xml)
								{
									$("#book'.$key.'").slideUp();
								}
							});
						});'."\n";
					}
					
				?>
			});
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
				
				<div class="success"><a href="admin.php">Administration</a> &rarr; <a href="livre_enreg.php">Liste des livres favoris</a></div>
				
				<p>&nbsp;</p>
				<p>Merci de choisir les livres qui seront affichés sur la barre de doite (Nos livres préférés). Lorsque vous cliquez sur la croix verte, le livre s'ajoute en bas de la page.</p>
				<p>&nbsp;</p>
				
				<table cellspacing="1" class="tablesorter" id="tablesorter">
					<thead>
						<tr>
							<th>ID</th>
							<th>Titre</th>
							<th>Auteur</th>
							<th>Collection</th>
							<th>Année</th>
							<th style="text-align:center">This one !</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>ID</th>
							<th>Titre</th>
							<th>Auteur</th>
							<th>Collection</th>
							<th>Année</th>
							<th style="text-align:center">This one !</th>

						</tr>
					</tfoot>
					<tbody>
						<?php
							$array = Livre::getList($bdd);
							for($i=0;$i<count($array);$i++)
							{
								echo '<tr>';
									echo '<td>'.$array[$i]->getId().'</td>';
									echo '<td>'.$array[$i]->getTitle().'</td>';
									echo '<td>'.$array[$i]->getAuthor().'</td>';
									echo '<td>'.$array[$i]->getCollection().'</td>';
									echo '<td>'.$array[$i]->getYear().'</td>';
									
									echo '<td>
										<p id="livre'.$array[$i]->getId().'">
											<img src="img/add.png" />
										</p>';
									echo '</td>';
								echo '</tr>';
							}
						?>
					</tbody>
				</table>
		
				<div id="pager" class="pager">
					<form>
						<img src="img/first.png" class="first"/>
						<img src="img/prev.png" class="prev"/>
						<input type="text" class="pagedisplay"/>
						<img src="img/next.png" class="next"/>
						<img src="img/last.png" class="last"/>
						<select class="pagesize">
							<option selected="selected"  value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option  value="40">40</option>
						</select>
					</form>
				</div>
				
				
				<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
				
				<div id="favorite">
					<?php
						$q = $bdd->query('SELECT * FROM favorite_books');
						$array = $q->fetchAll();
						foreach($array as $value){
							$key = $value['id'];
							$id = $value['id_livre'];
							$value = new Livre($bdd);
							$value->get($id);
					?>
							<div class="book" id="book<?php echo $key; ?>">
								<?php echo $value->getTitle().' de '.$value->getAuthor(); ?>
								<div class="right">
									<img src="img/cancel.png" />
								</div>
							</div>
					<?php
						}
					?>
				</div>

				
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
		header('Location: index.php?message=3');
	}
?>