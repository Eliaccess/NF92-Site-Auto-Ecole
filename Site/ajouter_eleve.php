<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Inscription</titres></br></br>
	<?php
		date_default_timezone_set('Europe/Paris');
		$date = date("Y\-m\-d");

		$choix=strtoupper($_POST['choix']);
		$name=strtoupper($_POST['nom']);
		$surname=strtoupper($_POST['prenom']);
		$birthday=$_POST['naissance'];

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); //Connexion à la DB

		if($choix == '1' && strtotime($birthday) <= strtotime("- 15 years") && $name && $surname) // On vérifie que l'élève a plus de quinze ans et qu'il confirme son choix
		{
			$date_reform = date("Ymd", strtotime($birthday));
			$query = "INSERT INTO eleves values (NULL, '$name', '$surname', '$date_reform', '$date')"; //requête pour l'ajouter à la DB

			$result = mysqli_query($connect, $query);

			if(!$result)
				{
					echo "<br> Erreur :".mysqli_error($connect);
				}

			mysqli_close($connect);

			//$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

			//Affichage du récapitulatif

			echo "</br><subtitle>Récapitulatif de votre inscritption</subtitle></br></br></br>";
			echo "<subsubtitle>Nom : </subtitle><corps>".$name."</corps></br></br>";
			echo "<subsubtitle>Prénom : </subtitle><corps>".$surname."</corps></br></br>";
			echo "<subsubtitle>Date de naissance : </subtitle><corps>".$birthday."</corps></br></br>";	
			echo "<corps>Inscription faite le ".$date."</corps></br>";
		}

		elseif($choix == '0')
		{
			echo "<br><br><subtitle>Redirection vers l'accueil ...</subtitle><br><br><br>";
			echo "<META HTTP-EQUIV='refresh' CONTENT=5;URL='accueil.html'>";
		}

		if(strtotime($birthday) > strtotime("- 15 years"))
		{
			echo "Erreur : vous devez être âgé d'au moins 15 ans pour vous inscrire. </br>";
		}

		if(!$name)
		{
			echo "Erreur : vous devez spécifier un nom pour vous inscrire. </br>";
		}
		if(!$surname)
		{
			echo "Erreur : vous devez spécifier un nom pour vous inscrire. </br>";
		}	
	?>
</body>
</html>
