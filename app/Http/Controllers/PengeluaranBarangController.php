<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengeluaranBarang;
use App\Models\Products;
use App\Models\PengeluaranBarangItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PengeluaranBarangController extends Controller
{
    public function index()
    {
        return view('pengeluaran-barang.index');
    }

    public function laporan()
    {
        $from = request()->query('from');
        $to = request()->query('to');

        $query = PengeluaranBarang::with('items.product')->orderBy('created_at', 'desc');
        if ($from)
            $query->whereDate('created_at', '>=', $from);
        if ($to)
            $query->whereDate('created_at', '<=', $to);

        if (request()->query('export') === 'csv') {
            $items = $query->get();
            $filename = 'laporan-pengeluaran-' . date('YmdHis') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function () use ($items) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['Tanggal', 'Total', 'Jumlah Bayar', 'Kembalian', 'Items']);
                foreach ($items as $p) {
                    $itemList = [];
                    foreach ($p->items as $it) {
                        $itemList[] = ($it->product->nama_produk ?? 'Produk dihapus') . ' x' . $it->qty . ' @' . $it->harga_jual;
                    }
                    fputcsv($handle, [$p->created_at, $p->total, $p->jumlah_bayar, $p->kembalian, implode('; ', $itemList)]);
                }
                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        }

        $pengeluaran = $query->paginate(25)->withQueryString();
        return view('pengeluaran-barang.laporan', compact('pengeluaran', 'from', 'to'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk' => 'required|array',
            'produk.*.id' => 'required|exists:products,id',
            'produk.*.qty' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->produk as $item) {
                $produk = Products::find($item['id']);

                if ($produk) {
                    $produk->stok -= $item['qty'];

                    if ($produk->stok < 0) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi.');
                    }

                    $produk->save();

                    PengeluaranBarang::create([
                        'produk_id' => $item['id'],
                        'qty' => $item['qty'],
                        'harga_jual' => $item['harga_jual'],
                        'subtotal' => $item['qty'] * $item['harga_jual'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengeluaran-barang.index')->with('success', 'Transaksi berhasil disimpan dan stok berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
