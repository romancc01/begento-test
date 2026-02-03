<?php
namespace App\Domain;

 class Currency implements \JsonSerializable
{
    public ?int $id;
    public ?string $name;
    public ?string $symbol;
    public ?float $exchange_rate;

    public function __construct( ?int $id = null,string $name,string $symbol,?float $exchange_rate = null){
        $this->id = $id;
        $this->name = $name; 
        $this->symbol= $symbol;
        $this->exchange_rate = $exchange_rate;
    }
    public function jsonSerialize():array{
        return [
            'id' => $this->id,
            'name' => $this->name,
            'symbol' => $this->symbol,
            'exchange_rate' => $this->exchange_rate
        ];
    }

}
