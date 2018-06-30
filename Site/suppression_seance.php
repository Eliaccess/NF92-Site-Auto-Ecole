<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Supprimer une séance</titres></br></br></br>
	
	<?php
		date_default_timezone_set('Europe/Paris');
		$date_actuelle = date("Ymd");

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); //connexion à la DB
		$result = mysqli_query($connect,"SELECT * FROM seance"); //requête pour sélectionner toutes les séances

		echo "<table>";

		echo "<FORM METHOD='POST' ACTION='supprimer_seance.php'>";
		echo "<tr><td><subtitles>Choix de la séance :</subtitles></td><td><select name='seance'>";

		while ($liste_seances = mysqli_fetch_array($result, MYSQL_NUM))
		{
			if (strtotime($liste_seances[1]) >= strtotime($date_actuelle)) // Si la séance est passé, on ne peut pas la supprimer
			{
				$detail_theme_query = mysqli_query($connect,"SELECT * FROM themes WHERE idtheme = $liste_seances[4]"); //requête pour séléctionner les thèmes de ces séances
				$detail_theme = mysqli_fetch_array($detail_theme_query, MYSQL_NUM);

				echo "<option value=".$liste_seances[0].">Séance ".$detail_theme[1]." du ".$liste_seances[1]."</option>";
			}
		}

		echo "<tr><td><br><INPUT type='submit' value='Valider'></td></tr>";

		echo "</FORM>";

		echo "</table>";

		mysqli_close($connect);
	?>

	
</body>
</html>
