<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaanBarang extends Model
{
    protected $table = 'penerimaan_barangs';

    protected $fillable = [
        'distributor',
        'nomor_faktur',
        'user_id',
    ];

    public function items()
    {
        return $this->hasMany(PenerimaanBarangItem::class, 'penerimaan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
