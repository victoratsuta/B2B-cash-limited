<?php

namespace App\Controllers;

use App\Views\JsonView;

class Controller
{
    /**
     * @return array
     */
    public function all(): array
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    /**
     * @param $message
     */
    public function error($message): void
    {
        http_response_code($message['code']);
        JsonView::render($message['message']);
    }
}