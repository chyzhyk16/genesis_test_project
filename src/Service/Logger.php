<?php

namespace App\Service;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Logger
{
    const ERROR = 'ERROR';
    const DEBUG = 'DEBUG';
    const INFO = 'INFO';

    public function log(string $type, string $message)
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('log', false, false, false, false);

        $msg = new AMQPMessage('[' . $type . '] : ' . $message . '');
        $channel->basic_publish($msg, '', 'log');

        $channel->close();
        $connection->close();
    }

}