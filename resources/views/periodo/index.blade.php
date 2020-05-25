@extends('layouts.app')

@section('content')
<br>
    <div id="acciones" class="row">
      <div id="botones" class="col-8">
        <a href="{{route('periodo.create')}}" ><button type="button" class="btn miBtn miBoton" style="border-color: white"><i class="far fa-calendar-plus"></i> Nuevo Período</button></a>
      </div> <!--Div Botones-->
      <div class="col-4">
        <input class="form-control campoBusqueda" type="text" style="font-weight: bold" placeholder="Ingrese una búsqueda">
      </div> <!--Div campo búsqueda-->
    </div>

<br><br>
 <div class="indexTable" style="width: 99%">
    <table class="table table-hover" style="text-align: center;">                       <!--Tabla de períodos-->
      <thead>
        <tr>
          <th scope="col">Período</th>
          <th scope="col">N° de copias</th>
          <th scope="col">Fin de Solicitud</th>
          <th scope="col">Inicio de Beca</th>
          <th scope="col">Fin de Beca</th>
          <th scope="col">Fecha Revisión</th>
          <th scope="col">Responsables período</th>
          <th scope="col">Editar parámetros</th>
        </tr>
      </thead>
      <tbody>
          @foreach($periodos as $periodo)
            <tr>
              <td>
                <?php 
                  $anioPeriodo=explode('-',$periodo->periodo)[0];
                  $semestrePeriodio= explode('-',$periodo->periodo)[1];
                ?>
                <a href="{{route('solicitud.index', $periodo->periodo)}}" title="Gestionar éste período">
                  <?php 
                    echo("<b>".$anioPeriodo."</b><br><i>".$semestrePeriodio."</i>");
                  ?>
                </a>
              </td>
              <td>{{$periodo->copiasAsignadas}}</td>
              <td>{{date('d/m/Y', strtotime($periodo->finSolicitud))}}</td>
              <td>{{date('d/m/Y', strtotime($periodo->inicioBeca))}}</td>
              <td>{{date('d/m/Y', strtotime($periodo->finBeca))}}</td>
              <td>{{date('d/m/Y', strtotime($periodo->fechaRevision))}}</td>
              <td class="TDresponsables">
                {{$periodo->responsables}}
              </td>
              <td style="align-items: center;">
                    <a href="{{route('periodo.edit', $periodo->periodo)}}" ><button type="button" class="btn miBtn miBtnGreen" title="Editar datos del período"><i class="fas fa-pencil-alt"></i></button></a>
              </td>
            </tr>
          @endforeach
      </tbody>
    </table>                                                                    <!--Cierra tabla de período-->

    <!--DIV para mostrar el mensaje de "No se encuentran resultados"-->
    <center class="notFound" > 
    </center>
</div>        <!--Cierra el DIV de index table-->

<script type="text/javascript">
  $(document).ready(function(){
    //Traigo todos los periodos de la BD a una variable de js llamada 'periodos'
    periodos=[];
    <?php 
       $periodos=DB::table('periodos')->orderBy('periodo','desc')->get();
      foreach ($periodos as $periodo){
        print("periodo=['".$periodo->periodo."',".$periodo->copiasAsignadas.",'".$periodo->finSolicitud."','".$periodo->inicioBeca."','".$periodo->finBeca."','".$periodo->fechaRevision."','".$periodo->responsables."'];");
        print("periodos.push(periodo);");
      }
    ?>

    //Desconcatenar los responsables para mostrarlos en una lista 
    $(".TDresponsables").each(function(){
      var conc="";
      var responsable= $(this).html().split('-');
      for(var i=0; i < responsable.length; i++){
        if(responsable[i]!=''){
          conc=conc+responsable[i]+"<br>"; 
        }
      }
     $(this).html(conc);
    });//FIN de desconcatenación


    //PROCEDIMIENTO DE BÚSQUEDA
      $( ".campoBusqueda" ).keyup(function() {
        //La variable cadenaBusqueda almacena el valor del campo de búsqueda, mientras que buffer va almacenando la estructura de una tabla de resultados.
        var cadenaBusqueda = $(".campoBusqueda").val().toLowerCase();
        var buffer="";

        for(p in periodos){
          //Para cada periodo en la BD, si la cadena de búsqueda coincide con su nombre, matchea con la búsqueda. Y se añade al buffer.
          if( periodos[p][0].toLowerCase().includes(cadenaBusqueda) ) {
              var semestre = periodos[p][0].split('-')[1];
              var anio = periodos[p][0].split('-')[0];
              buffer+= "<tr>";
              buffer+= "<td><a href='http://127.0.0.1:8000/solicitud?"+periodos[p][0]+"' title='Gestionar éste período'><b>"+anio+"</b><br><i>"+semestre+"</i></a></td>";
              buffer+= "<td>"+periodos[p][1]+"</td>";
              buffer+= "<td>"+transformarFecha(periodos[p][2])+"</td>";
              buffer+= "<td>"+transformarFecha(periodos[p][3])+"</td>";
              buffer+= "<td>"+transformarFecha(periodos[p][4])+"</td>";
              buffer+= "<td>"+transformarFecha(periodos[p][5])+"</td>";
              buffer+= "<td>"+periodos[p][6].replace('-','<br>')+"</td>";
              buffer+= "<td>";
              buffer+= "<a href=''><button type='button' class='btn miBtn miBtnGreen'><i class='fas fa-pencil-alt'></i></button></a>";
              buffer+= "  </td>";
              buffer+= "</tr>)";
          }
        }

        //Borro los resultados de la búsqueda anterior, y el mensaje de NOT FOUND por las dudas.
        $(".notFound").empty();   
        $("tbody").empty();      
        
        //Si hay resultados, los muestro, si no, muestro el cartel de NOT FOUND.
        if(buffer != ""){
          $("tbody").append(buffer);
        }else{
          $(".notFound").append("<p style='text-align:center; font-size:20px; color:cyan'><i>No hay resultados que coincidan con su búsqueda</i></p> ");
        }
                  
        //Por último, corrijo el css de los tr agregados recientemente.
        $("tr").mouseover(function(){
          $( this ).css( "color", "white" );
        });
    });//FIN PROCEDIMIENTO DE BÚSQUEDA
  });  //Fin JQuery 



  function transformarFecha(fecha){
    splited=fecha.split('-');
    return splited[2]+'/'+splited[1]+'/'+splited[0];
  }
</script>

@endsection