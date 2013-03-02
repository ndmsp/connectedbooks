		<div class="right sidebar" id="sidebar">
		
			<div class="section">

				<div class="section-title">Lancer une recherche</div>

				<div class="section-content">
					<form method="post" action="recherche.php">
						<input type="text" name="recherche" id="recherche" class="text" size="28" /> &nbsp;
						<input type="submit" class="buttona" value="Go !" />
					</form>
				</div>

			</div>

			<div class="section">
			
				<div class="section-title">Entrées récentes</div>

				<div class="section-content">

					<ul class="nice-list">
						<?php
							$array = Livre::getListLast($bdd,$livres_recents);
							if(!empty($array[0])){
								for($i=0;$i<$livres_recents;$i++)
								{
									$date =  strtotime($array[$i]->getDate());
									echo '<li>';
										echo '<div class="left"><a href="livre.php?id='.$array[$i]->getId().'">'.$array[$i]->cutTitle(30).'</a></div>';
										echo '<div class="right">'.date('d', $date).' '.convertMonths($date).'</div>';
										echo '<div class="clearer">&nbsp;</div>';
									echo '</li>';
								}
							}
						?>
						<li><a href="catalogue.php" class="more">Consulter le catalogue &#187;</a></li>
					</ul>

				</div>

			</div>

			<div class="section">

				<div class="section-title">Nos livres préférés</div>

				<div class="section-content">

					<ul class="nice-list">
						<?php
							$array = Livre::getFavorite($bdd, $favorite_books);
							
							for($i=0;$i<count($array);$i++)
							{
								$book = new Livre($bdd);
								$book->get($array[$i]);
								echo '<li><a href="livre.php?id='.$book->getId().'">'.$book->cutTitle(40).'</a></li>';
							}
						?>
					</ul>
					
				</div>

			</div>

			<div class="section">

				<div class="section-title">Mots-clés</div>

				<div class="section-content">
					<div class="quiet">
						<?php
							$mots = array();
							$mot = array();
							$i = 0;
							$reponse = $bdd->query('SELECT * FROM mots_cles ORDER BY compte DESC LIMIT 0,15');
							
							while($donnees = $reponse->fetch()){
								$mot[$i] = $donnees['mot'];
								$i++;
							}
							
							$order = array(7,8,11,6,2,14,0,3,5,12,11,4,1,9,13);
							$size = array(120,120,150,120,90,80,220,100,110,150,140,100,90,120,200);
							
							for($i=0;$i<count($order);$i++){
								$key = $order[$i];
								if(isset($mot[$key]) && !empty($mot[$key])){
									echo '<a href="recherche.php?mot='.$mot[$key].'" style="font-size: '.$size[$key].'%">'.$mot[$key].'</a>&nbsp;&nbsp;'."\n";
								}
							}
						?>
					</div>
				</div>
			
			</div>
			
			<div class="clearer">&nbsp;</div>
		</div>
		
		<div class="clearer">&nbsp;</div>