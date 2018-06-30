<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<subtitle>Confirmation de votre ajout :</subtitle></br></br></br>

	<?php
		$date_a_reformer=$_POST['date'];
		$idtheme=$_POST['theme'];
		$effmin=$_POST['min'];
		$effmax=$_POST['max'];

		date_default_timezone_set('Europe/Paris');
		$date_actuelle = date("Ymd");

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$date = date("Ymd", strtotime($date_a_reformer));

		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); //Connexion à la DB

		if(strtotime($date) >= strtotime($date_actuelle))
		{
			$requete_verif_doublon = mysqli_query($connect,"SELECT * FROM seance WHERE idtheme = ".$idtheme." and DateSeance = '".$date."';");
			$test_doublon_seance = mysqli_fetch_array($requete_verif_doublon, MYSQL_NUM);

			if(!$test_doublon_seance)
			{
				if ($effmin > 0 && $effmax > 0)
				{
					if ($effmin > $effmax)
					{
						$query = "INSERT INTO seance values (NULL, '$date', $effmax, $effmin,'$idtheme');"; // Insertion des informations si effmin > effmax
					}
					else
					{
						$query = "INSERT INTO seance values (NULL, '$date', $effmin, $effmax,'$idtheme');"; // Insertion des informations si effmin < effmax
					}

					$select_theme = mysqli_query($connect,"SELECT * FROM themes WHERE idtheme = ".$idtheme.";"); // Selection des thèmes avec l'ID thème de la séance pour l'affichage du récapitulatif
					$row = mysqli_fetch_array($select_theme, MYSQL_NUM);

					$result = mysqli_query($connect, $query);

					if(!$result)
						{
							echo "<br> Erreur :".mysqli_error($connect);
						}

					//Récapitulatif de l'ajout

					echo "<subsubtitle>Date de la séance : </subtitle><corps>".$date."</corps></br></br>";
					echo "<subsubtitle>Thème de la séance : </subtitle><corps>".$row[1]."</corps></br></br>";

					if ($effmin > $effmax)
					{
						echo "<subsubtitle>Effectif minimum : </subtitle><corps>".$effmax."</corps></br></br>";
						echo "<subsubtitle>Effectif maximum : </subtitle><corps>".$effmin."</corps></br></br>";
					}
					else
					{
						echo "<subsubtitle>Effectif minimum : </subtitle><corps>".$effmin."</corps></br></br>";
						echo "<subsubtitle>Effectif maximum : </subtitle><corps>".$effmax."</corps></br></br>";
					}	

					mysqli_close($connect);
				}
				else
				{
					echo "Erreur : veuillez sélectionner des effectifs positifs.</br>";
				}

				
			}
			else
				{
					echo "Erreur : une séance est déjà programmée à cette date pour ce thème.</br>";
				}
		}
		else
		{
			echo "Erreur : la date sélectionnée est passée.</br>";
		}
		

	?>

	
</body>
</html>
