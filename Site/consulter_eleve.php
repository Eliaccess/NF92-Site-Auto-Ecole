<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Consulter les notes de l'élève</titres></br></br></br>

	<?php
		$id_eleve = $_POST['eleve'];

		date_default_timezone_set('Europe/Paris');
		$date_actuelle = date("Ymd");

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');//connexion à la db

		$nom_etudiant_query = mysqli_query($connection,"SELECT * FROM eleves WHERE idetu = $id_eleve"); //requête pour afficher les infos de l'élève séléctionné
		$nom_etudiant = mysqli_fetch_array($nom_etudiant_query, MYSQL_NUM);
		echo "<subtitle>Récapitulatif des notes de ".$nom_etudiant[2]." ".$nom_etudiant[1]." né le ".$nom_etudiant[3]." :</subtitle><br><br>";

		echo "<table border='1'>";
		
		$result = mysqli_query($connection,"SELECT * FROM inscription WHERE ideleve = $id_eleve"); //requête pour sélectionner toutes les lignes de a table inscription où l'id de lélève apparait

		while ($recap = mysqli_fetch_array($result, MYSQL_NUM))
		{
			$detail_seance_query = mysqli_query($connection,"SELECT * FROM seance WHERE idseance = $recap[0]"); //requête pour selectionner les infos de la séance correspondant à l'idseance
			$detail_seance = $nom_etudiant = mysqli_fetch_array($detail_seance_query, MYSQL_NUM);

			$detail_theme_query = mysqli_query($connection,"SELECT * FROM themes WHERE idtheme = $detail_seance[4]");//requête pour obtenir le thème associé à la séance choisie
			$detail_theme = mysqli_fetch_array($detail_theme_query, MYSQL_NUM);

			if ($recap[2] <> 50) //Si la séance est notée (note qui vaut 50), on l'affiche dans le tableau
			{
				echo "<br><tr><td><b> Séance de ".$detail_theme[1]." le ".$detail_seance[1]." </b></td><td><b>".$recap[2]."</b></td></tr>";	
			}
		}

		echo "</table>";

		mysqli_close($connection);
	?>

	
</body>
</html>
