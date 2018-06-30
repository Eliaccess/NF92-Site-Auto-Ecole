<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Supprimer un thème</titres></br></br></br>

	<?php
		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); //connexion à la DB
		$result = mysqli_query($connect,"SELECT * FROM themes WHERE supprime = 0");	// Requête pour obtenir les thèmes non supprimés

		//Formulaire pour afficher ces thèmes et en sélectionner un

		echo "<table>";

		echo "<FORM METHOD='POST' ACTION='supprimer_theme.php'>";
		echo "<tr><td><subtitles>Choix du thème :</subtitles></td><td><select name='theme' BORDER='1'>";

		while ($liste_themes = mysqli_fetch_array($result, MYSQL_NUM))
		{
			echo "<option value=".$liste_themes[0].">".$liste_themes[1]."</option>";
		}

		echo "<tr><td><br><INPUT type='submit' value='Valider'></td></tr>";

		echo "</FORM>";

		echo "</table>";

		mysqli_close($connect);
	?>	
</body>
</html>
