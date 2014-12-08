<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('logselastic', false, false, false, false);
$channel->queue_declare('logsmongo', false, false, false, false);

$data = "Elastic Hello World!";
$data2 = "Mongo Hello World!";

$msg = new AMQPMessage($data, array('delivery_mode' => 2));
$msg2 = new AMQPMessage($data2, array('delivery_mode' => 2));

$channel->basic_publish($msg, '', 'logselastic');
$channel->basic_publish($msg2, '', 'logsmongo');


echo " [x] Sent :",$data," \n";

$channel->close();
$connection->close();

?>