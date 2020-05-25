<?php

use Illuminate\Support\Facades\Route;
use App\Periodo;
Use App\Estudiante;
Use App\Materia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/estudiante');
});

Auth::routes();

Route::get('borrarEstudiante/{dni}', function() {
	$dni=explode("/borrarEstudiante/", url()->full())[1];
	$estudiante = Estudiante::findOrFail($dni);
    $estudiante->delete();
    return redirect('/estudiante');
});

Route::get('borrarMateria/{nombre}', function() {
	$nombre=explode("/borrarMateria/", url()->full())[1];
	$materia = Materia::findOrFail($nombre);
    $materia->delete();
    return redirect('/materia');
});


Route::get('/periodo/solicitud/{periodo}', function(){
	$periodo=str_replace("%20", " ",explode("/solicitud/", url()->full())[1]);
	 return view('periodo.docs.solicitud', ['periodo' =>Periodo::findOrFail($periodo)]);
});


Route::get('/periodo/cartel/{periodo}', function(){
	$periodo=str_replace("%20", " ",explode("/cartel/", url()->full())[1]);
	 return view('periodo.docs.cartel', ['periodo' =>Periodo::findOrFail($periodo)]);
});

Route::get('/periodo/reglamento/{periodo}', function(){
	$periodo=str_replace("%20", " ",explode("/reglamento/", url()->full())[1]);
	return view('periodo.docs.reglamento', ['periodo' =>Periodo::findOrFail($periodo)]);
});

Route::get('/periodo/planillas/{periodo}', function() {
	$periodo=str_replace("%20", " ",explode("/planillas/", url()->full())[1]);
	return view('periodo.docs.planillas', ['periodo' =>Periodo::findOrFail($periodo)]);
});
Route::get('/periodo/copiasCorregidas/{periodo}', function() {
	$periodo=str_replace("%20", " ",explode("/copiasCorregidas/", url()->full())[1]);
	return view('periodo.docs.copiasCorregidas', ['periodo' =>Periodo::findOrFail($periodo)]);
});


Route::resource('/periodo', 'periodoController');

Route::resource('/materia', 'MateriaController');

Route::resource('/estudiante', 'EstudianteController');


Route::get('/calcularCopiasIniciales/{periodo}', 'solicitudController@calcularCopiasIniciales');
Route::get('/revision/{periodo}', 'solicitudController@revision');
Route::post('/editarCopiasUsadas/{periodo}', 'solicitudController@editarCopiasUsadas');
Route::resource('/solicitud/store', 'solicitudController');
Route::resource('/solicitud', 'solicitudController');
