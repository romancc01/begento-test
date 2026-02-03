<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\models\Price;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up():void{
        Schema::create('products',function(Blueprint $table){
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('tax_cost', 10, 2)->nullable();
        $table->decimal('manufacturing_cost', 10, 2)->nullable();
        $table->timestamps(); });
    }

    /**
     * Reverse the migrations.
     */
    public function down():void{
        Schema::dropIfExists('products');
    }
};
