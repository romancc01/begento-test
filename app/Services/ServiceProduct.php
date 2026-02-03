<?php
namespace App\Services;
use App\Repositories\InterfaceProduct;
use App\Domain\Product;
use App\Domain\Price;
use App\Domain\Currency;

class ServiceProduct
{
    public function __construct(protected InterfaceProduct $repo) {}

    public function getAll():array{
        return $this->repo->all();
    }

    public function getById(int $id):?Product{
        return $this->repo->find($id);
    }

    public function create(array $data):Product{
        $currency = new Currency(
            $data['currency']['id'],
            $data['currency']['name'],
            $data['currency']['symbol'],
            $data['currency']['exchange_rate'] );
            $price = new Price((float)$data['price']['value'], $currency);
            $product = new Product(
                $data['name'],
                $price,
                $data['description'] ?? null,
                null,
                $data['tax_cost'] ?? null,
                $data['manufacturing_cost'] ?? null);
        return $this->repo->save($product);
    }

    public function update(int $id,array $data):Product{
        $existing = $this->repo->find($id);
        if (!$existing){
            throw new \RuntimeException('Productp no encontrado');
        }
        $currency = new Currency(
            $data['currency']['id'],
            $data['currency']['name'],
            $data['currency']['symbol'],
            $data['currency']['exchange_rate']);
        $price = new Price((float)$data['price']['value'], $currency);
        $updated = new Product(
            $data['name'] ?? $existing->name,
            $price,
            $data['description'] ?? $existing->description,
            $id,
            $data['tax_cost'] ?? $existing->tax_cost,
            $data['manufacturing_cost'] ?? $existing->manufacturing_cost
        );
        return $this->repo->save($updated);
    }

    public function delete(int $id):bool{
        return $this->repo->delete($id);
    }

    public function addPrice(int $productId,array $data):Price{
        $currency = new Currency(
            $data['currency']['id'],
            $data['currency']['name'],
            $data['currency']['symbol'],
            $data['currency']['exchange_rate'] );
        $price = new Price((float)$data['price']['value'], $currency);
        return $this->repo->addPrice($productId, $price);
    }
     public function getPricesByProduct($id){
        return $this->repo->getPricesByProduct($id);
    }

}

