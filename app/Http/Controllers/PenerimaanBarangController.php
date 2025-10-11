<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenerimaanBarang;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PenerimaanBarangController extends Controller
{
    public function index()
    {
        return view('penerimaan-barang.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'distributor' => 'nullable|string|max:255',
            'nomor_faktur' => 'nullable|string|max:255',
            'produk' => 'required|array|min:1',
            'produk.*.id' => 'required|integer|exists:products,id',
            'produk.*.qty' => 'required|integer|min:1',
        ], [
            'distributor.required' => 'Distributor harus diisi',
            'nomor_faktur.required' => 'Nomor Faktur harus diisi',
            'produk.required' => 'Produk harus diisi',
            'produk.*.id.required' => 'ID produk harus diisi',
            'produk.*.id.exists' => 'ID produk tidak valid',
            'produk.*.qty.required' => 'Jumlah produk harus diisi',
            'produk.*.qty.integer' => 'Jumlah produk harus berupa angka',
            'produk.*.qty.min' => 'Jumlah produk minimal adalah 1',
        ]);

        $userId = auth()->id();

        DB::beginTransaction();
        try {
            $penerimaan = PenerimaanBarang::create([
                'distributor' => $request->input('distributor'),
                'nomor_faktur' => $request->input('nomor_faktur'),
                'user_id' => $userId,
            ]);

            $items = $request->input('produk');
            foreach ($items as $item) {
                $product = Products::find($item['id']);
                $qty = (int) $item['qty'];

                $penerimaan->items()->create([
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'harga_beli' => $product->harga_beli ?? 0,
                ]);

                $product->increment('stok', $qty);
            }

            DB::commit();

            return redirect()->route('penerimaan-barang.index')->with('success', 'Penerimaan barang berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function laporan()
    {
        $penerimaanBarang = PenerimaanBarang::orderBy('created_at', 'desc')->get();
        return view('penerimaan-barang.laporan', compact('penerimaanBarang'));
    }
}
