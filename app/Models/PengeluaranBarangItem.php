<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengeluaranBarangItem extends Model
{
    protected $table = 'pengeluaran_barang_items';

    protected $fillable = [
        'pengeluaran_id',
        'product_id',
        'qty',
        'harga_jual',
    ];

    public function pengeluaran()
    {
        return $this->belongsTo(PengeluaranBarang::class, 'pengeluaran_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
