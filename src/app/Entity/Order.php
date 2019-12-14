<?php

namespace App\Entity;

class Order
{
    const STATUS_NEW = 'NEW';
    const STATUS_PAID = 'PAID';

    /**
     * @var  int
     */
    public $id;

    /**
     * @var  string
     */
    public $status;

    /**
     * @var int[]
     */
    public $products;

    /**
     * @var float
     */
    public $total;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param int[] $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

}