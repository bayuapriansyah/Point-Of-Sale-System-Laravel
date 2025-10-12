<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengeluaranBarang extends Model
{
    protected $table = 'pengeluaran_barangs';

    protected $fillable = [
        'user_id',
        'total',
        'jumlah_bayar',
        'kembalian',
        'keterangan',
    ];

    public function items()
    {
        return $this->hasMany(PengeluaranBarangItem::class, 'pengeluaran_id');
    }
}
