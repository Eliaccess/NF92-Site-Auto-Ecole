<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Noter les élèves</titres></br></br></br>

	<?php
		$seance_a_noter = $_POST['seance'];

		date_default_timezone_set('Europe/Paris');
		$date_actuelle = date("Ymd");

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); //connexion à la DB
		$result = mysqli_query($connection,"SELECT * FROM inscription WHERE idseance = $seance_a_noter"); // On sélectionne les lignes de la table inscription comportant la séance selectionnée

		//Formulaire pour noter les élèves inscrits à la séance

		echo "<table>";

		echo "<FORM METHOD='POST' ACTION='noter_eleves.php' >";
		echo "<tr><td><subtitles>Notez le nombre d'erreurs faites par chaque élève (champ vide = 0 fautes) :</td></tr><br>";

		while ($seances_notables = mysqli_fetch_array($result, MYSQL_NUM))
		{
			$id_dun_etu = $seances_notables[1];
			$nom_etudiant_query = mysqli_query($connection,"SELECT * FROM eleves WHERE idetu = $id_dun_etu"); // On selectionne les infos de l'élève
			$nom_etudiant = mysqli_fetch_array($nom_etudiant_query, MYSQL_NUM);

			echo "<br><tr><td>".$nom_etudiant[1]." : </td><td><input type='number' name=$nom_etudiant[0]></td></tr>";	
		}
		echo "<input type='hidden' name='sea' value=".$seance_a_noter.">";

		echo "<tr><td><INPUT type='submit' value='Valider'></td></tr>";

		echo "</FORM>";

		echo "</table>";

		mysqli_close($connection);
	?>

	
</body>
</html>
