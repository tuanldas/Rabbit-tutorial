<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

// Tạo một kết nối tời máy chủ
$connection = new AMQPStreamConnection('rabbit', 5672, 'tuanld', '123123');
$channel = $connection->channel();

// Khai báo hàng đợi sẽ tiêu thụ
$channel->queue_declare('hello', false, false, false, false);
echo " [*] Waiting for messages. To exit press CTRL+C\n";
$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
};

$channel->basic_consume('hello', '', true, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}
