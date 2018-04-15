<?php

namespace Auth;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;
use Framework\BaseValidator;

class Validator extends BaseValidator
{
    public function validateSignUp($request)
    {
        $constraints = new Constraints\Collection([
            'username' => new Constraints\NotBlank(),
            'password' => new Constraints\NotBlank(),
            'verify_password' => new Constraints\EqualTo(
                $request->request->get('password')
            ),
        ]);

        $this->validate($request->request->all(), $constraints);
    }

    public function validateSignIn($request)
    {
        $constraints = new Constraints\Collection([
            'username' => new Constraints\NotBlank(),
            'password' => new Constraints\NotBlank(),
        ]);

        $this->validate($request->request->all(), $constraints);
    }

    public function validateSignOut($request)
    {
        $constraints = new Constraints\Collection([
            'token' => new Constraints\NotBlank(),
        ]);

        $this->validate($request->request->all(), $constraints);
    }
}

