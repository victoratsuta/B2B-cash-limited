<?php

namespace App\Views;

class JsonView
{
    /**
     * @param string $data
     */
    public static function render($data = "OK")
    {
        die(json_encode($data));
    }
}
