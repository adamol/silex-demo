<?php

$app->get('/posts', 'posts.controller:index');

$app->post('/posts', 'posts.controller:store');
