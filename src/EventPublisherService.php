<?php

namespace App;

class EventPublisherService
{
    private $eventRepository;
    private $userConnections;

    public function __construct(
        EventRepository $eventRepository,
        \ArrayIterator $userConnections
    ) {
        $this->eventRepository = $eventRepository;
        $this->userConnections = $userConnections;
    }

    public function execute()
    {
        $unpublishedEvents = $this->eventRepository->fetchUnblishedEvents();
        foreach ($unpublishedEvents as $event) {
            if (!$this->userConnections->offsetExists($event->subscriber())) {
                continue;
            }

            $userConnection = $this->userConnections
                ->offsetGet($event->subscriber());
            $userConnection->send(json_encode([
                'event_name' => $event->name(),
                'subject_id' => $event->subjectId()
            ]));

            $this->eventRepository->markAsPublished($event);
        }
    }
}