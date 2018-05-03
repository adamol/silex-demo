<?php

$app['books.repository'] = function($app) {
    return $app['doctrine.entity_manager']->getRepository('Books\Entities\Book');
};

$app['books.controller'] = function($app) {
    return new Books\Controller(
        $app['books.repository'],
        $app['books.validator'],
        $app['auth.authenticator'],
        $app['jobs.repository'],
        $app['file_uploader']
    );
};

$app['books.validator'] = function($app) {
    return new Books\Validator($app['validator']);
};

$app['books.item.repository'] = function($app) {
    return $app['doctrine.entity_manager']->getRepository('Books\Entities\BookItem');
    return new Books\Item\Repository($app['db']);
};

$app['books.image_resizer'] = function($app) {
    return new Books\ImageResizer($app['image_manager'], $app['storage']);
};

$app['books.items.controller'] = function() {
    return new Books\Item\Controller();
};

