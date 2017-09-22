<?php

namespace App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class UserConnection implements MessageComponentInterface
{
    protected $userConnections;

    public function __construct(\ArrayIterator $userConnections)
    {
        $this->userConnections = $userConnections;
    }

    function onOpen(ConnectionInterface $conn)
    {
        echo 'connected' . PHP_EOL;
    }

    function onClose(ConnectionInterface $conn)
    {
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
    }

    function onMessage(ConnectionInterface $from, $msg)
    {
        $message = json_decode($msg, true);

        if (empty($message['id'])) {
            $from->send(json_encode([
                'error'     => true,
                'message'   => 'missing user id'
            ]));

            $from->close();

            return;
        }

        $this->userConnections->offsetSet($message['id'], $from);
    }
}