<!DOCTYPE html>
<html lang="fr">
        <head>
                <meta charset="utf-8"/>
                <title>Graphique Humidité</title>
                <link href="style.css" rel="stylesheet" type="text/css"/>
                <link rel="icon" type="image/x-icon" href="https://img2.freepng.fr/20180511/krq/kisspng-line-chart-computer-icons-bar-chart-statistics-5af5e11ec99e17.6226245115260633908258.jpg"/>
				<!-- on importes les scripts -->
				<script src="jQuery.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
				<script src="utils.js"></script>
        </head>
        <body>
               
				
	<!-- on affiche le graphique -->
	<div style="width:75%;" id = "centergraph">
		<canvas id="canvas"></canvas>
	</div>

	<!-- script pour le graphique -->
	<script>
		var config = {
			type: 'bar',
			data: {
				labels: [<?php 
						$conn = new PDO('mysql:host=localhost;dbname=Projet_1', 'user', 'azerty');
						$sql = 'SELECT * FROM cap_Humi_Terre';
						foreach ($conn->query($sql) as $row => $value) {
							print("'");
							print($value['Date_Humidite']);
							print("'");
							print(",");
						}
						$pdo = null;
						?>
						],
				datasets: [{
					label: 'Humidité',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: [
						<?php 
						$conn = new PDO('mysql:host=localhost;dbname=Projet_1', 'user', 'azerty');
						$sql = 'SELECT * FROM cap_Humi_Terre';
						foreach ($conn->query($sql) as $row => $value) {
							print("'");
							print($value['Valeur_Humidite']);
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
					text: 'Chart.js Bar Chart'
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
							labelString: 'Humidité'
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