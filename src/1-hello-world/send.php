<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Tạo một kết nối tời máy chủ
$connection = new AMQPStreamConnection('rabbit', 5672, 'tuanld', '123123');
$channel = $connection->channel();

// Tạo một hàng đợi để gửi đến. Sau đó xuất bản một tin nhắn
$channel->queue_declare('hello', false, false, false, false);
$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');
echo " [x] Sent 'Hello World!'\n";

// Một hàng đợi là idempotent - nó chỉ được tạo nếu không tồn tại. Nội dung tin nhắn là mảng byte, vì vậy có thể mã hóa bất kỳ thừ gì ở đó.

// Đóng kết nối
$channel->close();
$connection->close();
