<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
		Installation de ConnectedBooks
	</title>
	<link rel="stylesheet" type="text/css" href="style.css" media="all" />
</head>

<body>

	
	<div id="Header">
		Installation de ConnectedBooks : Etape 3
	</div>
	
	<br />
	
	<div id="Content">
	
		<h1>Configuration du logiciel</h1>
		
		<p>&nbsp;</p>
		
		<p>Les tables de données ont été importées avec succès ! Nous voici désormais à la dernière étape, celle de la configuration finale du logiciel. Je vais simplement vous expliquer les manipulations de base pour le logiciel, avant de vous proposer de créer votre compte administrateur.</p>
		
		<p>&nbsp;</p>
		
		<p>Ajouter un livre avec ConnectedBooks est une action très simple: dans la page d'administration (dont le lien figure en bas de chaque page), rendez-vous dans la section ajouter un livre. Il suffit ensuite de faire deux choses: entrer le numéro ISBN dans la première case, et cliquer sur l'image de droite. Les données se chargent ensuite seules, il ne vous reste plus qu'à remplir les derniers champs !</p>
		
		<p>&nbsp;</p>
		
		<p><img src="schema.jpg" /></p>
		
		<p>&nbsp;</p>
		
		<p>Maintenant que vous connaissez les opération de base, nous allons créer votre compte qui vous permettra de gérer votre nouveau site. Je vais vous laisser pour cela vous laisser remplir les trois champs ci dessous. L'adresse mail que vous allez indiquer restera strictement confidentielle, et ne sortira jamais de votre base de données. En revanche, sa véracité sera cruciale pour une utilisation correcte de l'application... Sans plus attendre, voici le formulaire:</p>
		
		
		<p>&nbsp;</p>
		
		
		<div id="stylized" class="myform">
			<form id="form" name="form" method="post" action="config.php">
			<h1>Inscription</h1>
			<p>Afin d'achever l'installation de votre application, merci de remplir  ce dernier formulaire:</p>

			<label>Login
			<span class="small">Votre nom d'utilisateur</span>
			</label>
			<input type="text" name="login" id="login" />
			
			<label>Mot de passe
			<span class="small">Mot de passe associé</span>
			</label>
			<input type="password" name="pass" id="pass" />

			<label>Email
			<span class="small">Une email valide !</span>
			</label>
			<input type="text" name="email" id="email" />

			<button type="submit">Terminer !!</button>
			<div class="spacer"></div>

			</form>
		</div>
		
	</div>

	
</body>
</html>