<?php
// reference the Dompdf namespace
use Dompdf\Dompdf;
use App\Solicitud;
use App\Estudiante;
// instantiate and use the dompdf class
$dompdf = new Dompdf();


$solicituds=Solicitud::where('periodo', $periodo->periodo)->get();

$buffer="
	<head>
		<style>
			img{
				height:100px;
				align:center;
			}
			hr{
				page-break-after: always;
				border: none;
			}
			table, th, td{
				text-align:center;
				border: 1px solid black;
				border-collapse:collapse;
			}
		</style>

	</head>
	<body style='height:100%;'>
		<div name='cabecera' style='position:relative; width:100%; height:75px;'>
				<div style='width:20%; display: inline-block;'>
					<img src='img\logoFI.png' style='height:90px;' alt='Logo de cefi'>
				</div>
				<div style=' width:60%; display: inline-block;'>
					<p style='font-family: Times, serif;  text-align:center; letter-spacing: 1px; font-size:35px;'><u><b><i>
						Beca de Fotocopias<br>
						".$periodo->periodo."
					</i></b></u></p>
				</div>
				<div style='width:20%; display: inline-block;'>
					<img src='img\logoCefi.jpg' style='height:75px;' alt='Logo de cefi'>
				</div>
			</div>
			<br>
			<br>
			<table style='font-size:17px; position:relative; width:100%; ' >
				<thead>
					<tr style='width=100%;'>
						<th style='width:35%;'>Apellido y Nombre</th>
						<th style='width:13%;'>DNI</th>
						<th style='width:13%;'>Copias Otorgadas</th>
						<th style='width:13%;'>Copias Usadas</th>
						<th style='width:13%;'>Categoría</th>
						<th style='width:13%;'>Copias Corregidas</th>
					</tr>";

	foreach($solicituds as $solicitud ){
		$estudiante=Estudiante::findOrFail($solicitud->estudiante);
		$buffer=$buffer."
				<tbody>
					<tr style='width:100%;'>
						<td>".$estudiante->apellido.", ".$estudiante->nombre."</td>
						<td>".$solicitud->estudiante."</td>
						<td>".$solicitud->copiasOtorgadas."</td>
						<td>".$solicitud->copiasUsadas."</td>
						<td>".$solicitud->categoria."</td>
						<td>".$solicitud->copiasCorregidas."</td>
					</tr>
				</tbody>";
		}	
	$buffer=$buffer."
	</table>
	</body>
	";


$dompdf->loadHtml($buffer);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("$periodo->periodo-corregidas");
?>