<?php

namespace Books;

class Repository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function save(Model $book)
    {
        $sql = '
            INSERT INTO books
            (title, slug, image_path, description, page_count, published_date, created_at)
            VALUES
            (?, ?, ?, ?, ?, ?, null)
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $book->getTitle(),
            $book->getSlug(),
            $book->getImagePath(),
            $book->getDescription(),
            $book->getPageCount(),
            $book->getPublishedDate()
        ]);

        return $this->db->lastInsertId();
    }

    public function update(Model $book)
    {
        $sql = '
            UPDATE books SET
            title=?, slug=?, image_path=?, description=?, page_count=?, published_date=?
            WHERE
            id=?
        ';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $book->getTitle(),
            $book->getSlug(),
            $book->getImagePath(),
            $book->getDescription(),
            $book->getPageCount(),
            $book->getPublishedDate(),
            $book->getId()
        ]);
    }

    public function findAll()
    {
        $sql = '
            SELECT
                id, title, slug, image_path, description, page_count,
                published_date, created_at, updated_at
            FROM books
        ';

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return array_map(function($entry) {
            return (new Model)
                ->setId($entry['id'])
                ->setTitle($entry['title'])
                ->setSlug($entry['slug'])
                ->setImagePath($entry['image_path'])
                ->setDescription($entry['description'])
                ->setPageCount($entry['page_count'])
                ->setPublishedDate($entry['published_date'])
                ->setCreatedAt($entry['created_at'])
                ->setUpdatedAt($entry['updated_at']);
        }, $stmt->fetchAll());
    }

    public function findBy($key, $value)
    {
        $sql = "
            SELECT
                id, title, slug, image_path, description, page_count,
                published_date, created_at, updated_at
            FROM books WHERE $key=?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$value]);

        $entry = $stmt->fetch();

        return (new Model)
            ->setId($entry['id'])
            ->setTitle($entry['title'])
            ->setSlug($entry['slug'])
            ->setImagePath($entry['image_path'])
            ->setDescription($entry['description'])
            ->setPageCount($entry['page_count'])
            ->setPublishedDate($entry['published_date'])
            ->setCreatedAt($entry['created_at'])
            ->setUpdatedAt($entry['updated_at']);
    }
}

