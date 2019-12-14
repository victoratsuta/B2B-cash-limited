<?php

namespace App\Repository;

use App\Entity\Order;
use App\Exceptions\ValidationException;

class OrderRepository extends Repository
{
    /**
     * @var string
     */
    public $table = 'orders';

    /**
     * @var string
     */
    public $productsTableName = 'orders_product';

    /**
     * @param Order $order
     *
     * @return int
     * @throws ValidationException
     */
    public function create(Order $order): int
    {
        $collection = [];

        $this->db->beginTransaction();

        $sql = "INSERT INTO {$this->table} (total) VALUES (:total)";

        $this
            ->db
            ->prepare($sql)
            ->execute(["total" => $order->getTotal()]);

        $orderId = $this->db->lastInsertId();

        foreach ($order->getProducts() as $product) {
            $collection[] = [
                'product_id' => $product,
                'order_id' => $orderId
            ];
        }

        try {
            $this->massInsert($collection, $this->productsTableName);
        } catch (\Exception $e) {
            throw new ValidationException('No item was found');
        }

        $this->db->commit();

        return $orderId;
    }

    /**
     * @param int $id
     *
     * @return Order
     * @throws ValidationException
     */
    public function find(int $id): Order
    {
        $orderArray = parent::find($id);

        $order = new Order();
        $order->setId($orderArray['id']);
        $order->setTotal($orderArray['total']);
        $order->setStatus($orderArray['status']);

        return $order;
    }

    /**
     * @param Order $order
     */
    public function updateStatus(Order $order): void
    {
        $sql = "UPDATE {$this->table} SET status=? WHERE id=?";
        $this->db->prepare($sql)->execute([$order->getStatus(), $order->getId()]);
    }
}