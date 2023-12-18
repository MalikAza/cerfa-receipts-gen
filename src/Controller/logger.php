<?php

namespace CerfaReceiptsGen\Controller;

use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;

class Logger extends \Monolog\Logger {
    /** @var Logger[] Stores the different Logger instances */
    private static $log_sys = [];

    private function __construct(string $key = 'app', $config = null) {
        parent::__construct($key);

        // basic behavior for app logs
        if (empty($config)) {
            $LOG_PATH = Config::get('LOG_PATH', __DIR__ . '/../../log-files');
            $config = [
                'logFile' => "$LOG_PATH/$key.log",
                'logLevel' => \Monolog\Logger::DEBUG
            ];
        }

        $this->pushHandler(new StreamHandler($config['logFile'], $config['logLevel']));
    }

    /**
     * Returns an instance of the Logger class based on the provided key and
     * configuration.
     * 
     * @param string $key Used to identify the specific instance of the Logger. It
     * is used as a key in the  array to store and retrieve the Logger instances.
     * @param $config [OPTIONAL] Allows you to pass additional configuration options to the Logger.
     * It can be used to customize the behavior of the logger, such as setting the log file path,
     * log level, or any other configuration options specific.
     * 
     * @return Logger
     */
    public static function getInstance(string $key = 'app', $config = null): Logger {
        if (empty(self::$log_sys[$key])) {
            self::$log_sys[$key] = new Logger($key, $config);
        }

        return self::$log_sys[$key];
    }

    /**
     * Enables system logs in PHP by creating loggers for errors and requests and saving
     * them to log files.
     */
    public static function enableSystemLogs() {
        $LOG_PATH = Config::get('LOG_PATH', __DIR__ . '/../../log-files');

        self::$log_sys['error'] = new Logger('errors');
        self::$log_sys['error']->pushHandler(new StreamHandler("$LOG_PATH/errors.log"));
        ErrorHandler::register(self::$log_sys['error']);

        $data = [
            $_SERVER,
            $_REQUEST,
            trim(file_get_contents("php://input")),
        ];
        self::$log_sys['request'] = new Logger('request');
        self::$log_sys['request']->pushHandler(new StreamHandler("$LOG_PATH/request.log"));
        self::$log_sys['request']->info("REQUEST", $data);
    }
}