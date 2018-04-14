<?php

namespace Cart;

use Symfony\Component\HttpFoundation\Session\Session;

class Repository
{
    /**
     * Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function save(Item $item)
    {
        $cart = $this->session->get('cart', []);

        $cart[] =  $item;

        $this->session->set('cart', $cart);
    }

    public function findItems()
    {
        return $this->session->get('cart');
    }
}
