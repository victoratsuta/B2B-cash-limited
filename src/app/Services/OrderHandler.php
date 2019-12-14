<?php

namespace App\Services;

use App\Entity\Order;
use App\Exceptions\ValidationException;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Valitron\Validator;

class OrderHandler
{

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var YandexService
     */
    private $api;

    /**
     * OrderHandler constructor.
     */
    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->productRepository = new ProductRepository();
        $this->api = new YandexService();
    }

    /**
     * @param array $params
     *
     * @return int
     * @throws Exception
     */
    public function create(array $params): int
    {
        $this->validateCreate($params);

        $total = $this->productRepository->getSumPrice($params['products']);

        $order = new Order();
        $order->setTotal($total);
        $order->setProducts($params['products']);

        return $this->orderRepository->create($order);
    }

    /**
     * @param array $data
     *
     * @throws Exception
     */
    private function validateCreate(array $data): void
    {
        $v = new Validator($data);
        $v->rule('required', 'products');
        $v->rule('integer', 'products.*');

        if (!$v->validate()) {
            throw new ValidationException(json_encode($v->errors()));
        }
    }

    /**
     * @param array $params
     *
     * @param int   $orderId
     *
     * @return void
     * @throws Exception
     */
    public function pay(array $params, int $orderId): void
    {
        $this->validatePay($params);

        $order = $this->orderRepository->find($orderId);

        if ($order->getTotal() != $params['price']) {
            throw new ValidationException('Wrong price');
        }

        if ($order->getStatus() !== Order::STATUS_NEW) {
            throw new ValidationException('Wrong status');
        }

        if ($this->api->send()) {
            $order->setStatus(Order::STATUS_PAID);
            $this->orderRepository->updateStatus($order);
        }
    }

    /**
     * @param array $data
     *
     * @throws Exception
     */
    private function validatePay(array $data): void
    {
        $v = new Validator($data);
        $v->rule('required', 'price');
        $v->rule('numeric', 'price');

        if (!$v->validate()) {
            throw new ValidationException(json_encode($v->errors()));
        }
    }
}