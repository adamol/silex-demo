<?php

if (! function_exists('tap')) {
    function tap($input, callable $callback) {
        return $callback($input);
    }
}
