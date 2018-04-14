<?php

$app->get('/cart', 'cart.controller:show');

$app->post('/cart', 'cart.controller:store');
