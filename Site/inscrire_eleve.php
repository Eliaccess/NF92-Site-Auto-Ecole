<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<subtitle>Confirmation de votre ajout :</subtitle></br></br></br>

	<?php
		$eleve=strtoupper($_POST['eleve']);
		$seance=strtoupper($_POST['seance']);

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$i = 0;

		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); // Connexion à la DB

		$verif_nombre_eleves_query = mysqli_query($connection,"SELECT * FROM inscription WHERE idseance = $seance");// requête pour avoir les lignes de la table inscription avec l'id de la séance choisie
		$verif_nombre_eleves = mysqli_fetch_array($verif_nombre_eleves_query, MYSQL_NUM);

		$verif_max_seance_query = mysqli_query($connection,"SELECT * FROM seance WHERE idseance = $seance"); //requête pour obtenir les infos de la séance choisie
		$verif_max_seance = mysqli_fetch_array($verif_max_seance_query, MYSQL_NUM);

		while ($verif_nombre_eleves = mysqli_fetch_array($verif_nombre_eleves_query, MYSQL_NUM))
		{
			$i = $i +1; // Compteur d'élèves participants à la séance
		}


		if(!$seance)
		{
			echo "Erreur : aucune séance n'a été sélectionnée / n'est disponible.</br>";
		}
		else
		{
			if ($verif_max_seance[3] <= $i) //On compare le nombre d'élèves déjà inscrits à l'effectif max
			{
				echo "Erreur : la séance est complète.</br>";
			}
			else
			{
				if (!$eleve)
				{
					echo "Erreur : aucun élève n'a été sélectionné / n'est disponible.</br>";
				}
				else
				{
					$deja_inscrit_query = mysqli_query($connection,"SELECT * FROM inscription WHERE idseance = $seance and ideleve = $eleve"); //On sélectionne la ligne de la table inscription qui lie l'élève à la séance pour voir si il est déjà inscrit
					$deja_inscrit = mysqli_fetch_array($deja_inscrit_query, MYSQL_NUM);

					if(!$deja_inscrit)
					{
						$query = "INSERT INTO inscription values ($seance, $eleve, 50);"; // Si il n'y est pas encore inscrit, on l'y inscrit via cette requête
						$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

						$result = mysqli_query($connection, $query);

						if(!$result) 
						{
							echo "<br> Erreur :".mysqli_error($connection);
						}

						$eleve_query = mysqli_query($connection,"SELECT * FROM eleves WHERE idetu = $eleve;"); //requête pour obtenir les informations de l'élève choisi
						$eleve_en_question = mysqli_fetch_array($eleve_query, MYSQL_NUM);

						$seance_query = mysqli_query($connection,"SELECT * FROM seance WHERE idseance = $seance;"); //requête pour obtenir les informations de la séance choisie
						$seance_en_question = mysqli_fetch_array($seance_query, MYSQL_NUM);

						$theme_seance_query = mysqli_query($connection,"SELECT * FROM themes WHERE idtheme = $seance_en_question[4];");//requête pour obtenir les infos du thème de cette séance
						$theme_seance_en_question = mysqli_fetch_array($theme_seance_query, MYSQL_NUM);

						//Affichage du récapitulatif

						echo "<corps>Monsieur / Madame </corps><subtitle>".$eleve_en_question[1]." ".$eleve_en_question[2]." </subtitle>";
						echo "<corps>a été ajouté à la séance du </corps><subtitle>".$seance_en_question[1]." </subtitle>";
						echo "<corps> de </corps><subtitle>".$theme_seance_en_question[1].".</subtitle>";

						mysqli_close($connection);
					}
					else
					{
						echo "Erreur : cet élève est déjà inscrit à cette séance.</br>";
					}
				}
			}
		}

	?>

	
</body>
</html>
