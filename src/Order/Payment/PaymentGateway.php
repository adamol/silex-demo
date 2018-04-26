<?php

namespace Order\Payment;

interface PaymentGateway
{
    public function charge($amount, $token, $email);
}

