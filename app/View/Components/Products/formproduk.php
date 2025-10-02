<?php

namespace App\View\Components\Products;

use App\Models\Kategori;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Products;

class formproduk extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $nama_produk, $kategori_id, $harga_jual, $harga_beli, $stok, $stok_minimal, $is_active, $kategori, $sku;
    public function __construct($id = null)
    {
        $this->kategori = Kategori::all();
        if ($id){
            $product = Products::find($id);
            $this->id = $product->id;
            $this->nama_produk = $product->nama_produk;
            $this->kategori_id = $product->kategori_id;
            $this->harga_jual = $product->harga_jual;
            $this->harga_beli = $product->harga_beli;
            $this->stok = $product->stok;
            $this->stok_minimal = $product->stok_minimal;
            $this->is_active = $product->is_active;
            $this->sku = $product->sku;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.products.formproduk');
    }
}
