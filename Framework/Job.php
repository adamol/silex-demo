<?php

namespace Framework;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="books")
 */
class Job
{
    const JOBS_LIST = [
        'image_resize', 'send_email'
    ];

    const STATUS_LIST = [
        'pending', 'failed', 'done'
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    private $id;

    /**
     * @ORM\Column(type="string")
     **/
    private $status;

    /**
     * @ORM\Column(type="string")
     **/
    private $type;

    /**
     * @ORM\Column(type="string")
     **/
    private $options;

    public function __construct($id, $status, $type, $options)
    {
        $this->id = $id;
        $this->status = $status;
        $this->type = $type;
        $this->options = $options;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($value)
    {
		if (!in_array($status, self::STATUS_LIST)) {
            throw new \InvalidArgumentException("Invalid status");
        }

        $this->status = $value;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($value)
    {
		if (!in_array($value, self::JOBS_LIST)) {
            throw new \InvalidArgumentException("Invalid status");
        }

        $this->type = $value;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($value)
    {
        $this->options = $value;

        return $this;
    }
}
