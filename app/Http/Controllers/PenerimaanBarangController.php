<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenerimaanBarangController extends Controller
{
    public function index()
    {
        return view('penerimaan-barang.index');
    }

    public function store(Request $request) {
        dd($request->all());
    }
}
