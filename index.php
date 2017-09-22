<?php

require  __DIR__ . '/vendor/autoload.php';

$eventRepository = new App\EventRepository();
$userConnections = new ArrayIterator();
$eventPublisher = new App\EventPublisherService(
    $eventRepository, $userConnections
);

$loop = React\EventLoop\Factory::create();
$loop->addPeriodicTimer(5, [$eventPublisher, 'execute']);


$app = new Ratchet\App('127.0.0.1', 8000, '127.0.0.1', $loop);

$app->route(
    '/user',
    new App\UserConnection($userConnections),
    ['*']
);

$app->route(
    '/event',
    new App\EventConnection($eventRepository),
    ['*']
);

$app->run();