<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Currency;
use App\Models\Product;
class Price extends Model{
    protected $fillable=['value','currency_id','product_id'];

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}