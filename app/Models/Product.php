<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Price;
class Product extends Model{
    protected $fillable = ['name', 'description', 'tax_cost', 'manufacturing_cost'];
    public function prices(){
        return $this->hasMany(Price::class);
    }
}