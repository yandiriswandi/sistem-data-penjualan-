<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total_item',
        'discount',
        'total_price',
        'supplier_id',
    ];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');

    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_purchases')->withPivot('quantity', 'price')->withTimestamps(); // Ini memastikan timestamps dikelola;
    }
}
