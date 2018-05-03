<?php

namespace Books;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Auth\Authenticator;
use Framework\JobsRepository;
use Framework\FileUploader;

class Controller
{
    private $repository;

    private $validator;

    private $authenticator;

    private $jobRepository;

    private $fileUploader;

    public function __construct(Repository $repository, Validator $validator, Authenticator $authenticator, JobsRepository $jobRepository, FileUploader $fileUploader)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->authenticator = $authenticator;
        $this->jobRepository = $jobRepository;
        $this->fileUploader = $fileUploader;
    }

    public function index(Request $request)
    {
        if ($request->query->has('categories')) {
            $categories = explode(',', $request->query->get('categories'));
            $books = $this->repository->findByCategories($categories);
        } else {
            $books = $this->repository->findAll();
        }
        var_dump($books); die();

        return new JsonResponse(array_map(function($book) {
            return $book->toArray();
        }, $books));
    }

    public function store(Request $request)
    {
        $this->validator->validateStoreRequest($request);
        $this->authenticator->verifyAdminRequest($request);

        $imagePaths = $this->fileUploader->uploadFiles($request->files, 'images/book_covers/');
        $this->jobRepository->scheduleImageResize($imagePaths);

        $book = (new Model())
            ->setTitleAndSlug($request->request->get('title'))
            ->setImagePath($image)
            ->setDescription($request->request->get('description'))
            ->setPageCount($request->request->get('page_count'))
            ->setPublishedDate($request->request->get('published_date'));

        $lastInsertedId = $this->repository->save($book);

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
        $book = $this->repository->findById($bookId);

        return new JsonResponse($book->toArray());
    }
}
