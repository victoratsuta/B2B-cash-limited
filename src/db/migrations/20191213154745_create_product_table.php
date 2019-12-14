<?php

use Phinx\Migration\AbstractMigration;

class CreateProductTable extends AbstractMigration
{
    public function up()
    {
        $users = $this->table('products');
        $users->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('price', 'decimal', ['precision' => 2])
            ->create();
    }
}
