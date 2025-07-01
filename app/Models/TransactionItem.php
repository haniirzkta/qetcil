<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bouquet_transaction_id',
        'bouquet_id',
        'quantity',
        'sub_total_amount',
    ];

    public function transaction()
    {
        return $this->belongsTo(BouquetTransaction::class, 'bouquet_transaction_id');
    }

    public function bouquet()
    {
        return $this->belongsTo(Bouquet::class, 'bouquet_id');
    }

}
