<?php

use App\Core\Routing;
use Dotenv\Dotenv;

require_once "../vendor/autoload.php";

$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

$routing = new Routing();
$routing->run();
