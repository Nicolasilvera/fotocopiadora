<?php
	/* Tips:
	1. Nos interesa el último valor de cada fila que es el nombre de la provincia.
	2. Como nos interesan sólo las provincias excluimos CABA.
	3. Todos menos CABA comienzan con "Provincia de", queremos sacar este prefijo y dejar solo el nombre.
	*/
	$localidades=array();
	
	if (($gestor = fopen("localidades.csv", "r")) !== FALSE) {
	    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
	        $numero = count($datos);
	        $localidad=array();
	        if($datos[$numero-1] !== "Ciudad Autónoma de Buenos Aires"){
		        $localidad[] =array("localidad" => $datos[$numero-3]);
		        $localidad[] =array("provincia" => $datos[$numero-1]);
		        $localidades[]=$localidad;
		    }
	    }
	    fclose($gestor);
	    $localidad=array();
	    $localidad[]="Ciudad Autónoma de Buenos Aires";
	    $localidad[]="Buenos Aires";
	    //La siguiente línea no pisa nada, allí se estaba guardando el encabezado de la tabla
	    $localidades[0]=$localidad;
	}
	echo(json_encode($localidades, JSON_UNESCAPED_UNICODE));
?>