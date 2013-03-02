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
		<title><?php echo $site; ?> - Liste des livres</title>
		<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
		<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
		<script type="text/javascript" src="js/chili-1.8b.js"></script>
		<script type="text/javascript" src="js/docs.js"></script>
		<script type="text/javascript">
			$(function() {
				$("table")
					.tablesorter({widthFixed: true, widgets: ['zebra']})
					.tablesorterPager({container: $("#pager")});
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
				
				<div class="success"><a href="admin.php">Administration</a> &rarr; <a href="livre_enreg.php">Liste des livres enregistrés</a></div>
				
				<table cellspacing="1" class="tablesorter" id="tablesorter">
					<thead>
						<tr>
							<th>ID</th>
							<th>Titre</th>
							<th>Auteur</th>
							<th>Collection</th>
							<th>Année</th>
							<th>Note</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>ID</th>
							<th>Titre</th>
							<th>Auteur</th>
							<th>Collection</th>
							<th>Année</th>
							<th>Note</th>

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
									echo '<td>'.$array[$i]->getNote().'</td>';
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