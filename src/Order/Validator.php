<?php

namespace Cart;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;
use Framework\BaseValidator;

class Validator extends BaseValidator
{
    public function validateStoreRequest(Request $request)
    {
        $constraints = new Constraints\Collection([
            'email' => new Constraints\NotBlank(),
            'payment_token' => new Constraints\NotBlank(),
        ]);

        $this->validate($request->request->all(), $constraints);
    }
}
