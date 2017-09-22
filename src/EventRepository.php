<?php

namespace App;

class EventRepository
{
    private $events = [
        [
            'name'          => 'product_updated',
            'subject_id'    => 1880,
            'subscriber'    => 1,
            'published'      => 0
        ],
        [
            'name'          => 'product_updated',
            'subject_id'    => 1881,
            'subscriber'    => 1,
            'published'      => 0
        ],
        [
            'name'          => 'product_updated',
            'subject_id'    => 1881,
            'subscriber'    => 2,
            'published'      => 0
        ],
    ];

    /**
     * @return int
     */
    public function totalUnpublishedEvents()
    {
        $totalEvents = 0;
        foreach ($this->events as $event) {
            if (0 === $event['published']) {
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
            if (0 === $event['published']) {
                array_push(
                    $events,
                    (new Event(
                        $event['name'],
                        $event['subject_id'],
                        $event['subscriber'],
                        $event['published']
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

        $this->events[$event->id()]['published'] = 1;
    }

    public function add(Event $event)
    {
        array_push($this->events, [
            'name'          => $event->name(),
            'subject_id'    => $event->subjectId(),
            'subscriber'    => $event->subscriber(),
            'published'      => $event->published()
        ]);
    }
}