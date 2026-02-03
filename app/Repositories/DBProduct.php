<?php
namespace App\Repositories;

use App\Domain\Product;
use App\Domain\Price;
use App\Domain\Currency;  
use App\Models\Product as EloquentProduct;
use App\Models\Currency as EloquentCurrency;
use App\Models\Price as EloquentPrice;
use Illuminate\Pagination\LengthAwarePaginator;

class DBProduct implements InterfaceProduct{
    protected $model;

    public function __construct(EloquentProduct $model){
        $this->model = $model;
    }


    public function all():array{
        $modelos = $this->model->all();
        return $modelos->map(fn($modelo) => $this->toDomain($modelo))->all();
    }

    protected function toDomain(EloquentProduct $modelo):Product{
        $priceModel = $modelo->prices()->first();
        if (!$priceModel){
            throw new \RuntimeException("No hay precio para el producto {$modelo->id}");
        }
        $currencyModel=$priceModel->currency;
        if (!$currencyModel){
            throw new \RuntimeException("No hay moneda para el precio {$priceModel->id}");
        }
        $currency = new \App\Domain\Currency(
            $currencyModel->id,
            $currencyModel->name,
            $currencyModel->symbol,
            (float)$currencyModel->exchange_rate);

        $price = new \App\Domain\Price((float)$priceModel->value, $currency);
        return new \App\Domain\Product(
            $modelo->name,
            $price,
            $modelo->description,
            $modelo->id,
            $modelo->tax_cost,
            $modelo->manufacturing_cost);
    }

    public function find(int $id): ?Product{
        $modelo = $this->model->find($id);
        return $modelo ? $this->toDomain($modelo):null;
    }



    public function paginate(int $perPage = 15): LengthAwarePaginator {
        $paginator = $this->model->paginate($perPage);
        $paginator->getCollection()->transform(fn($modelo) => $this->toDomain($modelo));
        return $paginator;
    }

    public function save(Product $product):Product{
        if ($product->id){
            $modelo = $this->model->find($product->id);
            if (!$modelo) throw new \RuntimeException('Modelo no encontrado');
        }else{
            $modelo = new EloquentProduct();
        }

        $modelo->name = $product->name;
        $modelo->description = $product->description;
        $modelo->tax_cost=$product->tax_cost;
        $modelo->manufacturing_cost = $product->manufacturing_cost;
        $modelo->save();
        $priceModel = \App\Models\Price::updateOrCreate(
        ['product_id' => $modelo->id],
        [
            'value' => $product->price->price(),
            'currency_id' => $product->price->currency()->id,]);

        return $this->toDomain($modelo);
    }

    public function delete(int $id): bool{
        return (bool)$this->model->destroy($id);
    }
    public function getPricesByProduct(int $productId): array
    {
        $product = $this->model->find($productId);

        if (!$product) {
            throw new \RuntimeException("Producto no encontrado con ID {$productId}");
        }

        $prices = $product->prices()->get();

        return $prices->map(function ($priceModel) {
            $currencyModel = $priceModel->currency;

            $currency = new \App\Domain\Currency(
                $currencyModel->id,
                $currencyModel->name,
                $currencyModel->symbol,
                (float)$currencyModel->exchange_rate
            );

            return new \App\Domain\Price((float)$priceModel->value, $currency);
        })->all();
    }
    public function addPrice(int $productId, Price $price): Price
    {
        $product = $this->model->findOrFail($productId);
        $priceModel = EloquentPrice::create([
            'product_id' => $product->id,
            'value' => $price->price(),
            'currency_id' => $price->currency()->id,
        ]);

        return $price;
    }
    public function findPricesByProductId($id)
    {
        $product = Product::with('prices')->find($id);

        if (!$product) {
            return ['error' => 'Producto no encontrado'];
        }

        return $product->prices;
    }


}

