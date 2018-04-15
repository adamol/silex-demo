<?php

namespace Auth;

public function Validator()
{
    public function validateSignUp($request)
    {
        $validRequest =
            $request->request->has('username') &&
            $request->request->has('password') &&
            $request->request->has('verify_password') &&
            $request->request->get('password') === $request->request->get('verify_password');


        if (! $validaRequest) {
            throw new \InvalidArgumentException(
                'Validation failed: ' . $errors[0]->getMessage()
            );
        }
    }

    public function validateSignIn($request)
    {
        $validRequest =
            $request->request->has('username') &&
            $request->request->has('password');


        if (! $validaRequest) {
            throw new \InvalidArgumentException(
                'Validation failed: ' . $errors[0]->getMessage()
            );
        }
    }

    public function validateSignOut($request)
    {
        $validRequest = $request->request->has('token');


        if (! $validaRequest) {
            throw new \InvalidArgumentException(
                'Validation failed: ' . $errors[0]->getMessage()
            );
        }
    }
}
