
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
			<div style='float; text-align:center; vertical-align:middle;'>
				<p style=' font-size:3em'><u><i><b>BECA DE FOTOCOPIAS</b></i></u><br></p>
			</div>
		</div>
		<div style='font-family: Times, serif; text-align: justify; letter-spacing: 1px; font-size:2.5em'>
		<br>
			<ol>
				<li> Retirá tu planilla en la cartelera del CEFI o en buffet.</li><br>
				<li>Completala y adjuntá el certificado de inscripción a materias (expedidos por SIU)</li><br>
				<li> Entregala en fotocopiadora</li>
			</ol>
			<br>
			<br>
			TENÉS TIEMPO HASTA EL ".date('d/m', strtotime($periodo->finSolicitud))." PARA ENTREGARLA.
			<br>
			<br>
			<p style='font-size:0.5em'> <i><b>IMPORTANTE:</b> No te olvides de adjuntar el certificado de inscripción a materias.</i>
			</p>
			<br>
			<p style='font-size:0.5em'>Por cualquier inquietud, te dejamos nuestros canales de comunicación	</p>
			<img src='img\bannerInferior.jpg' style='height:140px; padding-left:30px;' >
		</div>
	</body>
	");

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("$periodo->periodo-cartel");
?>
