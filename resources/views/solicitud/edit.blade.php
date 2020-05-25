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
  <h1 class=" text-primary"><u>EDICIÓN DE SOLICITUD</u><br></h1>   
  <h2 class="text-secondary"><u>{{$solicitud->periodo}}</u></h2>
  <br>
  <form id="form" class="offset-3 col-6" action="{{route('solicitud.update', $solicitud->id)}}" method="POST">
    @method('PATCH')     <!--Token que requiere Laravel -->
     @csrf                                     <!--Token que requiere Laravel -->
    <div id="datosForm">
      <!-- Es en vano mostrar un readonly de período, puesto que se muestra como encabezado -> Hidden -->
      <div class="form-group" hidden>
          <label>Periodo</label>
          <input type="text" class="form-control" name="periodo" value="{{$solicitud->periodo}}">
      </div><br>
      <div class="form-group">
          <label>Estudiante</label>
          <input  type="text" class="form-control readonly" name="estudiante" value="{{$solicitud->estudiante}}" readonly="" >
      </div>
      <div class="form-group">
        <label for="materiasSelect">
          Ingrese las materias que cursa el estudiante (excluir las que recursa)
        </label>
        <div id="divMaterias">
        </div>
        <select class="form-control" id="materiasSelect" name="materiasSelect">
            <option value=0 disabled selected>Seleccione una materia</option>
        </select>
      </div>
      <div class="form-group" hidden>
          <label>Materias concatenadas (Hidden)</label>
          <input type="text" value="{{$solicitud->listaMaterias}}" class="form-control" name="listaMaterias" id="listaMaterias">
      </div>
      <div class="form-group" hidden="">
          <label>Sumatoria de copias</label>
          <input type="number" class="form-control" name="copiasTotales" value=80 readonly="">
      </div>
       <button type="submit" class="btn miBoton miBtn col-12" style="border-color: white" id="submit">GUARDAR CAMBIOS</button>
    </div>
  </form>
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
    
      /*Presentación de datos inicial
      1. Llegan los responsables de la carga, concatenados en un String separados por - a un campo Hidden '#responsables'.
      2. Se cargan divs de la clase responsable, al hacer el split sobre el campo '#responsables' con el caracter '-'.
      */
      var listaMaterias = $("#listaMaterias").val().split(';');  //Uso ; porque '-' se usa en algunos nombres
      for (var i = 0; i < listaMaterias.length-1; i++) {
        var idParaBorrar="";
        $("#divMaterias").append("<div style='padding-left:15px; padding-down:5px' class='row' id='materia"+cantMateriasIngresadas+"'><input class='form-control col-10 readonly' value='"+listaMaterias[i]+"'></input> <a id='deleteInput"+cantMateriasIngresadas+"' onClick=borrarMateria('materia"+cantMateriasIngresadas+"'); class='btn btn-danger col-1' style='border-radius: 30%; color:white '> X</button></a>");
          idParaBorrar= listaMaterias[i].split(" ").join("_");
          $("#opt"+idParaBorrar).remove();
          cantMateriasIngresadas++;
      }


    $("#materiasSelect").change(function(){
      cantMateriasIngresadas++;
      var idParaBorrar="";

      //Agrego un input de solo lectura, para visualizar las materias elegidas
      $("#divMaterias").append("<div style='padding-left:15px; padding-down:5px' class='row' id='materia"+cantMateriasIngresadas+"'><input style='background-color:#536189; color:white;border-color:transparent' class='form-control col-10' value='"+$("#materiasSelect").val().split("_").join(" ")+"' readonly></input> <a id='deleteInput"+cantMateriasIngresadas+"' onClick=borrarMateria('materia"+cantMateriasIngresadas+"'); class='btn btn-danger col-1' style='border-radius: 30%; color:white '> X</button></a>");


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
      var dniEstudiante = $("#estudiante").val().replace(/[^ 0-9]/g, ''); //Quita '.' y ','
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
