<?php

namespace Cart;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;

class Validator
{
    private $validator;

    public function __construct($validator)
    {
        $this->validator = $validator;
    }

    public function validateStoreRequest(Request $request)
    {
        $constraints = new Constraints\Collection([
            'book_id' => new Constraints\NotBlank(),
            'amount' => new Constraints\NotBlank(),
        ]);

        $errors = $this->validator->validate($request->request->all(), $constraints);

        if (count($errors) > 0) {
            throw new \InvalidArgumentException(
                'Validation failed: ' . $errors[0]->getMessage()
            );
        }
    }
}
