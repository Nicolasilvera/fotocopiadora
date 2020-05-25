
<?php
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();


setlocale(LC_TIME, 'es_ES', 'esp_esp'); 


$diaSem= date('l', strtotime($periodo->finSolicitud));
switch ($diaSem) {
    case 'Sunday':
        $diaSem='Domingo';
        break;
    case 'Monday':
        $diaSem='Lunes';
        break;
    case 'Tuesday':
        $diaSem='Martes';
        break;
    case 'Wednesday':
        $diaSem='Miércoles';
        break;
    case 'Thursday':
        $diaSem='Jueves';
        break;
    case 'Friday':
        $diaSem='Viernes';
        break;
    case 'Saturday':
        $diaSem='Sábado';
        break;
}

$buffer="
	<head>
		<style>
			img{
				height:100px;
				align:center;
			}
		</style>
	</head>
	<body style='height:100%;'>";

	for($i=0; $i<2; $i++){
		$buffer=$buffer."<div name='left' style='width:50%; height:100%; float:left'>
			<p style='text-align:center; width:100%; font-size:1.5em; '><u><i><b>SOLICITUD DE BECAS DE FOTOCOPIAS</b></i></u></p>
			<center>
				<img src='img\logoCefi.jpg' alt='Logo de cefi'>
			</center>
			<p style='text-align:center; width:100%;'><u><i>Centro de Estudiantes Facultad de Ingeniería</i></u></p>
			<br>
			<p style=' width:100%; font-size:1.2em;'>Fecha tope de entrega: <b>".$diaSem." ".strftime('%d de %B del %Y', strtotime($periodo->finSolicitud))."</b><br>
				Luegar de entrega: <b>Fotocopiadora</b>

			<br><br><br>
			<u>Completá los siguientes datos con letra LEGIBLE:</u>
			</p>
			<ul>
				<li>Apellido y Nombre:</li>
				<li style='padding-top:10px;'>D.N.I:</li>
			</ul>
			<br>
			<div style='width:80%; padding-left:10%; border-style: solid; font-size:1.3em; text-align:center'><b><i>
				ADJUNTÁ EL CERTIFICADO DE MATERIAS QUE CURSÁS ESTE CUATRIMESTRE, Y ACLARÁ CUALES ESTÁS RECURSANDO.
			</i></b></div>
			<center>
				<br>
				<img src='img\bannerInferior.jpg' style='width:90%;'>
			</center>
		</div>";
	}
	$buffer=$buffer."
	</body>
	";


$dompdf->loadHtml($buffer);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("$periodo->periodo-solicitud");
?>
