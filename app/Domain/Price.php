<?php
namespace App\Domain;
use App\Domain\Currency;
 class Price implements \JsonSerializable
{
    private ?int $id;
    private currency $currency;
    private ?float $price;
    public function __construct(float $price, Currency $currency ){
        if ($price < 0) throw new \InvalidArgumentException('Precio debe ser >= 0');
        $this->price = $price;
        $this->currency= $currency;
    }
    public function price(): float { return $this->price; }
    public function currency(): Currency { return $this->currency; }
    public function withPrice(float $new): self { return new self($new, $this->currency); }
    public function jsonSerialize():array{
        return ['price' => $this->price,'currency' => $this->currency];
    }
}
