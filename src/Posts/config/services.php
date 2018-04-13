<?php

$app['posts.repository'] = function($app) {
    return new Posts\Repository($app['db']);
};

$app['posts.controller'] = function() use ($app) {
    return new Posts\Controller($app['posts.repository']);
};
