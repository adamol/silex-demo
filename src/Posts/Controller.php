<?php

namespace Posts;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller
{
    protected $repo;

    public function __construct(Repository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return new JsonResponse(array_map(function($post) {
            return $post->toArray();
        }, $this->repo->findAll()));
    }

    public function store(Request $request)
    {
        var_dump($request->request->get('title'));
        if (! $request->request->has('title')) {
            throw new \InvalidArgumentException('Missing required title parameter.');
        }
        if (! $request->request->has('body')) {
            throw new \InvalidArgumentException('Missing required body parameter.');
        }

        $post = new Model(
            $request->request->get('title'),
            $request->request->get('body')
        );

        if ($this->repo->save($post)) {
            return new JsonResponse([
                'success' => true
            ]);
        } else {
            return new JsonResponse([
                'success' => false,
                'message' => 'Something went wrong. Could not persist record to database'
            ]);
        }
    }
}
