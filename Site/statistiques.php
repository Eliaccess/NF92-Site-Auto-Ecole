<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Jours');
      data.addColumn('number', 'Moyenne des élèves');

      data.addRows([
            <?php //Ce PHP sert à entrer les données, pour les envoyer à l'API Google Charts et générer un graphique
            date_default_timezone_set('Europe/Paris');
            $date_actuelle = date("Ymd");

            $dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
            $dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
            $dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
            $dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

            $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

            $seances_query = mysqli_query($connection,"SELECT * FROM seance ORDER BY DateSeance ASC");
            while ($seances = mysqli_fetch_array($seances_query, MYSQL_NUM))
            {
                if (strtotime($seances[1]) <= strtotime($date_actuelle))
                {
                    $moyenne = 0;
                    $nombre_etu = 0;
                    $notes_query = mysqli_query($connection,"SELECT * FROM inscription WHERE idseance = $seances[0] and note_eleve <> 50");
                    while ($notes = mysqli_fetch_array($notes_query, MYSQL_NUM))
                    {
                        $nombre_etu++;
                        $moyenne = $moyenne + $notes[2];
                    }
                    if ($nombre_etu <> 0) {
                    $moyenne = floor($moyenne/$nombre_etu);
                    $date_reform = date("Y m d", strtotime($seances[1])); // Reformer la date au format JS pour permettre l'insertion dans le charts
                    echo "[new Date('$date_reform'), $moyenne],";
                  }
                }
            }
            mysqli_close($connection);
            ?>
      ]);

      var options = {
        chart: {
          title: 'Évolution des résultats des élèves de notre auto-école',
          subtitle: 'en moyenne, tous thèmes confondus'
        },
        width: 500,
        height: 300,
        axes: {
          x: {
            0: {side: 'bottom'}
          }
        }
      };

      var chart = new google.charts.Line(document.getElementById('line_top_x'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
  </script>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Thème", "Resultat", { role: "style" } ],
        <?php
            date_default_timezone_set('Europe/Paris');
            $date_actuelle = date("Ymd");

            $dbhost = 'tuxa.sme.utc';
            $dbuser = 'nf92p062';
            $dbname = 'nf92p062';
            $dbpass = 'iFiVg3IK';
            $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

            $themes_query = mysqli_query($connection,"SELECT * FROM themes");
            while ($themes = mysqli_fetch_array($themes_query, MYSQL_NUM))
            {
              $seances_query = mysqli_query($connection,"SELECT * FROM seance WHERE idtheme = $themes[0]");
              while ($seances = mysqli_fetch_array($seances_query, MYSQL_NUM))
              {
                if (strtotime($seances[1]) <= strtotime($date_actuelle))
                {
                  $moyenne = 0;
                  $nombre_etu = 0;
                  $notes_query = mysqli_query($connection,"SELECT * FROM inscription WHERE idseance = $seances[0] and note_eleve <> 50");
                  while ($notes = mysqli_fetch_array($notes_query, MYSQL_NUM))
                  {
                      $nombre_etu++;
                      $moyenne = $moyenne + $notes[2];
                  }
                  if ($nombre_etu <> 0)
                  {
                    $moyenne = floor($moyenne/$nombre_etu);
                    echo '["'.$themes[1].'", '.$moyenne.', "#b12333"],';                    
                  }
                }
              } 
            }
            mysqli_close($connection);
        ?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Résultat des élèves par thème",
        width: 500,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
</script>
<body>
	<titres>Moyennes par séances passées :</titres></br></br></br>
	<div id="line_top_x" align='center'></div><br>
  <div id="columnchart_values" align='center'></div>
</body>
</html>