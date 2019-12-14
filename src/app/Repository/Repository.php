<?php

namespace App\Repository;

class Repository
{
    protected $table;

    public function table($table)
    {
        $this->table = $table;
    }
    public function connect()
    {

    }

    public function get($id)
    {
        DB::get($this->table)->query('SELECT...');
    }

    public function getAll()
    {
        DB::get($this->table)->query('SELECT...');
    }

    public function update($like, $data)
    {
        DB::update($this->table)->where('SELECT...')->date;
    }
}