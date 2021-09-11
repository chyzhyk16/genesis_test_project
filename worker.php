<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('log', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    if (str_contains($msg->body, 'INFO')) {
        echo ' [x] Received ', $msg->body, "\n";
    }
};

$channel->basic_consume('log', '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}