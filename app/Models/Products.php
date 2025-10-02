<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'nama_produk',
        'kategori_id',
        'harga',
        'stok',
        'sku',
        'harga_jual',
        'harga_beli',
        'stok',
        'stok_minimal',
        'is_active'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
