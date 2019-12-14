<?php

namespace App\Core;

use PDO;

class DB
{
    /**
     * @return PDO
     */
    public static function getDBConnect(): PDO
    {
        $dsn = "mysql:host=" . getenv('HOST') . ";port=" . getenv('PORT') . ";dbname=" . getenv('DB_NAME');
        $option = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        try {
            return new PDO($dsn, getenv('DB_USER'), getenv('PASS'), $option);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}

