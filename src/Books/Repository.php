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
        $sql = 'INSERT INTO books (title, body) VALUES (?, ?)';

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$book->getTitle(), $book->getBody()]);

        return $this->db->lastInsertId();
    }

    public function findAll()
    {
        $sql = 'SELECT id, title, body FROM books';

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return array_map(function($entry) {
            return new Model($entry['title'], $entry['body'], $entry['id']);
        }, $stmt->fetchAll());
    }

    public function findBy($key, $value)
    {
        $sql = "SELECT id, title, body FROM books WHERE $key=?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$value]);

        $entry = $stmt->fetch();

        return new Model($entry['title'], $entry['body'], $entry['id']);
    }
}

