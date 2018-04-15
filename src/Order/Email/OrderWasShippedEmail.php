<?php

namespace Order\Email;

use Framework\AbstractEmail;
use Framework\Queueable;

class OrderWasShippedEmail extends AbstractEmail
{
    private $order;

    public function __construct(Model $order)
    {
        $this->order = $order;
    }

    public function getSubject()
    {
        return 'Order Was Shipped';
    }

    public function getTemplate()
    {
        $orderUrlPath = "http://localhost:8080/orders/{$this->order->getConfirmationNumber()}";
        include 'order_was_shipped_template.php';
    }
}
