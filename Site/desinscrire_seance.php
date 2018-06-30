<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Supprimer une séance</titres></br></br></br>
	
	<?php

		$id_eleve=strtoupper($_POST['eleve']);
		$id_seance=strtoupper($_POST['seance']);

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');//Connexion à la DB

		$detail_insc_query = mysqli_query($connect,"SELECT * FROM inscription WHERE ideleve = $id_eleve and idseance = $id_seance"); //requête pour obtenir la ligne correspondant à l'élève et la séance choisie
		$detail_insc = mysqli_fetch_array($detail_insc_query, MYSQL_NUM);

		$detail_eleve_query = mysqli_query($connect,"SELECT * FROM eleves WHERE idetu = $id_eleve"); //Requête pour avoir les infos de l'élève choisi
		$detail_eleve = mysqli_fetch_array($detail_eleve_query, MYSQL_NUM);
		
		$detail_seance_query = mysqli_query($connect,"SELECT * FROM seance WHERE idseance = $id_seance"); //Requête pour avoir les infos de la séance choisie
		$detail_seance = mysqli_fetch_array($detail_seance_query, MYSQL_NUM);

		$detail_theme_query = mysqli_query($connect,"SELECT * FROM themes WHERE idtheme = $detail_seance[4]");//Requête pour avoir le thème de la séance choisie
		$detail_theme = mysqli_fetch_array($detail_theme_query, MYSQL_NUM);

		if ($detail_insc[1]<>0){
		$result = mysqli_query($connect,"DELETE FROM `inscription` WHERE idseance = $id_seance and ideleve = $id_eleve"); // Si l'élève est bien inscrit à la séance on le désinscrit

		//Affichage du récapitulatif

		echo "<subtitle>Confirmation de la désinscription de $detail_eleve[2] $detail_eleve[1] de la séance de $detail_theme[1] du $detail_seance[1].</subtitle></br></br></br>";

		echo "<corps>Retour automatique vers l'accueil ... <corps>";
		echo "<META HTTP-EQUIV='refresh' CONTENT=5;URL='accueil.html'>";
		}
		else
		{
			echo "<subtitle>L'élève $detail_eleve[2] $detail_eleve[1] n'est pas inscrit dans la séance de $detail_theme[1] du $detail_seance[1].</subtitle></br></br></br>";
		}
	?>

		

	
</body>
</html>
