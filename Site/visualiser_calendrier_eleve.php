<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Consulter le calendrier d'un élève</titres></br></br></br>

	<?php
		$id_eleve = $_POST['eleve'];

		date_default_timezone_set('Europe/Paris');
		$date_actuelle = date("Ymd");

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); //Connexion à la DB

		$nom_etudiant_query = mysqli_query($connection,"SELECT * FROM eleves WHERE idetu = $id_eleve"); //requête pour afficher les infos de l'élève séléctionné
		$nom_etudiant = mysqli_fetch_array($nom_etudiant_query, MYSQL_NUM);

		//Affichage du calendrier

		echo "<subtitle>Voici le calendrier de ".$nom_etudiant[2]." ".$nom_etudiant[1]." né le ".$nom_etudiant[3]." :</subtitle><br><br>";
		echo "<table border='1'>";
		echo "<br><tr><td><b>Date</b></td><td><b>Thème</b></td></tr>";	

		
		$result = mysqli_query($connection,"SELECT * FROM inscription WHERE ideleve = $id_eleve"); //requête pour obtenir les lignes de la table inscription où l'élève est inscrit

		while ($recap = mysqli_fetch_array($result, MYSQL_NUM))
		{
			$detail_seance_query = mysqli_query($connection,"SELECT * FROM seance WHERE idseance = $recap[0]"); // requête pour obtenir les infos de la séance 
			$detail_seance = $nom_etudiant = mysqli_fetch_array($detail_seance_query, MYSQL_NUM);

			$detail_theme_query = mysqli_query($connection,"SELECT * FROM themes WHERE idtheme = $detail_seance[4]"); //requête pour obtenir les infos du thème de la séance
			$detail_theme = mysqli_fetch_array($detail_theme_query, MYSQL_NUM);

			if (strtotime($detail_seance[1]) >= strtotime($date_actuelle)) // On vérifie que la séance à afficher est dans les futur
			{
				echo "<br><tr><td><b>".$detail_seance[1]."</b></td><td><b>".$detail_theme[1]."</b></td></tr>";	
			}
		}

		echo "</table>";

		mysqli_close($connection);
	?>

	
</body>
</html>
