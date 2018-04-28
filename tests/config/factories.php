<?php

$app['factories.books'] = function($app) {
    return new Factories\BooksFactory($app['books.repository'], $app['db']);
};
