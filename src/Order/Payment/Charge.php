<?php

namespace Order\Payment;

class Charge
{
    private $amount;

    private $cardLastFour;

    public function __construct($amount, $cardLastFour)
    {
        $this->amount = $amount;

        $this->cardLastFour = $cardLastFour;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCardLastFour()
    {
        return $this->cardLastFour;
    }
}
