<?php

$app['categories.repository'] = function($app) {
    return $app['doctrine.entity_manager']->getRepository('Categories\Entities\Category');
};
