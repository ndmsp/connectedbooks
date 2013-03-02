<?php	
	require_once('../include/connexion.php');
	try{$bdd = new PDO('mysql:host='.$hote.';dbname='.$base.'', ''.$user.'', ''.$pass.'');}
	catch(Exception $e){die('Erreur : ' . $e->getMessage());}
	
	$admin = "CREATE TABLE IF NOT EXISTS `isbn_admin` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `login` varchar(255) NOT NULL,
		  `mdp` varchar(255) NOT NULL,
		  `email` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	
	$categories = "CREATE TABLE IF NOT EXISTS `categories` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `titre` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;";


	$cat =	"INSERT INTO `categories` (`id`, `titre`) VALUES
		(1, 'Scolaire'),
		(2, 'Aventure'),
		(3, 'Policier'),
		(4, 'Historique'),
		(5, 'Drame'),
		(6, 'Jeunesse'),
		(7, 'Religion'),
		(8, 'Fantaisy'),
		(9, 'Romance'),
		(10, 'Science fiction'),
		(11, 'BD'),
		(12, 'Autre');";
		
	$favorite_books = "CREATE TABLE IF NOT EXISTS `favorite_books` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `id_livre` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;";
		
	$livres = "CREATE TABLE IF NOT EXISTS `livres` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(255) NOT NULL,
		  `author` varchar(255) NOT NULL,
		  `genre` int(11) NOT NULL,
		  `year` varchar(255) NOT NULL,
		  `resume` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
		  `cover` varchar(255) NOT NULL,
		  `note` int(11) NOT NULL,
		  `collection` varchar(255) NOT NULL,
		  `isbn` varchar(255) NOT NULL,
		  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;";
	
	$mots_cles = "CREATE TABLE IF NOT EXISTS `mots_cles` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `mot` varchar(255) NOT NULL,
		  `compte` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;";
	
	$preferences = "CREATE TABLE IF NOT EXISTS `preferences` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `value` text NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;";
	
	$prefe = "INSERT INTO `preferences` (`id`, `value`) VALUES
		(1, '<p style=\"font-size: 10px; margin: 10px; color: rgb(126, 117, 75); font-family: Verdana, Arial, Helvetica, sans-serif; \">\r\n	Erat autem diritatis eius hoc quoque indicium nec obscurum nec latens, quod ludicris cruentis delectabatur et in circo sex vel septem aliquotiens vetitis certaminibus pugilum vicissim se concidentium perfusorumque sanguine specie ut lucratus ingentia laetabatur.</p>\r\n<p style=\"font-size: 10px; margin: 10px; color: rgb(126, 117, 75); font-family: Verdana, Arial, Helvetica, sans-serif; \">\r\n	Utque proeliorum periti rectores primo catervas densas opponunt et fortes, deinde leves armaturas, post iaculatores ultimasque subsidiales acies, si fors adegerit, iuvaturas, ita praepositis urbanae familiae suspensae digerentibus sollicite, quos insignes faciunt virgae dexteris aptatae velut tessera data castrensi iuxta vehiculi frontem omne textrinum incedit: huic atratum coquinae iungitur ministerium, dein totum promiscue servitium cum otiosis plebeiis de vicinitate coniunctis: postrema multitudo spadonum a senibus in pueros desinens, obluridi distortaque lineamentorum conpage deformes, ut quaqua incesserit quisquam cernens mutilorum hominum agmina detestetur memoriam Samiramidis reginae illius veteris, quae teneros mares castravit omnium prima velut vim iniectans naturae, eandemque ab instituto cursu retorquens, quae inter ipsa oriundi crepundia per primigenios seminis fontes tacita quodam modo lege vias propagandae posteritatis ostendit.</p>\r\n<p style=\"font-size: 10px; margin: 10px; color: rgb(126, 117, 75); font-family: Verdana, Arial, Helvetica, sans-serif; \">\r\n	Nec minus feminae quoque calamitatum participes fuere similium. nam ex hoc quoque sexu peremptae sunt originis altae conplures, adulteriorum flagitiis obnoxiae vel stuprorum. inter quas notiores fuere Claritas et Flaviana, quarum altera cum duceretur ad mortem, indumento, quo vestita erat, abrepto, ne velemen quidem secreto membrorum sufficiens retinere permissa est. ideoque carnifex nefas admisisse convictus inmane, vivus exustus est.</p>\r\n<p style=\"font-size: 10px; margin: 10px; color: rgb(126, 117, 75); font-family: Verdana, Arial, Helvetica, sans-serif; \">\r\n	In his tractibus navigerum nusquam visitur flumen sed in locis plurimis aquae suapte natura calentes emergunt ad usus aptae multiplicium medelarum. verum has quoque regiones pari sorte Pompeius Iudaeis domitis et Hierosolymis captis in provinciae speciem delata iuris dictione formavit.</p>\r\n<p style=\"font-size: 10px; margin: 10px; color: rgb(126, 117, 75); font-family: Verdana, Arial, Helvetica, sans-serif; \">\r\n	Principium autem unde latius se funditabat, emersit ex negotio tali. Chilo ex vicario et coniux eius Maxima nomine, questi apud Olybrium ea tempestate urbi praefectum, vitamque suam venenis petitam adseverantes inpetrarunt ut hi, quos suspectati sunt, ilico rapti conpingerentur in vincula, organarius Sericus et Asbolius palaestrita et aruspex Campensis.</p>\r\n'),
		(2, 'ConnectedBooks'),
		(3, '5'),
		(4, '5'),
		(5, '29'),
		(6, '5');";
		
	$q = $bdd->exec($admin);
	$q = $bdd->exec($categories);
	$q = $bdd->exec($cat);
	$q = $bdd->exec($favorite_books);
	$q = $bdd->exec($livres);
	$q = $bdd->exec($mots_cles);
	$q = $bdd->exec($preferences);
	$q = $bdd->exec($prefe);
	
	header('Location: etape3.php');
?>