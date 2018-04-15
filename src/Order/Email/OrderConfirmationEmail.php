<?php

namespace Order\Email;

class OrderConfirmationEmail extends AbstractEmail implements Queueable
{
    private $order;

    public function __construct(Model $order)
    {
        $this->order = $order;
    }

    public function getSubject()
    {
        return 'Order Confirmation';
    }

    public function getTemplate()
    {
        $orderUrlPath = "http://localhost:8080/orders/{$this->order->getConfirmationNumber()}";
        include 'order_confirmation_template.php';
    }
}
