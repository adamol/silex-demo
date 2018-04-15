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

    public function save(Item\Model $item, $sessionId)
    {
        $cart = $this->session->get($this->getCartKey($sessionId), new Model);

        $cart->append($item);

        $this->session->set($this->getCartKey($sessionId), $cart);
    }

    public function get($sessionId)
    {
        return $this->session->get($this->getCartKey($sessionId));
    }

    private function getCartKey($sessionId)
    {
        // This namespacing is only really necessary to fix tests
        // but it also doesn't affect the working code.
        return 'cart'.$sessionId;
    }
}
