<?php

namespace App\Http\Controllers;

use App\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
   
    public function index(Request $request)
    {
        if ($request->ajax()) {
         //   return Comentario::where('user_id', auth()->id())->get();
            return Comentario::where('delete', '0')->get();
        } else {
            return view('home');
        }
    }
 
    public function create()
    {
        //
    }
 
    public function store(Request $request)
    {
        $categoria = new Comentario();
        $categoria->name = $request->name;
        $categoria->description = $request->description;
        $categoria->delete = '0';
        $categoria->save();
    
        return $categoria;
    }  
 
    public function show(Comentario $categoria)
    {
        //
    }
 
    public function edit(Comentario $categoria)
    {
        //
    }
 
    public function update(Request $request, $id)
    {
        $categoria = Comentario::find($id);
        $categoria->name = $request->name;
        $categoria->description = $request->description;
        $categoria->save();
        return $categoria;
    }
 
    public function destroy(Request $request, $id)
    {
        $categoria = Comentario::find($id);
        $categoria->delete = '1';
        $categoria->save();
        
    }
}
