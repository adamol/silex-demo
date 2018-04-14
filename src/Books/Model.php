<?php

namespace Books;

class Model
{
    private $title;

    private $body;

    private $id;

    public function __construct($title, $body, $id = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'body' => $this->getBody()
        ];
    }
}
