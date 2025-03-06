<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];

    public function getPriceWithVatAttribute()
    {
        $ivaRate = 0.12; 
        return $this->price * (1 + $ivaRate);
    }

}
