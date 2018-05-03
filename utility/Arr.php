<?php

class Arr
{
    private $array;

    public function __construct($array = [])
    {
        $this->array = $array;
    }

    public static function create($array = [])
    {
        return new self($array);
    }

    public function ucfirst()
    {
        $this->array = ucfirst($array);
    }

    public function implode($key)
    {
        return new Str(implode($key, $this->array));
    }
}
