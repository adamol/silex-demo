<?php

namespace Auth;

class PasswordHasher
{
    public function hash($value)
    {
        return password_hash($value, PASSWORD_BCRYPT, ['cost' => 8]);

    }

    public function verify($password, $bash)
    {
        return password_verify($password, $hash);
    }
}

