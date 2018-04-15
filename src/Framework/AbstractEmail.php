<?php

abstract class AbstractEmail
{
    public function getFrom()
    {
        return ['adamol1992@gmail.com' => 'Adam Olsson'];
    }

    public function getBody()
    {
        ob_start();
        $this->getTemplate();
        return ob_get_clean();
    }

    abstract public function getSubject();

    abstract public function getTemplate();
}
