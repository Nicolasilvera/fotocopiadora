
<?php
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();


$dompdf->loadHtml("
	<head>
		<style>
			table, td, th {
			  border: 1px solid black;
			}

			table {
				padding-left: 30px;
				padding-right: 30px;
				border-collapse: collapse;
				width: 100%;
				text-align:center;
			}
			p {
				padding-left: 30px;
			}
			img{
				height:15px;
			}
		</style>
	</head>
	<body>
		<div name='cabecera' style='height:75px;'>
			<div style='float:left;'>
				<img src='img\logoCefi.jpg' style='height:75px;' alt='Logo de cefi'>
			</div>
			<div style='float; font-size:30px; text-align:center; vertical-align:middle;'>
			<br>
				<u><i>REGLAMENTO DE BECA FOTOCOPIAS</i></u><br>
			</div>
		</div>
		<div style='font-family: Times, serif; text-align: justify; letter-spacing: 1px; font-size:1.3em'>
			<br>
			
			<p> <img src='img\itemReglamento.png'> Todas las solicitudes entregadas fuera de término quedarán automáticamente descartadas. (Fecha límite: ".date('d/m/Y', strtotime($periodo->finSolicitud))." inclusive).</p>

			<p> <img src='img\itemReglamento.png'> Los beneficiados por la beca de fotocopias podrán comenzar a utilizarla el día ".date('d/m/Y', strtotime($periodo->inicioBeca )).".</p>

			<p> <img src='img\itemReglamento.png'> El beneficio de la beca será válido hasta el día ".date('d/m/Y', strtotime($periodo->finBeca)).". </p>

			<p> <img src='img\itemReglamento.png'> El día ".date('d/m/Y', strtotime($periodo->fechaRevision))." serán revisadas la cantidad de copias dadas, siguiendo la siguiente tabla: </p>
			<br>

			<table>
				<tr>
				  <th>Porcentaje de copias utilizadas al <br> ".date('d/m/Y', strtotime($periodo->fechaRevision)).".</th>
				  <th>Categoría</th>
				  <th>Penalización</th>
				</tr>
				<tr>
				  <td>Entre 50% y 100%</td>
				  <td>A</td>
				  <td>-</td>
				</tr>
				<tr>
				  <td>Menos de 50%</td>
				  <td>B</td>
				  <td>Se le quitará el 80% de las copias no utilizadas</td>
				</tr>
				<tr>
				  <td>0%</td>
				  <td>C</td>
				  <td>Se le quitará la beca</td>
				</tr>
			</table>
			<br>
			<p> <img src='img\itemReglamento.png'> Durante la revisión, se reducen la cantidad de copias otorgadas a aquellos beneficiarios que obtengan las categorías B o C, conforme a las acciones a realizar detalladas en la tabla anterior. En consecuencia, las copias quitadas a dichos estudiantes, serán redistribuidas entre los beneficiarios de la categoría A.</p>

			<br><br>
			<img src='img\bannerInferior.jpg' style='height:140px; padding-left:30px; ' >
		</div>
	</body>
	");

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("$periodo->periodo-reglamento");
?>
