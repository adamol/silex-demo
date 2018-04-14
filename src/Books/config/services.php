<?php

$app['books.repository'] = function($app) {
    return new Books\Repository($app['db']);
};

$app['books.controller'] = function() use ($app) {
    return new Books\Controller(
        $app['books.repository'],
        $app['books.validator']
    );
};

$app['books.validator'] = function() use ($app) {
    return new Books\Validator($app['validator']);
};
