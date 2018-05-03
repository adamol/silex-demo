<?php

trait InstantiatsFromArray
{
    public static function fromArray(array $data)
    {
        $instance = new self;

        foreach ($data as $key => $value) {
            $setter = $this->createSetter($key);

            $instance->{$setter}($value);
        }

        return $instance;
    }

    public function createSetter($key)
    {
        return Str::create($key)
            ->explode('_')
            ->ucfirst()
            ->implode('')
            ->prefix('set');
    }
}
