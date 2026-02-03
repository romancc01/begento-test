<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Price;
use App\Models\Currency;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $usd = Currency::where('name', 'US Dollar')->first();
        $mxn = Currency::where('name', 'Peso Mexicano')->first();

        $laptop = Product::create([
            'name' => 'Laptop',
            'description' => 'Laptop de 14 pulgadas',
            'tax_cost' => 1500,
            'manufacturing_cost' => 10000,
        ]);

        Price::create([
            'value' => 1200,
            'currency_id' => $usd->id,
            'product_id' => $laptop->id,
        ]);

        $headphones = Product::create([
            'name' => 'Headphones',
            'description' => 'Auriculares inalámbricos',
            'tax_cost' => 200,
            'manufacturing_cost' => 800,
        ]);

        Price::create([
            'value' => 1500,
            'currency_id' => $mxn->id,
            'product_id' => $headphones->id,
        ]);
    }
}
