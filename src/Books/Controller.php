<?php

namespace Books;

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

    public function index()
    {
        return new JsonResponse(array_map(function($post) {
            return $post->toArray();
        }, $this->repository->findAll()));
    }

    public function store(Request $request)
    {
        $this->validator->validateStoreRequest($request);

        $post = (new Model())
            ->setTitleAndSlug($request->request->get('title'))
            ->setImagePath(Model::generateImagePath($request->request->get('image_path')))
            ->setDescription($request->request->get('description'))
            ->setPageCount($request->request->get('page_count'))
            ->setPublishedDate($request->request->get('published_date'));

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

    public function show($bookId)
    {
        $book = $this->repository->findBy('id', $bookId);

        return new JsonResponse($book->toArray());
    }
}