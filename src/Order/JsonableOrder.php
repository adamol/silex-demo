<?php

namespace Order;

class JsonableOrder
{
    private $order;

    private $items;

    public function __construct(array $order, array $items)
    {
        $this->order = $order;
        $this->items = $items;
    }

    public function toArray()
    {
        $array = $this->order;

        $array['item'] = $this->items;

        return $array;
    }
}
