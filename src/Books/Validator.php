<?php

namespace Books;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;
use Framework\BaseValidator;

class Validator extends BaseValidator
{
    public function validateStoreRequest(Request $request)
    {
        $constraints = new Constraints\Collection([
            'title' => new Constraints\NotBlank(),
            'description' => new Constraints\NotBlank(),
            'image_path' => new Constraints\NotBlank(),
            'page_count' => new Constraints\NotBlank(),
            'published_date' => new Constraints\NotBlank(),
        ]);

        $this->validate($request->request->all(), $constraints);
    }
}
