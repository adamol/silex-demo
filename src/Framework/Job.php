<?php

namespace Framework;

class Job
{
    private $id;

    private $status;

    private $type;

    private $options;

    public function __construct($id, $status, $type, $options)
    {
        $this->id = $id;
        $this->status = $status;
        $this->type = $type;
        $this->options = $options;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($value)
    {
        $this->status = $value;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($value)
    {
        $this->type = $value;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($value)
    {
        $this->options = $value;

        return $this;
    }
}
