<?php

namespace Cart;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller
{
    private $repository;

    private $validator;

    public function __construct(Repository $repository, Validator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function show(Request $request)
    {
        $cart = $this->repository->findItems();

        return new JsonResponse(array_map(function($item) {
            return $item->toArray();
        }, $cart));
    }

    public function store(Request $request)
    {
        $this->validator->validateStoreRequest($request);

        $item = (new Item)
            ->setBookId($request->request->get('book_id'))
            ->setAmount($request->request->get('amount'));

        $this->repository->save($item);

        return new JsonResponse([
            'success' => true
        ]);
    }
}
