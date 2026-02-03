<?php
namespace App\Domain;
use App\Domain\Price;
class Product{
    public ?int $id;
    public string $name;
    public ?string $description;
    public ?int $currency_id;
    public ?float $tax_cost;
    public ?float $manufacturing_cost;
    public Price $price;

    public function __construct(string $name, 
    Price $price,
    ?string $description = null,
    ?int $id = null,
    ?float $tax_cost = null,
    ?float $manufacturing_cost = null,
    ?int $currency_id = null){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->currency_id = $currency_id;
        $this->tax_cost = $tax_cost;
        $this->manufacturing_cost = $manufacturing_cost;
        $this->price = $price;
    }

    
}
