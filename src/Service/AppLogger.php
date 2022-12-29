<?php

namespace App\Service;

use think\LogManager;

class AppLogger
{
    const TYPE_LOG4PHP = 'log4php';

    const THINK_LOG = 'think-log';

    private $logger;

    //简单工厂模式
    public function __construct($type = self::TYPE_LOG4PHP)
    {
        if ($type == self::TYPE_LOG4PHP) {
            $this->logger = \Logger::getLogger("Log");
        }else if($type == self::THINK_LOG){
            //代理模式
            $logManager = new LogManager();
            $logManager->init([
                'default'      => 'file',
                'channels'    =>    [
                    'file'    =>    [
                        'type'          => 'file',
                        'path'          => '../../logs/',
                    ],
                ],
            ]);
            $loggerProxy = new LoggerProxy();
            $loggerProxy->setLogger($logManager);

            $this->logger = $loggerProxy;
        }
    }

    public function info($message = '')
    {
        $this->logger->info($message);
    }

    public function debug($message = '')
    {
        $this->logger->debug($message);
    }

    public function error($message = '')
    {
        $this->logger->error($message);
    }
}