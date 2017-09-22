<?php

require  __DIR__ . '/vendor/autoload.php';

$eventRepository = new App\EventRepository();
$userConnections = new ArrayIterator();

$loop = React\EventLoop\Factory::create();
$loop->addPeriodicTimer(5, function() use ($eventRepository, $userConnections) {
    $unpublishedEvents = $eventRepository->fetchUnblishedEvents();
    foreach ($unpublishedEvents as $event) {
        if (!$userConnections->offsetExists($event->subscriber())) {
            continue;
        }

        $userConnection = $userConnections
            ->offsetGet($event->subscriber());
        $userConnection->send(json_encode([
            'event_name' => $event->name(),
            'subject_id' => $event->subjectId()
        ]));

        $eventRepository->markAsPublished($event);
    }
});


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