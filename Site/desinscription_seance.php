<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Désinscrire un élève d'une séance</titres></br></br></br>
	
	<?php
		date_default_timezone_set('Europe/Paris');
		$date_actuelle = date("Ymd");

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); //requête de connexion à la db
		$result = mysqli_query($connect,"SELECT * FROM seance"); //on recherche tous les seances
		$result2 = mysqli_query($connect,"SELECT * FROM eleves"); //on recherche tous les eleves

		echo "<table>";

		echo "<FORM METHOD='POST' ACTION='desinscrire_seance.php'>";
		echo "<tr><td><subtitles>Choisissez une séance :<br></subtitles></td>";//On fait un formulaire pour choisir la seance
		echo "<td><select name='seance'>";

		while ($seance_afficher = mysqli_fetch_array($result, MYSQL_NUM))
		{
			$detail_theme_query = mysqli_query($connect,"SELECT * FROM themes WHERE idtheme = $seance_afficher[4]");
			$detail_theme = mysqli_fetch_array($detail_theme_query, MYSQL_NUM);

			if (strtotime($seance_afficher[1]) >= strtotime($date_actuelle))
			{
				echo "<option value=".$seance_afficher[0].">Séance de ".$detail_theme[1]." du ".$seance_afficher[1]."</option>";	
			}
		}

		echo "</select></td></tr>";

		echo "<tr><td><subtitles>Choisissez un élève :<br></subtitles></td>"; //De même on choisit l'élève
		echo "<td><select name='eleve'>";

		while ($eleve_afficher = mysqli_fetch_array($result2, MYSQL_NUM))
		{
			echo "<option value=".$eleve_afficher[0].">".$eleve_afficher[2]." ".$eleve_afficher[1]." né le ".$eleve_afficher[3]."</option>";	
		}
		echo "</select></td></tr>";
		echo "<tr><td><br><INPUT type='submit' value='Valider'></td></tr>";

		echo "</FORM>";

		echo "</table>";

		mysqli_close($connect);
	?>

	
</body>
</html>
