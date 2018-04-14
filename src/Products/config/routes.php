<?php

$app->get('/products', 'products.controller:index');

$app->get('/products/{productId}', 'products.controller:index');

$app->post('/products', 'products.controller:store');
