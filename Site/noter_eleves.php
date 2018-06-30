<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Noter les élèves</titres></br></br>
	<subtitle>Confirmation de votre ajout :</subtitle></br></br>
	<?php
		date_default_timezone_set('Europe/Paris');
		$date_actuelle = date("Ymd");

		$seance = $_POST['sea'];

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass


		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); //Connexion à la DB
		$id_etu_search = mysqli_query($connection,"SELECT * FROM inscription WHERE idseance = $seance"); //Requête pour obtenir les lignes de la table inscription où cette séance apparaît

		while ($id_etu = mysqli_fetch_array($id_etu_search, MYSQL_NUM))
		{
			$etu = $id_etu[1];
			$erreur = $_POST[$etu];
			$note = 40 - $erreur;

			if ($erreur <= 40 && $erreur >= 0) // On vérifie que la note est comprise entre 0 et 40
			{
				$changer_note = mysqli_query($connection,"UPDATE `inscription` SET note_eleve = $note WHERE ideleve = $id_etu[1] and idseance = $seance;"); // On entre la note si c'est le cas
				if(!$changer_note)
				{
					echo "<br> Erreur :".mysqli_error($connect);
				}
			}
			else
				echo "Vous avez spécifié un nombre d'erreurs supérieur à 40 ou inférieur à 0. Les notes de ces élèves ne seront pas changées."; // Sinon on ne rentre rien
		}

		echo "<table>";

		$confirmation = mysqli_query($connection,"SELECT * FROM inscription WHERE idseance = $seance"); //Pour confirmer que tout a été mis à jour, on redemande les infos de la séance modifiée

		while ($confirmer = mysqli_fetch_array($confirmation, MYSQL_NUM))
		{
			$id_dun_etu = $confirmer[1];
			$nom_etudiant_query = mysqli_query($connection,"SELECT * FROM eleves WHERE idetu = $id_dun_etu"); //requête pour obtenir les infos des élèves inscrits à cette séance
			$nom_etudiant = mysqli_fetch_array($nom_etudiant_query, MYSQL_NUM);

			if ($confirmer[2] == 50) //Si on ne rentre pas de note, alors sa note est restée à 50. On considère qu'il n'est pas noté
			{
				echo "<br><tr><td>".$nom_etudiant[1]." ".$nom_etudiant[2]." : </td><td>Non noté</td></tr>";
			}
			else //Si la note a changé, on récapitule
			{
				echo "<br><tr><td>".$nom_etudiant[1]." ".$nom_etudiant[2]." : </td><td>".$confirmer[2]." points sur 40</td></tr>";
			}
		}

		echo "</table>";
		mysqli_close($connection);
	?>

	
</body>
</html>
