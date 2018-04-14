<?php

$app['products.repository'] = function($app) {
    return new Products\Repository($app['db']);
};

$app['products.controller'] = function() use ($app) {
    return new Products\Controller(
        $app['products.repository'],
        $app['products.validator']
    );
};

$app['products.validator'] = function() use ($app) {
    return new Products\Validator($app['validator']);
};
