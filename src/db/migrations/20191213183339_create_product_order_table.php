<?php

use Phinx\Migration\AbstractMigration;

class CreateProductOrderTable extends AbstractMigration
{
    public function up()
    {
        $users = $this->table('orders_product');
        $users
            ->addColumn('product_id', 'integer', ['null' => true])
            ->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addColumn('order_id', 'integer', ['null' => true])
            ->addForeignKey('order_id', 'orders', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
