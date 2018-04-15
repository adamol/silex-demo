<?php

$app['order.controller'] = function($app) {
    return Order\Controller(
        $app['order.validator'],
        $app['order.payment.stripe_gateway'],
        $app['cart.repository'],
        $app['cart.item.repository'],
        $app['order.repository'],
        $app['mailer']
    );
};

$app['order.repository'] = function($app) {
    return new Order\Repository($app['db']);
};

$app['order.payment.stripe_gateway'] = function($app) {
    return new Payment\StripeGateway.php($app['http_client'], $app['stripe.api_key']);
};

$app['order.validator'] = function($app) {
    return Order\Validator($app['validator']);
};
