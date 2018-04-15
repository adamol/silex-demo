<?php

namespace Books\Item;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller
{
    public function store($bookId, Request $request)
    {
        $item = (new Model)->setCode($request->request->get('code'));

        $this->repository->save($item);
    }
}
