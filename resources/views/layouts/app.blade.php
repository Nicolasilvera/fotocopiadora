<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AdminLTE 3</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="{{asset('dist/js/adminlte.js')}}"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="{{asset('//fonts.gstatic.com')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
      h1,h2,h3,h4,h5,h6,p{
        text-align: center; 
        font-family: serif;
      }
      thead{
        font-style: italic;
        background-color: #0C1738;
      }
      tbody{
        background-color: #28324D;
      }
      input{
        text-align: center;
        background-color: #28324D;
      }

      /*¨Para el menu tree*/
      ul li a p, ul li a i{
        color:white;
      } 
      /*Para su contenedor*/
      ul li a:hover{
        background-color: #00103F;
      }

      .miBoton:hover{
        font-weight: bold;
        background-color: blue;
        color: white;
        font-weight: bold;
        border-color: #0C1738;
      }
      .miBtn{
        background-color: #0C1738;
        color:white;
        border-color: transparent;
      }
      .miBtnDanger:hover{
        background-color: red;
        color: #0C1738;
        border-color: #0C1738;
      }
      .miBtnGreen:hover{
        background-color: green;
        color: #0C1738;
        border-color: #0C1738;
      }
      #acciones{
        height: 1vh;
      }
      .indexTable{
        height: 80vh;
        overflow-y: scroll;
      }
      .readonly{
        background-color: "#536189";
        text-align: "center";
        border-color: "transparent";
      }

      /* Estilo del ScrollBar*/
      ::-webkit-scrollbar {
        width: 4px;
      }
      ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 3px grey;
        border-radius: 3px;
      }
      ::-webkit-scrollbar-thumb {
        background: cyan;
        border-radius: 3px;
      }
      

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed" style="background-color:#05102D;">
 <div class="wrapper" id="app">
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4" style="overflow-x: hidden; background-color: #red">
    <!-- Brand Logo -->
    <br>
    <center>
      <img src="{{asset('dist/img/logoFacultad.png')}}" class="w-75" style="opacity: .8">
    </center>
    <br>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu">
            <a href="#" class="nav-link active" style="background-color: #0B1A46">
              <i class="fas fa-pencil-ruler"></i>
              <p>
                Gestión de Becas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="background-color:#28324D;">
              <li class="nav-item">
                <a href="{{asset('../periodo')}}" class="nav-link">
                  <i class="far fa-calendar-alt"></i>
                  <p>Períodos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{asset('../materia')}}" class="nav-link">
                  <i class="fas fa-chalkboard-teacher"></i>
                  <p>Materias</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{asset('../estudiante')}}" class="nav-link">
                  <i class="fas fa-user"></i>
                  <p>Estudiantes</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Posible futuro link!
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper text-white" style="background-color: #141A2A; border: 0px">
    <!-- Content Header (Page header) -->
   

    <!-- Main content -->
    <div class="content" style="height: 90vh; overflow-y: scroll;">
      <div class="container-fluid">
         @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer text-white" style="background-color: #05102D; height: 10vh;">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Developed by CEFI - ESTIMO 2019/2020<br>
    </div>
    <!-- Default to the left -->
    <strong>Propiedad de CEFI UNLPam</strong> 
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $("input").prop("autocomplete", "off");
    $("input").css({"background-color":"#526AAA", "color":"white"});

    $("select").css({"background-color":"#0C1738", "color":"white", "text-align-last":"center"});
    $("option").css("text-indent", "40%");

    $(".readonly").css({"background-color":"#536189", "text-align":"center", "border-color":"transparent"});
    $(".readonly").prop("title", "Este campo NO se puede editar");
    $(".readonly").prop("readonly", "True");

    $(".campoBusqueda").css({"background-color":"white", "color":"#526AAA"});

    $(".bg-transparente").css("background-color", "transparent");

    $("tr").mouseover(function(){
          $( this ).css( "color", "white" );
      });
  });   
</script>
</body>

</html>