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
				border: 1px solid black;
				border-collapse:collapse;
			}
		</style>

	</head>
	<body style='height:100%;'>";

	foreach($solicituds as $solicitud ){
		$estudiante=Estudiante::findOrFail($solicitud->estudiante);
		$buffer=$buffer."
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
			<table style='font-size:25px; border:0px;width:100%;'>
				<tr style='width:100%;'>
					<td style='text-align:left; border:0px;'>
					<b></u></i>Nombre:</i></u></b>
						".$estudiante->apellido.", ".$estudiante->nombre."
					</td>
					<td style='text-align:right; border:0px; padding-right:20px'>
					<b></u></i>Copias Otorgadas:</i></u></b>
						".$solicitud->copiasOtorgadas."
					</td>
				</tr>
				<tr>
					<td style='text-align:left; border:0px;'>
					<b></u></i>DNI:</i></u></b>
						".$solicitud->estudiante."
					</td>
				</tr>
			</table>
			<div name='tabla' style='position:relative; width:98%;'>
				<table style='font-size:17px; position:relative; width:100%; ' >
					<tr style='width:100%;'>
						<th style='width:26%;'>Copias utilizadas</th>
						<th style='width:26%;'>Copias restantes</th>
						<th style='width:48%;'>Firma</th>
					</tr>";

				for($j=0; $j<34; $j++){
					$buffer=$buffer."
						<tr>
							<td><br></td>
							<td></td>
							<td></td>
						</tr>
						";
				}
				$buffer=$buffer."
				</table>
			</div>";

	}
	$buffer=$buffer."
	</body>
	";


$dompdf->loadHtml($buffer);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("$periodo->periodo-planilla");
?>