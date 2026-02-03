<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Currency extends Model{
    protected $fillable=['id','name','symbol','exchange_rate'];

    public function prices(){
        return $this->hasMany(Price::class);
    }
}