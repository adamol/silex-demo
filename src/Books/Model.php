<?php

namespace Books;

class Model
{
    private $id;

    private $title;

    private $slug;

    private $imagePath;

    private $description;

    private $pageCount;

    private $publishedDate;

    private $createdAt;

    private $updatedAt;

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
