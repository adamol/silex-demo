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
            (title, slug, image_path, description, page_count, price, published_date, created_at)
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
            $book->getPrice(),
            $book->getPublishedDate()
        ]);

        return $this->db->lastInsertId();
    }

    public function update(Model $book)
    {
        $sql = '
            UPDATE books SET
            title=?, slug=?, image_path=?, description=?, page_count=?, price=?, published_date=?
            WHERE
            id=?
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $book->getTitle(),
            $book->getSlug(),
            $book->getImagePath(),
            $book->getDescription(),
            $book->getPageCount(),
            $book->getPrice(),
            $book->getPublishedDate(),
            $book->getId()
        ]);

        return $this->db->rowCount();
    }

    public function findAll()
    {
        $sql = '
            SELECT
                books.id, books.title, books.slug, books.image_path, books.description, books.page_count,
                books.price, books.published_date, books.created_at, books.updated_at,
                GROUP_CONCAT(categories.type) as comma_seperated_categories
            FROM books
            JOIN book_category ON book_category.book_id = book.id
            JOIN categories ON categories.id = book_category.category_id
            GROUP BY books.id
        ';

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return array_map(function($entry) {
            return $this->hydrateEntry($entry);
        }, $stmt->fetchAll());
    }

    public function findByCategories($categories)
    {
        $sql = '
            SELECT
                books.id, books.title, books.slug, books.image_path, books.description, books.page_count,
                books.price, books.published_date, books.created_at, books.updated_at,
                GROUP_CONCAT(categories.type) as comma_seperated_categories
            FROM books
            JOIN book_category ON book_category.book_id = book.id
            JOIN categories ON categories.id = book_category.category_id
            WHERE categories.type IN ?
            GROUP BY books.id
        ';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categories]);

        return array_map(function($entry) {
            return $this->hydrateEntry($entry);
        }, $stmt->fetchAll());
    }

    public function findById($id)
    {
        $sql = "
            SELECT
                id, title, slug, image_path, description, page_count,
                price, published_date, created_at, updated_at
            FROM books WHERE id=?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $entry = $stmt->fetch();

        return $this->hydrateEntry($entry);
    }

    protected function hydrateEntry()
    {
        return (new Model)
            ->setId($entry['id'])
            ->setTitle($entry['title'])
            ->setSlug($entry['slug'])
            ->setImagePath($entry['image_path'])
            ->setDescription($entry['description'])
            ->setPageCount($entry['page_count'])
            ->setPrice($entry['price'])
            ->setPublishedDate($entry['published_date'])
            ->setCategories($entry['comma_seperated_categories'])
            ->setCreatedAt($entry['created_at'])
            ->setUpdatedAt($entry['updated_at']);
    }
}

