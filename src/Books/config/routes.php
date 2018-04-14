<?php

$app->get('/books', 'books.controller:index');

$app->get('/books/{bookId}', 'books.controller:index');

$app->post('/books', 'books.controller:store');
