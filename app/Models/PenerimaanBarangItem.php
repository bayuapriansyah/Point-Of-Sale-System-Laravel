<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaanBarangItem extends Model
{
    protected $table = 'penerimaan_barang_items';

    protected $fillable = [
        'penerimaan_id',
        'product_id',
        'qty',
        'harga_beli',
    ];

    public function penerimaan()
    {
        return $this->belongsTo(PenerimaanBarang::class, 'penerimaan_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
