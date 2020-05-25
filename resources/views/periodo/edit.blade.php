@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12 offset-md-3 col-md-6">
      <h1 class="w-100 text-primary" ><u>EDICIÓN DE PERÍODO</u><br></h1>   
      <h2 class="text-secondary"><u>{{$periodo->periodo}}</u></h2>
     <br>
      <form action="{{route('periodo.update', $periodo->periodo)}}" id="form" method="POST">
        @method('PATCH')     
        @csrf
        <!--Es mejor mantener hidden el período, pues no se permite editarlo y se detalla en el encabezado-->
        <div class="form-group" hidden>             
            <label for="periodo">Periodo</label>
            <input type="text" class="form-control"  id="periodo" value="{{$periodo->periodo}}">
        </div>
        <div class="form-group">
            <label for="copiasAsignadas">Cantidad de copias para asignar</label>
            <input type="number" class="form-control" name="copiasAsignadas" value="{{$periodo->copiasAsignadas}}" required min=1000>
        </div>
        <div class="form-group">
            <label for="finSolicitud">Finalización de solicitud</label>
            <input type="Date" class="form-control" name="finSolicitud" id="finSolicitud" value="{{$periodo->finSolicitud}}" required>
        </div>
        <div class="form-group">
            <label for="inicioBeca">Fecha de inicio de la beca</label>
            <input type="Date" class="form-control" name="inicioBeca" id="inicioBeca" value="{{$periodo->inicioBeca}}" required>
        </div>
        <div class="form-group">
            <label for="finBeca">Fecha de finalización de la beca</label>
            <input type="Date" class="form-control" name="finBeca" id="finBeca" value="{{$periodo->finBeca}}" required>
        </div>
        <div class="form-group">
            <label for="fechaRevision">Fecha de revisión</label>
            <input type="Date" class="form-control" name="fechaRevision" id="fechaRevision" value="{{$periodo->fechaRevision}}" required>
        </div>
        <label>Responsable de la carga de datos</label>
        <div class="form-group row col-12">
          <div class="form-group col-12 row" style="padding-left: 20px;" id="datosForm">
          </div>
          <input type="text" class="form-control responsable col-11" id="responsableFocus">
        <button type="button" id="agregarResponsable" class="btn btn-secondary col-1">+</button> 
      </div>
        <div class="form-group" hidden>
          <label>Hidden para concatenar los responsables</label>
            <input type="text" class="form-control" id="responsables" name="responsables" value="{{$periodo->responsables}}" >
        </div>
        <button type="submit" class="btn miBoton miBtn col-12" style="border-color: white"><i class="fas fa-save"></i> Guardar cambios</button>
      </form>
      <br>
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function(){
    /*Presentación de datos inicial
      1. Llegan los responsables de la carga, concatenados en un String separados por - a un campo Hidden '#responsables'.
      2. Se cargan divs de la clase responsable, al hacer el split sobre el campo '#responsables' con el caracter '-'.
    */
    var responsables = $("#responsables").val();
    var responsable = responsables.split('-');
    for (var i = 0; i < responsable.length; i++) {
        $('#datosForm').append("<div class='row col-12' id='"+i+"'><br><input type='text' style='background-color:#526AAA; color:white;' class='form-control responsable col-11' value='"+responsable[i]+"'><button type='button' onClick='borrarInput("+i+")' class='btn btn-danger col-1'>-</button></div>");
      }

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

    //PRESUBMIT - CLICKEAR SUBMIT
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

    //Luego elimino el primer caracter, pues siempre es '-'
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
