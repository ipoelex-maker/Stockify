<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'sku',
        'stock',
        'buy_price',
        'sell_price',
        'description',
        'image',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION CATEGORY
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION SUPPLIER
    |--------------------------------------------------------------------------
    */

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
    
    public function stockIns()
    {
    return $this->hasMany(StockIn::class);
    }
    
    
    public function stockOuts()
    {
    return $this->hasMany(StockOut::class);
    }
}