<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use SebastianBergmann\CodeUnit\FunctionUnit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;


class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        // $kategori = Kategori::paginate(5);
        confirmDelete('Apakah anda yakin menghapus data ini?');
        return view('kategori.index', compact('kategori'));
    }
    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();
        toast()->success('Kategori berhasil di hapus');
        return redirect()->route('master-data.kategori.index');
    }
    public function edit($id)
    {
        $kategori = Kategori::find($id);
        return view('kategori.formkategori', compact('kategori'));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'nama_kategori' => 'required',
            'keterangan' => 'required'
        ], [
            'nama_kategori.required' => 'Nama kategori tidak boleh kosong',
            'keterangan.required' => 'Keterangan tidak boleh kosong'
        ]);
        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'keterangan' => $request->keterangan
        ]);
        toast()->success('Kategori berhasil di update');
        return redirect()->route('master-data.kategori.index');
    }
    public function create(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_kategori' => 'required',
            'keterangan' => 'required'
        ], [
            'nama_kategori.required' => 'Nama kategori tidak Boleh Kosong',
            'keterangan.required' => 'Keterangan tidak boleh kosong'
        ]);
        $data = $request->only(['nama_kategori', 'keterangan']);
        $data['slug'] = Str::slug($data['keterangan']);

        Kategori::create($data);
        toast()->success('Kategori berhasil ditambahkan');
        return redirect()->route('master-data.kategori.index');
    }
}
