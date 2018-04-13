<?php

namespace Posts;

class Repository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function save(Model $post)
    {
        $sql = 'INSERT INTO posts (title, body) VALUES (?, ?)';

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$post->getTitle(), $post->getBody()]);

        return $this->db->lastInsertId();
    }

    public function findAll()
    {
        $sql = 'SELECT id, title, body FROM posts';

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return array_map(function($entry) {
            return new Model($entry['title'], $entry['body'], $entry['id']);
        }, $stmt->fetchAll());
    }
}

