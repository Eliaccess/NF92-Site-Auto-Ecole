<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Supprimer un thème</titres></br></br></br>
	
	<?php

		$theme=strtoupper($_POST['theme']);

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); //Connexion à la DB
		$result = mysqli_query($connect,"UPDATE themes SET supprime = 1 WHERE idtheme = $theme"); // On supprime le thème selectionné (désactivation en passant supprime à 1)

		echo "<subtitle>Confirmation de la suppression du thème</subtitle></br></br></br>";

		echo "<corps>Retour automatique vers l'accueil ... <corps>";
		echo "<META HTTP-EQUIV='refresh' CONTENT=5;URL='accueil.html'>";
	?>

	
</body>
</html>
