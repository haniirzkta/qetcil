<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bouquet_id',
        'quantity',
        'total_price',
        'grand_total_price',
        'size',
    ];

    public function bouquet() : BelongsTo {
        return $this->belongsTo(Bouquet::class, 'bouquet_id');
    }
}
