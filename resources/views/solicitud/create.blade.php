@extends('layouts.app')
@section('content')
	<div id="alertContainer" hidden="">
	<div class="alert alert-danger" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	  	<span aria-hidden="true">&times;</span>
	  </button> 
	  <strong>Usted no ha cargado niguna materia.</strong><br>
	  <i>*Si la solicitud no merece la carga de ninguna materia, por favor, descarte la solicitud.</i><br>
	  <i>*Si por reglamento la debe incluir, cree una materia llamada "0 copias" con el valor de copias=0, en la pestaña de <a style="color:red" href="../materia/create">materias</a></i>	
	</div>
	</div>

	<div class="container">
	  <br>
	  <h1 class="text-primary"><u>DATOS DE LA SOLICITUD</u></h1>
	  <h2 class="text-secondary"><u>{{$periodo->periodo}}</u></h2>
	  <br>
	  <div class="row">
	     <form action="/solicitud/store" method="POST" id="form" class="offset-3 col-6">
	        @csrf   <!--Token que requiere Laravel -->
	        <!--Todo el formulario. name debe coincidir con el campo de la BD y método POST*-->
	       	
	       	<!-- Como período es readonly y se visualiza como título, mejor mantenerlo hidden-->
	       	<div class="form-group" hidden>
			    <label>Periodo</label>
			    <input  type="text" class="form-control" name="periodo" value="{{$periodo->periodo}}" readonly>
			</div>
			<div class="form-group">
				<label for="nombre">DNI del Estudiante </label>
	  			<input type="number" name="estudiante" id="estudiante" class="form-control" autocomplete="off" required/>
  			</div>
			 <div class="form-group">
			    <label for="materiasSelect">Ingrese las materias que cursa el estudiante (excluir las que recursa)</label>
			    <div id="divMaterias">
			 	</div>
			    <select class="form-control" id="materiasSelect" name="materiasSelect">
			    	<option id="select-placeholder" value=0 disabled selected>Seleccione una materia</option>
			    </select>
			  </div>
			<div class="form-group" hidden>
			    <label>Sumatoria de copias</label>
			    <input type="number" class="form-control" name="copiasTotales" id="copiasTotales" value=0>
			</div>

			<div class="form-group" hidden>
			    <label>Materias concatenadas (Hidden)</label>
			    <input type="text" class="form-control" name="listaMaterias" id="listaMaterias">
			</div>
			 <button id="submit" type="submit" class="btn miBtn miBoton col-12" style="border-color:white" id="submit">CARGAR SOLICITUD</button>
	     </form>

	     <div class="modal fade" id="estudianteModal" style="padding-left: 18%" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
		    <div class="modal-content" style="background-color:#05102D">
		    	<center>
			        <h5 class="modal-title text-secondary" id="exampleModalLabel">
			        	<center style="font-size:25px;">
			        		<b><i style="color:cyan">Estudiante no registrado.</i></b></center>Cargue los datos para poder continuar</h5>
		        </center>
		      	<div class="modal-body">
			        <form target="_blank" action="/estudiante" method="POST">
				        @csrf   <!--Token que requiere Laravel -->
				        <!--Todo el formulario. name debe coincidir con el campo de la BD y método POST*-->
				        <div class="form-group">
						    <label>DNI</label>
						    <input type="number" class="form-control" id="dniModal" name="dni" readonly required>
						</div>
				       	<div class="form-group">
						    <label>Apellido</label>
						    <input type="text" class="form-control" name="apellido" required>
						</div>
						<div class="form-group">
						    <label>Nombre</label>
						    <input type="text" class="form-control" name="nombre" required>
						</div>
						<input type="text" class="form-control" name="procedencia" value="modal" hidden>
						<button type="submit" class="btn miBtn miBoton col-12" style="border-color: white" id="submitModal">CARGAR ESTUDIANTE </button>
				     </form>
		      	</div>
		    </div>
			</div>
			</div>


	  </div>
	</div>

	<div class="modal fade" id="estudianteModal" style="padding-left: 30px; background-color: red" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
		    <div class="modal-content" style="background-color:#05102D">
		    	<center>
			        <h5 class="modal-title text-secondary" id="exampleModalLabel">
			        	<center style="font-size:25px;">
			        		<b><i style="color:cyan">Estudiante no registrado.</i></b></center>Cargue los datos para poder continuar</h5>
		        </center>
		      	<div class="modal-body">
			        <form target="_blank" id="formModal" action="/estudiante" method="POST">
				        @csrf   <!--Token que requiere Laravel -->
				        <!--Todo el formulario. name debe coincidir con el campo de la BD y método POST*-->
				        <div class="form-group">
						    <label>DNI</label>
						    <input type="number" class="form-control" id="dniModal" name="dni" readonly required>
						</div>
				       	<div class="form-group">
						    <label>Apellido</label>
						    <input type="text" class="form-control" id="apellidoModal" name="apellido" required>
						</div>
						<div class="form-group">
						    <label>Nombre</label>
						    <input type="text" class="form-control" id="nombreModal" name="nombre" required>
						</div>
						<input type="text" class="form-control" name="procedencia" value="modal" hidden>
						<button type="submit" class="btn btn-primary col-12" id="submitModal">CARGAR ESTUDIANTE </button>
				     </form>
		      	</div>
		    </div>
		</div>
	</div>

	<script type="text/javascript">
		var estudiantes = [];
	    var cantMateriasIngresadas=0;

	    var arrayMateria= [];
	    var materia = {};

		$(document).ready(function(){
	        //Cargo los estudiantes y las materias en la memoria.
	        <?php 
	        	$estudiantes = DB::select("select dni from estudiantes");
	        	$materias = DB::select("select nombre, copias from materias"); 

	        	foreach ($estudiantes as $estudiante){
	        		print("estudiantes.push(".$estudiante->dni.");"); 
	        	}

	        	foreach ($materias as $materia){
	        		print("materia={nombre:'".$materia->nombre."', copias:".$materia->copias."};");
	        		print("arrayMateria.push(materia);");
	        	}
	        ?>

	        //Se agregan todas las materias como opciones del select
	      	for(m in arrayMateria){
	      		var id=arrayMateria[m]["nombre"];
	      		$("#materiasSelect").append("<option id='opt"+id.split(" ").join("_")+"' value='"+id.split(" ").join("_")+"'>"+id+"</option>");
	      	}
			

	        $("#materiasSelect").change(function(){
				cantMateriasIngresadas++;
				var idParaBorrar="";

	        	//Agrego un input de solo lectura, para visualizar las materias elegidas
	        	$("#divMaterias").append("<div style='padding-left:15px; padding-down:5px' class='row' id='materia"+cantMateriasIngresadas+"'><input style='background-color:#536189; color:white;' class='form-control col-10' value='"+$("#materiasSelect").val().split("_").join(" ")+"' readonly></input> <a id='deleteInput"+cantMateriasIngresadas+"' onClick=borrarMateria('materia"+cantMateriasIngresadas+"'); class='btn btn-danger col-1' style='border-radius: 30%; color:white '> X</button></a>");


	        	//Borro el elemento de las opciones para no elegirlo dos veces
	        	idParaBorrar= $("#materiasSelect").val();
	        	$("#opt"+idParaBorrar).remove();

	        	//Reseteo el select
	        	$("#materiasSelect").val("0");
	        	
	        	var acum=0;
				$("div[id^='materia']").each(function(){
				   var resultado = arrayMateria.find(x => x.nombre === $(this).children().val());
				    acum=acum+resultado["copias"];
				});
				$("#copiasTotales").val(acum);
	        });// CIERRA #materiasSelect.change


		   	$("#form").submit(function(evt){
		   		var concatMaterias="";
				//Acumulo en un String los nombres de las materias, separadas por ';'
		   		$("div[id^='materia']").each(function(){
				   var resultado = arrayMateria.find(x => x.nombre === $(this).children().val());
				   concatMaterias=concatMaterias+resultado["nombre"]+";";
				});
				//Almaceno dicho String en un Hidden oculto con id y name='listaMaterias', para ser almacenado en la BD.
				$("#listaMaterias").val(concatMaterias);

				//Verifico si se seleccionó alguna materia, de no ser así, la carga no tiene sentido.
				if(concatMaterias == ""){
	   				$('#alertContainer').prop("hidden",false);
	   				evt.preventDefault();
	   				return false;
	   			}

				//Busco si el estudiante fue ingresado o no en la BD (si existe o no).
				var dniEstudiante = $("#estudiante").val().replace(/[^ 0-9]/g, '');	//Quita '.' y ','
		   		var existeEstudiante=0;
  				
	   			for (e in estudiantes){
	   				if (estudiantes[e] == dniEstudiante){
	   					existeEstudiante = 1;
	   				}
	   			}	   			
	   			//Si NO existe en la BD, se abre el modal para la carga, con el dni ingresado como readonly, y se detiene el submit.
				if(existeEstudiante == 0){
	   				$('#dniModal').val($('#estudiante').val());
	   				$('#estudianteModal').modal('show');
	   				evt.preventDefault();
	   			} 
	   			else{
	   				alert("Cargando, por favor aguarde");
	   			}				
		   	});// CIERRAN las acciones previas al submit

		   	$("#submitModal").click(function(){
		        	$('#estudianteModal').modal('hide');
		        	<?php 
		        		use App\Estudiante;
		        	 	$estudiante=new Estudiante();
        				$estudiante->dni= print("$('#dniModal').val();");
        				$estudiante->apellido=print("$('#apellidoModal').val();");
        				$estudiante->nombre=print("$('#nombreModal').val();");
						try {
							print("estudiantes.push($('#dniModal').val());");
						    $estudiante->save();
						} catch(\Illuminate\Database\QueryException $ex){ 
						}	

					?>
	    	});

		   	$('.alert-danger').on('closed.bs.alert', function () {
		   		$('#alertContainer').prop("hidden",true);
			  	$('#alertContainer').append("<div class='alert alert-danger' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Usted no ha cargado niguna materia.</strong><br><i>*Si la solicitud no merece la carga de ninguna materia, por favor, descarte la solicitud.</i><br><i>*Si por reglamento la debe incluir, cree una materia llamada '0 copias' con el valor de copias=0, en la pestaña de <a style='color:red' href='../materia/create'>materias</a></i></div>");
			});

		});//cierra document.ready	



		function borrarMateria(idinput){
			materiaBorrada= document.getElementById(idinput).children[0].value;

			//Vuelvo a incluirlo a la lista de opciones
			$("#materiasSelect").append("<option id='opt"+materiaBorrada.split(" ").join("_")+"' value='"+materiaBorrada.split(" ").join("_")+"'>"+materiaBorrada+"</option>");

			ordenarSelect('materiasSelect');

			//Guardo la cantidad de copias para restarla del acumulador
			var resultado = arrayMateria.find(x => x.nombre === materiaBorrada.split("_").join(" "));
			restar= resultado["copias"];

			//Elimino el input con la materia
			elemento=document.getElementById(idinput);
			elemento.parentNode.removeChild(elemento);

			//Actualizo el acumulador
			valorActual=$("#copiasTotales").val();
			$("#copiasTotales").val(valorActual-restar);

			//Reseteo el select
			$("#materiasSelect").val("0");
		}

		function ordenarSelect(id_componente){
		  var selectToSort = jQuery('#' + id_componente);
		  var optionActual = selectToSort.val();
		  selectToSort.html(selectToSort.children('option').sort(function (a, b) {
		  	if(a.value != "0" && b.value != "0")
		    	return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
		  })).val(optionActual);
		}
	</script>
@endsection

