<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'code',       // Pastikan kolom ini ada jika Anda menggunakannya
        'stock',
        'price',
        'brand',
        'selling_price',
        'note'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');

    }
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'products_suppliers');
    }
    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'products_purchases')->withPivot('quantity', 'price')->withTimestamps(); // Ini memastikan timestamps dikelola;
    }
}
