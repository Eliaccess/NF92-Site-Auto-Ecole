<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Noter les élèves</titres></br></br></br>

	<?php
		date_default_timezone_set('Europe/Paris');
		$date_actuelle = date("Ymd");

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); // Connexion à la DB
		$result = mysqli_query($connection,"SELECT * FROM seance");	 //On selectionne toutes les séances

		//Formulaire pour choisir une séance à valider

		echo "<table>";

		echo "<FORM METHOD='POST' ACTION='valider_seance.php' >";
		echo "<tr><td><subtitles>Sélectionnez une séance</subtitles></td><td><select name='seance' BORDER='1'>";

		while ($seances_notables = mysqli_fetch_array($result, MYSQL_NUM))
		{
			if (strtotime($seances_notables[1]) <= strtotime($date_actuelle)) // Si elle est passée, on l'affiche dans le formulaire
			{
				$id_theme = $seances_notables[4];
				$theme_seance_query = mysqli_query($connection,"SELECT * FROM themes WHERE idtheme = $id_theme;"); //requête pour obtenir les infos du thème de la séance
				$theme_seance = mysqli_fetch_array($theme_seance_query, MYSQL_NUM);

				echo "<option value=".$seances_notables[0]."> Séance de ".$theme_seance[1]." du ".$seances_notables[1]."</option>";
			}
		}

		echo "<tr><td><br><INPUT type='submit' value='Valider'></td></tr>";

		echo "</FORM>";

		echo "</table>";

		mysqli_close($connection);
	?>

	
</body>
</html>
