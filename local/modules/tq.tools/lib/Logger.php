<?php


namespace TQ\Tools;


class Logger extends Singleton
{



    protected function __construct()
    {

    }


    public function writeLog(string $message): void
    {
        $date = date('Y-m-d H:i:s');
        $writeMessage = sprintf('%s: %s',$date,$message);
        echo $writeMessage;
        \Bitrix\Main\Diag\Debug::writeToFile($writeMessage,"","/log.log");
    }

    public static function log(string $message): void
    {
        $logger = static::getInstance();
        $logger->writeLog($message);
    }

}