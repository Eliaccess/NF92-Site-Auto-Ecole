<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Supprimer une séance</titres></br></br></br>
	
	<?php

		$id_seance=strtoupper($_POST['seance']);

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); //Connexion à la DB
		$result = mysqli_query($connect,"DELETE FROM `seance` WHERE idseance = $id_seance"); // On supprime la séance dans la table seance
		$result2 = mysqli_query($connect,"DELETE FROM `inscription` WHERE idseance = $id_seance"); // On supprime la seance dans la table inscription

		echo "<subtitle>Confirmation de la suppression de la séance ... Les élèves qui devaient la suivre seront automatiquement désinscrits ...</subtitle></br></br></br>";

		echo "<corps>Retour automatique vers l'accueil ... <corps>";
		echo "<META HTTP-EQUIV='refresh' CONTENT=5;URL='accueil.html'>";
	?>

	
</body>
</html>
