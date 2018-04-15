<?php

class Storage
{
    public function get($path)
    {
        return file_get_contents($path);
    }

    public function put($path, $contents)
    {
        file_put_contents($path, $contents);
    }
}
