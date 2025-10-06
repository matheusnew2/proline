<?php

namespace App\logs;


use \Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;

use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Processor\WebProcessor;

class UploadLogger
{
    /**
     * Create a new class instance.
     */
    public function __invoke(array $config)
    {
        $logger = new Logger($config['name'] ?? 'custom_logger');
        $formatter = new JsonFormatter();
        $handler = new StreamHandler($config['path']);
        $handler->setFormatter($formatter);
        $handler->pushProcessor(new WebProcessor());
        $logger->pushHandler($handler);
        return $logger;
    }
}
