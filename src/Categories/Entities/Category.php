<?php

namespace Categories\Entities;

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
     * Many Categories have Many Books.
     * @ORM\ManyToMany(targetEntity="Books\Entities\Book")
     * @ORM\JoinTable(name="book_category",
     *     joinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id", unique=true)}
     * )
     **/
    private $books;

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
        $this->books = new ArrayCollection();
    }

    /**
	* @param Books\Entities\Book
    */
    public function addBook(Book $book)
    {
        if ($this->books->contains($book)) {
            return;
        }

        $this->books->add($book);

        $book->addCategory($this);
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
