<?php

namespace App;

class Event
{
    protected $id;

    protected $name;

    protected $subjectId;

    protected $subscriber;

    protected $notified;

    public function __construct($name, $subjectId, $subscriber, $notified)
    {
        $this->name = $name;
        $this->subjectId = $subjectId;
        $this->subscriber = $subscriber;
        $this->notified = $notified;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function subjectId()
    {
        return $this->subjectId;
    }

    public function subscriber()
    {
        return $this->subscriber;
    }

    public function notified()
    {
        return $this->notified;
    }
}