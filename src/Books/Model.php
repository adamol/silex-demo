<?php

namespace Books;

class Model
{
    const BOOK_COVER_IMAGE_PATH = 'images/book_covers/';

    private $id;

    private $title;

    private $slug;

    private $imagePath;

    private $description;

    private $pageCount;

    private $publishedDate;

    private $updatedAt;

    private $createdAt;

    public function setId($value)
    {
        $this->id = $value;

        return $this;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function setTitleAndSlug($value)
    {
        return $this
            ->setTitle($value)
            ->setSlug(str_replace(' ', '-', strtolower($value)));
    }

    public function setTitle($value)
    {
        $this->title = $value;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath($value)
    {
        $this->imagePath = $value;

        return $this;
    }

    public static function generateImagePath($value)
    {
        return self::BOOK_COVER_IMAGE_PATH.md5($value).'.jpg';
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;

        return $this;
    }

    public function getPageCount()
    {
        return $this->pageCount;
    }

    public function setSlug($value)
    {
        $this->slug = $value;

        return $this;
    }

    public function setPageCount($value)
    {
        $this->pageCount = $value;

        return $this;
    }

    public function getPublishedDate()
    {
        // If publishedDate is in format Y-m-d we will return it straight away.
        // Otherwise it is in format Y-m-d H:i:s and we need to format it.
        if (strpos($this->publishedDate, ':') === false) {
            return $this->publishedDate;
        }

        $dateTime = \DateTime::createFromFormat("Y-m-d H:i:s", $this->publishedDate);

        return $dateTime->format('Y-m-d');
    }

    public function setPublishedDate($value)
    {
        $this->publishedDate = $value;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($value)
    {
        $this->createdAt = $value;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($value)
    {
        $this->updatedAt = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
          'id' => $this->getId(),
          'title' => $this->getTitle(),
          'slug' => $this->getSlug(),
          'image_path' => $this->getImagePath(),
          'description' => $this->getDescription(),
          'page_count' => $this->getPageCount(),
          'published_date' => $this->getPublishedDate(),
          'created_at' => $this->getCreatedAt(),
          'updated_at' => $this->getUpdatedAt()
        ];
    }
}
