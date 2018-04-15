<?php

namespace Auth;

class TokenGenerator
{
    private $token;

    private $encryptionMethod;

    private $encryptionKey;

    public function __construct($encryptionMethod, $encryptionKey)
    {
        $this->encryptionMethod = $encryptionMethod;
        $this->encryptionKey = $encryptionKey;
    }

    public function generateForUser($username, $password)
    {
        $this->token = implode('.', [
            $this->encrypt($username),
            $this->encrypt($password),
            $this->encrypt($this->randomString()),
        ]);
    }

    protected function encrypt($value)
    {
        return openssl_encrypt($value, $this->encryptionMethod, $this->encryptionKey);
    }

    public function randomString()
    {
        $alphabet = 'ABCDEFGHIJKMNPQRSTUVWXYZ0123456789';

        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }

    public function __toString()
    {
        return $this->token;
    }
}
