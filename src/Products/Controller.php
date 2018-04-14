<?php

namespace Products;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class Controller
{
    private $repository;

    private $validator;

    public function __construct(Repository $repository, Validator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function index()
    {
        return new JsonResponse(array_map(function($post) {
            return $post->toArray();
        }, $this->repository->findAll()));
    }

    public function store(Request $request)
    {
        $this->validator->validateStoreRequest($request);

        $post = new Model(
            $request->request->get('title'),
            $request->request->get('body')
        );

        $lastInsertedId = $this->repository->save($post);

        if (! $lastInsertedId) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Something went wrong. Could not persist record to database'
            ]);
        }

        return new JsonResponse([
            'success' => true,
            'last_inserted_id' => $lastInsertedId
        ]);
    }

    public function show($productId)
    {
        $product = $this->repository->findBy('id', $productId);

        return new JsonResponse($product->toArray());
    }
}
