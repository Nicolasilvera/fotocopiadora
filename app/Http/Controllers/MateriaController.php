<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Materia;

class MateriaController extends Controller
{
    public function index(Request $request)
    {
        $materias=DB::table('materias')->orderBy('nombre')->get();
        return view('materia.index',['materias'=>$materias]);
    }

    public function create(){
        return view('materia.create');
    }

    public function store(Request $request){
        $materia=new Materia();
        $materia->nombre=request('nombre');
        $materia->copias=request('copias');
        try { 
            $materia->save();
        } catch(\Illuminate\Database\QueryException $ex){ 
                  
        }
       return redirect('/materia');
    }

    public function edit($id)
    {
        return view('materia.edit', ['materia' =>Materia::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $materia= Materia::findOrFail($id);
        $materia->nombre=$request->get('nombre');
        $materia->copias=$request->get('copias');
         try { 
            $materia->update();
        } catch(\Illuminate\Database\QueryException $ex){ 
                  
        }
        return redirect('/materia');
    }

    public function destroy($id){
        $materia = Materia::findOrFail($id);
        $materia->delete();
        return redirect('/materia');
    }
}
