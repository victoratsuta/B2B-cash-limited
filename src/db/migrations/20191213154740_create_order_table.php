<?php

use App\Entity\Order;
use Phinx\Migration\AbstractMigration;

class CreateOrderTable extends AbstractMigration
{
    public function up()
    {
        $users = $this->table('orders');
        $users
            ->addColumn('status', 'string', ['limit' => 50, 'default' => Order::STATUS_NEW])
            ->addColumn('total', 'decimal', ['precision' => 2])
            ->create();
    }
}
