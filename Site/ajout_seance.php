<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
	<script>
  	$( function() {
    		$( "#datepicker" ).datepicker();
  	} );
	</script>
</head>
<body>

<?php
		date_default_timezone_set('Europe/Paris');
		$date = date("d\/m\/Y");
		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connect   =   mysqli_connect($dbhost,   $dbuser,   $dbpass,   $dbname)   or   die   ('Error   connecting   to mysql'); // Connexion à la DB

		$result = mysqli_query($connect,"SELECT * FROM themes WHERE supprime=0"); // requête pour obtenir les thèmes actifs

		echo "<titres>Ajout de séances</titres></br></br></br>";

		echo "<table>";

		echo "<FORM METHOD='POST' ACTION='ajouter_seance.php' >";
		echo "<tr><td>Choisissez le thème</td><td><select name='theme' BORDER='1'>";

		while ($row = mysqli_fetch_array($result, MYSQL_NUM))
		{
			$theme_seance_query = mysqli_query($connect,"SELECT * FROM themes WHERE idtheme = $row[1];"); // requête pour obtenir les infos des thèmes actifs
			$theme_seance = mysqli_fetch_array($theme_seance_query, MYSQL_NUM);

			if ($theme_seance[2]==0)
			{
				echo "<option value=".$row[0].">".$row[1]."</option>";
			}
		}

		//Suite du formulaire, pour sélectionner l'effectif min et max, ainsi que la date de la séance

		echo "</select></td></tr>";
		echo "<tr></tr>";
		
		echo "<tr><td>Choisissez la date :</td><td><input type='text' name='date' id='datepicker' value='".$date."'>";
		echo "</input></td></tr>";

		echo "<tr></tr>";

		echo "<tr><td>Effectif minimum :</td><td><input type='number' name='min'>";
		echo "</input></td></tr>";

		echo "<tr></tr>";

		echo "<tr><td>Effectif maximum :</td><td><input type='number' name='max'>";
		echo "</input></td></tr>";

		echo "<tr></tr>";

		echo "<tr><td><INPUT type='submit' value='Enregistrer séance'></td></tr>";

		echo "</FORM>";

		echo "</table>";

		mysqli_close($connect);
	?>

</body>
</html>
