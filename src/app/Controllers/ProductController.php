<?php

namespace App\Controllers;

use App\Repository\ProductRepository;
use App\Services\GenerateFakeProductsService;
use App\Views\JsonView;

class ProductController extends Controller
{
    /**
     * @var GenerateFakeProductsService
     */
    private $fakeProductsService;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $this->fakeProductsService = new GenerateFakeProductsService();
        $this->productRepository = new ProductRepository;
    }

    /**
     * /api/product/generate
     */
    public function generate(): void
    {
        $this->fakeProductsService->handle();
        JsonView::render();
    }

    /**
     * /api/product
     */
    public function list(): void
    {
        $products = $this->productRepository->all();
        JsonView::render($products);
    }
}