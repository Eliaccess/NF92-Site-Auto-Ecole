<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<subtitle>Confirmation de votre ajout :</subtitle></br></br></br>

	<?php

		$theme=strtoupper($_POST['theme']);
		$desc=strtoupper($_POST['desc']);

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); // Connexion à la DB

		$verif_doublon_theme_nom_query = "SELECT * FROM themes WHERE nom = '$theme'"; //Requête pour vérifier si le thème avait déjà été créé puis supprimé auparavant
		$verif_doublon_theme_nom_envoi = mysqli_query($connect, $verif_doublon_theme_nom_query);
		$verif_doublon_theme_nom = mysqli_fetch_array($verif_doublon_theme_nom_envoi, MYSQL_NUM);

		if ($theme)
		{	
			if ($verif_doublon_theme_nom)
			{
				$query1 = "UPDATE themes SET supprime = 0 WHERE nom = '$theme'"; // On réactive le thème si il existait déjà 
				$result1 = mysqli_query($connect, $query1);

				$query2 = "SELECT * FROM themes WHERE nom = '$theme'"; // On prépare l'affichage avec le nom du thème donné dans la DB
				$result2 = mysqli_query($connect, $query2);


				$description = mysqli_fetch_array($result2, MYSQL_NUM);

				if(!$result1)
				{
					echo "<br> Erreur :".mysqli_error($connect);
				}

				//Affichage du récapitulatif

				echo "<subsubtitle>Thème réactivé : </subtitle><corps>".$description[1]."</corps></br></br>";
				echo "<subsubtitle>Description : </subtitle><corps> ".$description[3]." </corps></br></br>";

				mysqli_close($connect);
			}

			elseif (!$verif_doublon_theme_nom && $desc)
			{
				$query = 'INSERT INTO themes values (NULL, "'.$theme.'", 0, "'.$desc.'");'; // Requête pour ajouter le thème si il n'éxistait pas auparavant

				$result = mysqli_query($connect, $query);

				if(!$result)
				{
					echo "<br> Erreur :".mysqli_error($connect);
				}

				mysqli_close($connect);
				
				//Affichage du récapitulatif

				echo "<subsubtitle>Thème ajouté : </subtitle><corps>".$theme."</corps></br></br>";
				echo "<subsubtitle>Description : </subtitle><corps>".$desc."</corps></br></br>";
				
			}
			else
			{
				echo "Erreur : aucune description n'a été spécifiée.</br>";
			}
		}
		else
		{
			echo "Erreur : aucun nom de thème n'a été spécifiée.</br>";
		}
	?>

	
</body>
</html>
