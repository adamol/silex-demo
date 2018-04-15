<?php

$app->get('orders/{confirmationNumber}', 'order.controller:show');

$app->post('orders', 'order.controller:store');
