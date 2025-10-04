<?php

namespace App\Http\Controllers;
use App\Models\Products;
use Illuminate\Http\Request;



class ProdukController extends Controller
{
    public function index()
    {
        $products = Products::all();
        confirmDelete('Apakah anda yakin menghapus data ini?');
        return view('produk.index', compact('products'));
    }
    public function create()
    {
        return view('produk.create');
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return view('produk.edit', compact('product'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'nama_produk' => 'required|string|max:255',
                'kategori_id' => 'required|exists:kategoris,id',
                'harga_jual' => 'required|numeric',
                'harga_beli' => 'required|numeric',
                'stok' => 'required|integer',
                'stok_minimal' => 'required|integer',
                'is_active' => 'required|boolean',
                'sku' => 'required|string|max:100|unique:products,sku,' . $request->id,
            ],
            [
                'nama_produk.required' => 'Nama produk tidak boleh kosong',
                'kategori_id.required' => 'Kategori harus dipilih',
                'kategori_id.exists' => 'Kategori tidak valid',
                'harga_jual.required' => 'Harga jual tidak boleh kosong',
                'harga_jual.numeric' => 'Harga jual harus berupa angka',
                'harga_beli.required' => 'Harga beli tidak boleh kosong',
                'harga_beli.numeric' => 'Harga beli harus berupa angka',
                'stok.required' => 'Stok tidak boleh kosong',
                'stok.integer' => 'Stok harus berupa angka',
                'stok_minimal.required' => 'Stok minimal tidak boleh kosong',
                'stok_minimal.integer' => 'Stok minimal harus berupa angka',
                'is_active.required' => 'Status aktif tidak boleh kosong',
                'is_active.boolean' => 'Status aktif harus berupa true atau false',
                'sku.required' => 'SKU tidak boleh kosong',
                'sku.unique' => 'SKU sudah digunakan, silakan gunakan yang lain'
            ]
        );

        Products::updateOrCreate(['id' => $request->id], $validatedData);
        toast()->success('Produk berhasil disimpan');
        return redirect()->route('master-data.produk.index');
    }
    public function destroy($id)
    {
        $product = Products::find($id);
        $product->delete();
        toast()->success('Produk berhasil di hapus');
        return redirect()->route('master-data.produk.index');
    }
    public function getData()
    {
        $search = request()->query('search');

        $products = Products::where('nama_produk', 'like', '%' . $search . '%')->get();

        return response()->json([
            'results' => $products
        ]);
    }

    public function cekStok()
    {
        $id = request()->query('id');
        // dd($id);
        $stok = Products::find($id)->stok;
        return response()->json($stok);
    }
    

}
