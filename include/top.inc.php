		<div id="top">

			<div class="left" id="logo">
				<a href="index.php"><img src="img/logo.png" alt="" width="235" height="80" /></a>
			</div>

			<div class="left navigation" id="main-nav">

				<ul class="tabbed">
					<?php
						$fichier = $_SERVER['PHP_SELF'];
						if(preg_match("#index#",$fichier)){
							echo '<li class="current-tab"><a href="index.php">Accueil</a></li>';
						}
						else{
							echo '<li><a href="index.php">Accueil</a></li>';
						}
						
						
						if(preg_match("#catalogue|consulter#", $fichier)){
							echo '<li class="current-tab"><a href="catalogue.php">Catalogue</a></li>';
						}
						else{
							echo '<li><a href="catalogue.php">Catalogue</a></li>';
						}
						
						
						if(preg_match("#recherche#", $fichier)){
							echo '<li class="current-tab"><a href="recherche.php">Recherche</a></li>';
						}
						else{
							echo '<li><a href="recherche.php">Recherche</a></li>';
						}
						
						
						if(preg_match("#propos#", $fichier)){
							echo '<li class="current-tab"><a href="propos.php">A propos de</a></li>';
						}
						else{
							echo '<li><a href="propos.php">A propos de</a></li>';
						}
					?>
				</ul>

				<div class="clearer">&nbsp;</div>

			</div>

			<div class="clearer">&nbsp;</div>

		</div>