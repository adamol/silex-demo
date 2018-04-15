<?php

namespace Auth;

class TokenRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function validateToken($token)
    {
        $sql = '
            SELECT token, tokenTimestamp
            FROM users
            WHERE token = ?
        ';

        $stmt = $this->db->prepare($sql);

        $entry = $stmt->execute([$username]);

        if ($entry['token_timestamp'] < date('Y-m-d H:i:s') - 3600) {
            throw new \RuntimeException(
                'The token for that user has expired'
            ));
        }

        return $this->hydrateEntry($stmt->fetch());
    }
}
