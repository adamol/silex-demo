<?php

namespace Categories\Entities;

use Categories\Entities\BookCategory;
use Books\Entities\Book;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Categories\Repository")
 * @ORM\Table(name="categories")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Categories\Entities\BookCategory", mappedBy="book")
     **/
    private $bookCategories;

    /**
     * @ORM\Column(type="string")
     **/
    private $type;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     **/
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     **/
    private $updatedAt;

    public function __construct()
    {
        $this->bookCategories = new ArrayCollection();
    }

    /**
	* @param Categories\Entities\BookCategory
    */
    public function addBookCategory(BookCategory $bookCategory)
    {
        if ($this->bookCategories->contains($bookCategory)) {
            return;
        }

        $this->bookCategories->add($bookCategory);

        $bookCategory->setCategory($this);
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

    public function getType()
    {
        return $this->type;
    }

    public function setType($value)
    {
        $this->type = $value;

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

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($value)
    {
        $this->updatedAt = $value;

        return $this;
    }
}
