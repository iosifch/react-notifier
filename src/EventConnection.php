<?php

namespace App;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class EventConnection implements MessageComponentInterface
{
    protected $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    function onOpen(ConnectionInterface $conn) {}

    function onClose(ConnectionInterface $conn) {}

    function onError(ConnectionInterface $conn, \Exception $e) {}

    function onMessage(ConnectionInterface $from, $msg)
    {
        $message = json_decode($msg, true);

        $this->eventRepository->add(new Event(
            $message['event_name'],
            $message['subject_id'],
            $message['user'],
            0
        ));

        echo 'new event published' . PHP_EOL;
        echo $this->eventRepository->count() . PHP_EOL;
    }
}