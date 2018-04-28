<?php

namespace Auth;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller
{
    private $repository;

    private $tokenGenrator;

    private $passwordHasher;

    public function __construct(Repository $repository, TokenGenerator $tokenGenerator, PasswordHasher $passwordHasher)
    {
        $this->repository = $repository;
        $this->tokenGenerator = $tokenGenerator;
        $this->passwordHasher = $passwordHasher;
    }

    public function signUp(Request $request)
    {
        $this->validator->validateSignUp($request);

        $hashedPassword = $this->passwordHasher->has($request->query->get('password'));

        $user = (new User)
            ->setUsername($request->query->get('username'))
            ->setPassword($hashedPassword)
            ->setRole('customer');

        $token = $this->tokenGenerator->generateForUser($user);

        $user->setToken($token);

        $this->repository->save($user);

        return JsonResponse(['success' => true, 'token' => $token]);
    }

    public function signIn(Request $request)
    {
        $this->validator->validateSignIn($request);

        $user = $this->repository->findUserByUsername($request->request->get('username'));

        $valid = $this->passwordHasher->verify(
            $request->request->get('password'),
            $user->getPassword()
        );

        if (! $valid) {
            return JsonResponse(['success' => false]);
        }

        $token = $this->tokenGenerator->generateForUser($user);

        $this->repository->updateTokenForUser($user, $token);

        return JsonResponse(['success' => true, 'token' => $token]);
    }

    public function signOut(Request $request)
    {
        $this->validator->validateSignOut($request);

        $this->repository->clearTokenInfo($request->query->get('token'));

        return JsonRepsonse(['success' => true]);
    }
}
