<?php

$app['posts.repository'] = function($app) {
    return new Posts\Repository($app['db']);
};

$app['posts.controller'] = function() use ($app) {
    return new Posts\Controller(
        $app['posts.repository'],
        $app['posts.validator']
    );
};

$app['posts.validator'] = function() use ($app) {
    return new Posts\Validator($app['validator']);
};
