<?php

namespace App;

class EventRepository
{
    private $events = [
        [
            'name'          => 'product_updated',
            'subject_id'    => 1880,
            'subscriber'    => 1,
            'notified'      => 0
        ],
        [
            'name'          => 'product_updated',
            'subject_id'    => 1881,
            'subscriber'    => 1,
            'notified'      => 0
        ],
        [
            'name'          => 'product_updated',
            'subject_id'    => 1881,
            'subscriber'    => 2,
            'notified'      => 0
        ],
    ];

    /**
     * @return int
     */
    public function totalUnpublishedEvents()
    {
        $totalEvents = 0;
        foreach ($this->events as $event) {
            if (0 === $event['notified']) {
                $totalEvents++;
            }
        }

        return $totalEvents;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->events);
    }

    /**
     * @return Event[]
     */
    public function fetchUnblishedEvents()
    {
        $events = [];
        foreach ($this->events as $key => $event) {
            if (0 === $event['notified']) {
                array_push(
                    $events,
                    (new Event(
                        $event['name'],
                        $event['subject_id'],
                        $event['subscriber'],
                        $event['notified']
                    ))->setId($key)
                );
            }
        }

        return $events;
    }

    public function markAsPublished(Event $event)
    {
        if (null === $event->id()) {
            return;
        }

        if (empty($this->events[$event->id()])) {
            return;
        }

        $this->events[$event->id()]['notified'] = 1;
    }

    public function add(Event $event)
    {
        array_push($this->events, [
            'name'          => $event->name(),
            'subject_id'    => $event->subjectId(),
            'subscriber'    => $event->subscriber(),
            'notified'      => $event->notified()
        ]);
    }
}