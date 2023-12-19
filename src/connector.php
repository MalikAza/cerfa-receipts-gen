<?php

namespace CerfaReceiptsGen;

use CerfaReceiptsGen\Controller\Logger;
use PDO;

class Connector extends PDO {
    private static Connector $instance;

    private function __construct() {
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $db_name = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USERNAME'];
        $pwd = $_ENV['DB_PASSWORD'];

        parent::__construct(
            "mysql:host=$host;port=$port;dbname=$db_name",
            $user,
            $pwd
        );
    }

    public static function getInstance() {
        if (!isset(self::$instance)) self::$instance = new Connector();

        return self::$instance;
    }
}