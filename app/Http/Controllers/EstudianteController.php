<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Estudiante;

class EstudianteController extends Controller
{
     public function index(Request $request)
    {
        //$estudiantes=Estudiante::all();
        $estudiantes=DB::table('estudiantes')->orderBy('apellido')->orderBy('nombre')->get();
        return view('estudiante.index',['estudiantes'=>$estudiantes]);
    }

    public function create(){
        return view('estudiante.create');
    }

    public function store(Request $request){
        $estudiante=new Estudiante();
        $estudiante->dni=request('dni');
        $estudiante->apellido=request('apellido');
        $estudiante->nombre=request('nombre');
        try { 
            $estudiante->save();
        } catch(\Illuminate\Database\QueryException $ex){ 
                  
        }
       if(request('procedencia') == 'modal'){
            echo "<script>window.close();</script>";
        }else{
            return redirect('/estudiante');
        }
    }

    public function edit($id)
    {
        return view('estudiante.edit', ['estudiante' =>Estudiante::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $estudiante= Estudiante::findOrFail($id);
        $estudiante->dni=$request->get('dni');
        $estudiante->apellido=$request->get('apellido');
        $estudiante->nombre=$request->get('nombre');
        try { 
            $estudiante->update();
        } catch(\Illuminate\Database\QueryException $ex){ 
                  
        }
        return redirect('/estudiante');
    }

    public function destroy($id){
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();
        return redirect('/estudiante');
    }
}
