<!DOCTYPE html>
<html lang="fr">
        <head>
                <meta charset="utf-8"/>
                <title>Graphique Température </title>
                <link href="style.css" rel="stylesheet" type="text/css"/>
                <link rel="icon" type="image/x-icon" href="https://img2.freepng.fr/20180511/krq/kisspng-line-chart-computer-icons-bar-chart-statistics-5af5e11ec99e17.6226245115260633908258.jpg"/>
				<link href="css/style.css" rel="stylesheet"> <!-- Chemin vers la page css -->
				<link href="https://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700" rel="stylesheet"> <!-- Chemin vers la page css boostrap (police d'écriture)-->
				<link href="https://fonts.googleapis.com/css?family=Roboto:200,300,400,500,600,700" rel="stylesheet"> <!-- Chemin vers la page css googleapis (police d'écriture)-->			
				<!-- on importes les scripts -->
				<script src="jQuery.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
				<script src="utils.js"></script>
        </head>
        <body>

<header class="item header">
<div class="wrapper">
	<nav role="navigation" class="navbar navbar-white navbar-embossed navbar-lg navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a href="index.html" class="navbar-brand brand"> Station Méteo </a>
		</div>
		<div id="navbar-collapse-02" class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="propClone"><a href="php/cap_temp.php">Température</a></li>
				<li class="propClone"><a href="php/cap_humi_terre.php">Humidité Terre</a></li>
				<li class="propClone"><a href="php/cap_humi_air.php">Humidité Air</a></li>
				<li class="propClone"><a href="php/cap_pres.php">Préssion</a></li>
				<li class="propClone"><a href="php/cap_lumi.php">Luminosité</a></li>
				<li class="propClone"><a href="php/cap_anemo.php">Vitesse du Vent</a></li>
			</ul>
		</div>
	</div>
               
				
	<!-- on affiche le graphique -->
	<div style="width:75%;" id = "centergraph">
		<canvas id="canvas"></canvas>
	</div>

	<!-- script pour le graphique --> 
	<script>
		var config = {
			type: 'line',
			data: {
				labels: [<?php 
						$conn = new PDO('mysql:host=localhost;dbname=Projet_1', 'user', 'azerty'); #connection à la BDD Projet_1
						$sql = 'SELECT * FROM cap_Anemo'; #On choisit quelle table on veut afficher 
						foreach ($conn->query($sql) as $row => $value) {
							print("'");
							print($value['Date_Anemometre']); #colonne de la BDD à afficher 
							print("'");
							print(",");
						}
						$pdo = null;
						?>
						],
				datasets: [{
					label: 'Vitesse du vent',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: [
						<?php 
						$conn = new PDO('mysql:host=localhost;dbname=Projet_1', 'user', 'azerty'); #connection à la bdd Projet_1
						$sql = 'SELECT * FROM cap_Anemo';
						foreach ($conn->query($sql) as $row => $value) {
							print("'");
							print($value['Valeur_Anemometre']); #colonne de la BDD à afficher
							print("'");
							print(",");
						}
						$pdo = null;
						?>
					],
					fill: false,
				},]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Chart.js Line Chart'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					x: {
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Date'
						}
					},
					y: {
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Vitesse du vent'
						}
					}
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};
	</script>

	<script src="script.js"></script>  
                
        </body>
</html>
