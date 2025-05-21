<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Bouquet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'price',
        'category_id',
        'is_popular',
        'stock',
        'is_sold',
    ];

    public function setNameAttribute($value) {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function category() : BelongsTo {
        return $this->belongsTo(category::class);
    }

    public function BouquetPhotos() : HasMany {
        return $this->hasMany(BouquetPhoto::class);
    }

    public function cart() : HasMany {
        return $this->HasMany(Cart::class);
    }
}
