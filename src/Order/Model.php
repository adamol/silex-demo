<?php

namespace Order;

class Model
{
    private $id;

    private $items;

    private $email;

    private $amount;

    private $cardLastFour;

    private $confirmationNumber;

    public function getItems()
    {
        return $this->items;
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getConfirmationNumber()
    {
        return $this->confirmationNumber;
    }

    public function setItems($value)
    {
        $this->items = $value;

        return $this;
    }

    public function setEmail($value)
    {
        $this->email = $value;

        return $this;
    }

    public function setAmount($value)
    {
        $this->amount = $value;

        return $this;
    }

    public function generateConfirmationNumber($length = 16)
    {
        $alphabet = 'ABCDEFGHIJKMNPQRSTUVWXYZ0123456789';

        $this->confirmationNumber = substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);

        return $this;
    }

    public function getCardLastFour()
    {
        return $this->cardLastFour;
    }

    public function setCardLastFour($value)
    {
        $this->cardLastFour = $value;

        return $this;
    }
}
