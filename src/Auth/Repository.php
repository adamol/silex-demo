<?php

namespace Auth;

class Repository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findUserByUsername($username)
    {
        $sql = '
            SELECT id, username, password, token, tokenTimestamp, createdAt, updatedAt
            FROM users
            WHERE username = ?
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$username]);

        return $this->hydrateEntry($stmt->fetch());
    }

    public function findUserByToken($token)
    {
        $sql = '
            SELECT id, role, username, password, token, tokenTimestamp, createdAt, updatedAt
            FROM users
            WHERE token = ?
        ';

        $stmt = $this->db->prepare($sql);

        $entry = $stmt->execute([$token]);

        return $this->hydrateEntry($stmt->fetch());
    }

    public function updateTokenForUser($user, $token)
    {
        $sql = '
            UPDATE users
            SET token=?, token_timestamp=NOW()
            WHERE id=?
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute($token, $user->getId());

        return $this->db->rowCount();
    }

    public function save(User $user)
    {
        $sql = '
            INSERT INTO users
            (role, username, password, token, tokenTimestamp)
            VALUES
            ?, ?, ?, ?, NOW()
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->exec([$user->getRole(), $user->getUsername(), $user->getToken()]);
    }

    public function clearTokenInfo($token)
    {
        $sql = '
            UPDATE users
            SET token=null, token_timestamp=null
            WHERE token=?
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute($token);

        return $this->db->rowCount();
    }

    private function hydrateEntry(array $entry)
    {
        return (new User)
            ->setId($entry['id'])
            ->setRole($entry['role'])
            ->setUsername($entry['username'])
            ->setPassword($entry['password'])
            ->setToken($entry['token'])
            ->setTokenTimestamp($entry['token_timestamp'])
            ->setCreatedAt($entry['created_at'])
            ->setUpdatedAt($entry['updated_at']);
    }
}

