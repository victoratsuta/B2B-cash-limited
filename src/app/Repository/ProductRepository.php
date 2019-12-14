<?php

namespace App\Repository;

use App\Exceptions\ValidationException;

class ProductRepository extends Repository
{
    public $table = 'products';

    /**
     * @param int[] $productIds
     *
     * @return float
     * @throws ValidationException
     */
    public function getSumPrice(array $productIds): float
    {
        $products = $this->allByIds($productIds);

        $total = 0;

        foreach ($products as $product) {
            $total += $product['price'];
        }

        return $total;
    }
}