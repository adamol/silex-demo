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
            'book_id' => new Constraints\NotBlank(),
            'amount' => new Constraints\NotBlank(),
        ]);

        $this->validate($request->request->all(), $constraints);
    }
}
