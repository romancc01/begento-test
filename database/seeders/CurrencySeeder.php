<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          Currency::create(['name' => 'US Dollar', 'symbol' => '$', 'exchange_rate' => 1.0]);
          Currency::create(['name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 0.92]);
          Currency::create(['name' => 'Peso Mexicano', 'symbol' => '$', 'exchange_rate' => 18.5]);
    }
}
