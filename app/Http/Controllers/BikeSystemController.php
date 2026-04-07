<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use Illuminate\Http\Request;
abstract class MatriculaController
{
    public function index(Request $request)
    {
        return view('matriculas.index');
    }

    public function create()
    {
        $matriculas = Matricula::orderBy('id')->get();
        return view('matriculas.create', compact('matriculas'));
    }

    public function store(Request $request)
    {
        $matricula = new Matricula();
        $matricula->id = $request->id;
        $matricula->nombre = $request->nombre;
        $matricula->save();

        return redirect()->route('matriculas.index');
    }

    public function show(Matricula $matricula)
    {
        return view('matriculas.show', compact('matricula'));
    }

    public function destroy($id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->delete();
        return redirect()->route('matriculas.index');
    }
}