<?php

namespace Framework;

class Validator
{
    private $validator;

    public function __construct($validator)
    {
        $this->validator = $validator;
    }

    public function validate()
    {
        $violations = $this->validator->validate(
            $request->request->all(),
            $constraints
        );

        if (count($violations) > 0) {
            throw new \InvalidArgumentException(
                'Validation failed: ' . $violations[0]->getMessage()
            );
        }
    }
}
