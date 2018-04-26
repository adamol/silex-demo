<?php

namespace Auth;

use Symfony\Component\HttpFoundation\Request;

class Authenticator
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function verifyAdminRequest(Request $request)
    {
        $token = $this->extractToken($request);

        $user = $this->repository->findUserByToken($token);

        $this->verifyTimestampValid($user);

        $this->verifyIsAdmin($user);
    }

    private function extractToken()
    {
        if ($request->request->has('token')) {
            return $request->request->get('token');
        }

        if ($request->query->has('token')) {
            return $request->query->get('token');
        }

        throw new \InvalidArgumentException(
            'This route is only for admins and you failed to provide an authentication token.'
        );
    }

    private function verifyTimestampValid()
    {
        if ($user->getTokentimestamp() < date('Y-m-d H:i:s') - 3600) {
            throw new \InvalidArgumentException('The provided token has expired');
        }
    }

    private function verifyIsAdmin()
    {
        if (! $user->isAdmin()) {
            throw new \InvalidArgumentException(
                'The provided token does not belong to an admin.'
            );
        }
    }
}
