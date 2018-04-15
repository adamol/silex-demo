<?php

$app['auth.token_generator'] = function($app) {
    return new Auth\TokenGenerator(
        $app['encryption.method'],
        $app['encryption.key']
    );
};

$app['auth.password_hasher'] = function() {
    return new Auth\PasswordHasher();
};

$app['auth.authenticator'] = function($app) {
    return new Auth\Authenticator($app['auth.repository']);
};

$app['auth.repository'] = function($app) {
    return new Auth\Repository($app['db']);
};

$app['auth.controller'] = function($app) {
    return new Auth\Controller(
        $app['auth.repository'],
        $app['auth.token_generator'],
        $app['auth.password_hasher']
    );
};
