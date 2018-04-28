<?php

namespace Order\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    private $id;

    /**
     * One Order has Many BookItems.
     * @ORM\OneToMany(targetEntity="Books\Entities\BookItem", mappedBy="order")
     **/
    private $bookItems;

    /**
     * @ORM\Column(type="string")
     **/
    private $email;

    /**
     * @ORM\Column(type="integer")
     **/
    private $amount;

    /**
     * @ORM\Column(type="integer")
     **/
    private $cardLastFour;

    /**
     * @ORM\Column(type="string")
     **/
    private $confirmationNumber;

    /**
     * @ORM\Column(type="datetime")
     **/
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     **/
    private $createdAt;

    public function __construct()
    {
        $this->bookItems = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;

        return $this;
    }

    public function getBookItems()
    {
        return $this->bookItems;
    }

    public function setBookItems($value)
    {
        $this->bookItems = $value;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $this->email = $value;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($value)
    {
        $this->amount = $value;

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

    public function getConfirmationNumber()
    {
        return $this->confirmationNumber;
    }

    public function setConfirmationNumber($value)
    {
        $this->confirmationNumber = $value;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($value)
    {
        $this->updatedAt = $value;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($value)
    {
        $this->createdAt = $value;

        return $this;
    }

    public function generateConfirmationNumber($length = 16)
    {
        $alphabet = 'ABCDEFGHIJKMNPQRSTUVWXYZ0123456789';

        $this->confirmationNumber = substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);

        return $this;
    }
}
