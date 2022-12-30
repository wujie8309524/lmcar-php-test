<?php

namespace App\Service;

class LoggerProxy
{
    private $logger;

    public function setLogger($logger){
        $this->logger = $logger;
    }

    public function init($config){
        $this->logger->init($config);
    }

    public function info($message = '')
    {
        $this->logger->info(strtoupper($message));
    }

    public function debug($message = '')
    {
        $this->logger->debug(strtoupper($message));
    }

    public function error($message = '')
    {
        $this->logger->error(strtoupper($message));
    }
}