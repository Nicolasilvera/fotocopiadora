@extends('layouts.app')
@section('content')

<?php
	//Valores que tendrá el form como default - Sólo son recomendaciones, no deben guardar si o si la fecha recomendada.
	$anioPeriodo=$date = date('Y', mktime(0, 0, 0, date('m'), date('d') + 5, date('Y')));
	$inicioBeca=$date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 5, date('Y')));
	$finBeca=$date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 90, date('Y')));
	$fechaRevision=$date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 40, date('Y')));
?>
<div class="container">
  <br>
  <h1 class="w-100 text-primary" style="text-align: center; font-family: serif;"><u>DATOS DEL NUEVO PERÍODO</u></h1>
  <br>
  <div class="row">
      <form action="/periodo" method="POST" id="form" class="offset-3 col-6">
        @csrf   <!--Token que requiere Laravel -->
        <!--Todo el formulario. name debe coincidir con el campo de la BD y método POST*-->
        <div>
        	<div class="form-group">
				<label for="semestrePeriodo">Seleccione el semestre</label>
				<select class="form-control periodo" id="semestrePeriodo">
				    <option value="Primer Semestre">Primer Semestre</option>
				    <option value="Segundo Semestre">Segundo Semestre</option>
				</select>
			</div>
        	<div class="form-group">
			    <label for="anioPeriodo">Año del nuevo período</label>
			    <input type="number" class="form-control periodo" id="anioPeriodo"  value="<?php echo($anioPeriodo); ?>" required min=2020 max=2050>
			</div>
			<div class="form-group" hidden="">
			    <input type="text" id="periodo" name="periodo"></input>
			</div>
			<div class="form-group">
			    <label for="anioPeriodo">Cantidad de copias para asignar</label>
			    <input type="number" class="form-control" name="copiasAsignadas" id="anioPeriodo" value="1000"  min=1000>
			</div>
			<div class="form-group">
			    <label for="topeSolicitud">Finalización de solicitud</label>
			    <input type="Date" class="form-control" value="<?php echo(date('Y-m-d')); ?>" name="finSolicitud" id="topeSolicitud" required>
			</div>
			<div class="form-group">
			    <label for="inicioBeca">Fecha de inicio de la beca</label>
			    <input type="Date" class="form-control" value="<?php echo($inicioBeca); ?>"  name="inicioBeca" id="inicioBeca" required>
			</div>
			<div class="form-group">
			    <label for="finBeca">Fecha de finalización de la beca</label>
			    <input type="Date" class="form-control" value="<?php echo($finBeca); ?>" name="finBeca" id="finBeca" required>
			</div>
			<div class="form-group">
			    <label for="fechaRevision">Fecha de revisión</label>
			    <input type="Date" class="form-control" value="<?php echo($fechaRevision); ?>" name="fechaRevision" id="fechaRevision" required>
			</div>
			<label>Responsable de la carga de datos</label>
		    <div class="form-group row col-12">
		    	<div class="form-group col-12 row" style="padding-left: 20px;" id="datosForm">
		    	</div>
			    <input type="text" class="form-control responsable col-11" id="responsableFocus">
				<button type="button" id="agregarResponsable" class="btn btn-secondary col-1">+</button> 
			</div>
			</div>
			<div class="form-group" hidden>
				<label>Hidden para concatenar los responsables</label>
			    <input type="text" class="form-control" id="responsables" name="responsables" required>
			</div>
		 <button type="submit" class="btn miBtn miBoton col-12" style="border-color: white" id="submit">Cargar Período</button><br><br>
      </form>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		//Cargo un default para el período. Si bien se carga semestre y año en un sólo campo, se le dará al usuario el ingreso por separado.
		$("#periodo").val($("#anioPeriodo").val()+"-"+$("#semestrePeriodo").val());

		$("#agregarResponsable").click(function(){
			if($("#responsableFocus").val() != ''){
				//Cada vez que se agrega un responsable, se concatenan todos aquellos campos de class responsable dentro de la variable "conc", la cual se almacena en un hidden que separa los reponsables con el caracter '-', para ser almacenados en un sólo campo de la BD.
				var cantidad=0;
				cantidad=concatenarResponsables();
				cantidad++;
				var responsable=$("#responsableFocus").val();
				$('#datosForm').append("<div class='row col-12' id='"+cantidad+"'><br><input type='text' style='background-color:#526AAA; color:white;' class='form-control responsable col-11' value='"+responsable+"'><button type='button' onClick='borrarInput("+cantidad+")' class='btn btn-danger col-1'>-</button></div>");
			 	$("#responsableFocus").val('');
				}
			$("#responsableFocus").focus();
			});

		$(".periodo").change(function(){
			$("#periodo").val($("#anioPeriodo").val()+"-"+$("#semestrePeriodo").val());
		});

		$("#form").submit(function(){
			concatenarResponsables();
		});	
	});		

	function concatenarResponsables(){
		var conc="";
		var cantidad=0;
		$(".responsable").each(function(){
	    	conc=conc+"-"+$(this).val();
	    	cantidad++;
   		});
   		
   		//Si concatené y el último campo estaba vacío debo eliminar el guión que se pone al final
		if( $("#responsableFocus").val() == '' ){
		 conc=conc.slice(0,-1); 
		}
   		//Elimino el primer caracter, pues es '-'
		$("#responsables").val(conc.replace('-',''));	
		return cantidad;
	}

	function borrarInput(id){
		//Elimino el input 
		elemento=document.getElementById(id);
		elemento.parentNode.removeChild(elemento);
		concatenarResponsables();
	}
</script>

@endsection
