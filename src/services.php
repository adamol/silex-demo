<?php

$app['db'] = function() {
    return getenv('environment') === 'testing'
        ? new PDO('sqlite::memory:')
        : new PDO('mysql:host=localhost;dbname=silex_demo', getenv('DB_USER'), getenv('DB_PASS'));
};

$app['posts.repository'] = function($app) {
    return new Posts\Repository($app['db']);
};

$app['posts.controller'] = function() use ($app) {
    return new Posts\Controller($app['posts.repository']);
};
