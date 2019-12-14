<?php

namespace App\Services;

use App\Entity\Product;
use App\Repository\ProductRepository;

class GenerateFakeProductsService
{
    const COUNT = 20;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * GenerateFakeProductsService constructor.
     */
    public function __construct()
    {
        $this->productRepository = new ProductRepository;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->productRepository->truncate();

        $products = [];

        for ($i = 0; $i < self::COUNT; $i++) {

            $product = new Product();

            $product->setName('Random name #' . $i);
            $product->setPrice(rand(10, 100));

            $products[] = $product;
        }

        $this->productRepository->massInsert($products);
    }
}