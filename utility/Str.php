<?php

class Str
{
    private $string;

    public function __construct($string = '')
    {
        $this->string = $string;
    }

    public static function create($string = '')
    {
        return new self($string);
    }

    public function explode($key)
    {
        return new Arr(explode($key, $this->string));
    }

    public function prefix($prefix)
    {
        $this->string = $prefix.$this->string;
    }

    public function __toString()
    {
        return $this->string;
    }
}
