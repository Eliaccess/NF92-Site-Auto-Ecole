<!DOCTYPE html> 
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Inscription d'un élève à une séance</titres></br></br></br>

	<?php

		date_default_timezone_set('Europe/Paris');
		$date_actuelle = date("Ymd");

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); // Connexion à la DB
		$result = mysqli_query($connect,"SELECT * FROM eleves"); //On choisit tous les élèves
		$result2 = mysqli_query($connect,"SELECT * FROM seance"); // On choisit toutes les séances
		
		if(!$result)
		{
			echo "<br> Erreur :".mysqli_error($connect);
		}
		if(!$result2)
		{
			echo "<br> Erreur :".mysqli_error($connect);
		}
		else
		{
			//Formulaire pour choisir un élève et une séance
			echo "<table>";

			echo "<FORM METHOD='POST' ACTION='inscrire_eleve.php' >";
			echo "<tr><td>Choisissez l'élève :</td><td><select name='eleve' BORDER='1'>";

			while ($eleve = mysqli_fetch_array($result, MYSQL_NUM))
			{
				echo "<option value=".$eleve[0].">".$eleve[1]." ".$eleve[2]." ".$eleve[3]."</option>";
			}

			echo "</select></td></tr>";
			echo "<tr></tr>";
		
			echo "<tr><td>Choisissez la séance :</td><td><select name='seance' BORDER='1'>";

			while ($seance = mysqli_fetch_array($result2, MYSQL_NUM))
			{
						$id_theme = $seance[4];
						$theme_seance_query = mysqli_query($connect,"SELECT * FROM themes WHERE idtheme = $id_theme;"); //requête pour avoir les infos de la séance
						$theme_seance = mysqli_fetch_array($theme_seance_query, MYSQL_NUM);

						if ($theme_seance[2]==0 && (strtotime($seance[1]) >= strtotime($date_actuelle))) // On vérifie que la séance n'est pas passée
						{
							echo "<option value=".$seance[0].">".$theme_seance[1]." ".$seance[1]."</option>";
						}
			}

			echo "</select></td></tr>";

			echo "<tr><td><br><br><INPUT type='submit' value='Enregistrer inscription'></td></tr>";

			echo "</FORM>";

			echo "</table>";
		}

	?>

	
</body>
</html>
