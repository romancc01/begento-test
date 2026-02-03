<?php
namespace App\Repositories;

use App\Domain\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domain\Price; 
interface InterfaceProduct
{
    public function find(int $id): ?Product;
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function save(Product $product): Product;
    public function delete(int $id): bool;
    public function all(): array;
    public function addPrice(int $productId, Price $price): Price;
    public function getPricesByProduct(int $productId): array;
}
