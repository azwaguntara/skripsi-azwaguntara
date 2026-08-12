<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;

class KriteriaController extends Controller
{

    public function index()
    {
        $data = Kriteria::all();
        return view('kriteria.index', compact('data'));
    }

    // TAMBAHKAN INI
    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $r)
    {
        Kriteria::create($r->all());
        return redirect('/kriteria');
    }

    public function edit($id)
    {
        $data = Kriteria::find($id);
        return view('kriteria.edit', compact('data'));
    }

    public function update(Request $r,$id)
    {
        Kriteria::find($id)->update($r->all());
        return redirect('/kriteria');
    }

    public function destroy($id)
    {
        Kriteria::destroy($id);
        return back();
    }

}