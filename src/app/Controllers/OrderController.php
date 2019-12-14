<?php

namespace App\Controllers;

use App\Services\OrderHandler;
use App\Views\JsonView;
use GuzzleHttp\Exception\GuzzleException;

class OrderController extends Controller
{

    /**
     * @var OrderHandler
     */
    private $orderHandler;

    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->orderHandler = new OrderHandler();
    }

    /**
     * /api/order
     */
    public function create(): void
    {
        $id = $this->orderHandler->create($this->all());
        JsonView::render(['id' => $id]);
    }

    /**
     * /api/order/{id}
     *
     * @param int $id
     */
    public function patch(int $id): void
    {
        $this->orderHandler->pay($this->all(), $id);
        JsonView::render();
    }
}