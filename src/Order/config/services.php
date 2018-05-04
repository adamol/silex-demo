<?php

$app['order.controller'] = function($app) {
    return new Order\Controller(
        $app['order.validator'],
        $app['order.payment.stripe_gateway'],
        $app['cart.repository'],
        $app['books.item.repository'],
        $app['order.repository'],
        $app['mailer'],
        $app['auth.authenticator']
    );
};

$app['order.repository'] = function($app) {
    return $app['doctrine.entity_manager']->getRepository(Order\Entities\Order::class);
};

$app['order.payment.stripe_gateway'] = function($app) {
    return new Order\Payment\StripeGuzzleGateway(
        $app['stripe.api_key'],
        $app['http_client']
    );
};

$app['order.validator'] = function($app) {
    return new Order\Validator($app['validator']);
};
