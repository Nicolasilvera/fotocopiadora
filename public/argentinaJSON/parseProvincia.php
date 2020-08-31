<?php
	/* Tips:
	1. Nos interesa el último valor de cada fila que es el nombre de la provincia.
	2. Como nos interesan sólo las provincias excluimos CABA.
	3. Todos menos CABA comienzan con "Provincia de", queremos sacar este prefijo y dejar solo el nombre.
	*/
	$provincias=array();
	if (($gestor = fopen("provincias.csv", "r")) !== FALSE) {
	    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
	        $numero = count($datos);
	        if(strpos($datos[$numero-1], "Provincia de") !== false) //Comprueba si la primer cadena contiene la otra
	        	$provincias[] = array("nombre" => substr($datos[$numero-1], 13));
	    }
	    fclose($gestor);
	}
	echo(json_encode($provincias, JSON_UNESCAPED_UNICODE));
?>