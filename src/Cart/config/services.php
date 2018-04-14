<?php

$app['cart.controller'] = function($app) {
    return new Cart\Controller($app['cart.repository'], $app['cart.validator']);
};

$app['cart.validator'] = function() use ($app) {
    return new Cart\Validator($app['validator']);
};

$app['cart.repository'] = function() use ($app) {
    return new Cart\Repository($app['session']);
};
