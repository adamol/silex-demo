<?php

namespace Categories\Entities;

use Doctrine\ORM\Mapping as ORM;
use Books\Entities\Book;

/**
 * @ORM\Entity
 * @ORM\Table(name="book_category")
 */
class BookCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    private $id;

	/**
     * @ORM\ManyToOne(targetEntity="Books\Entities\Book", inversedBy="bookCategories")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     */
    private $book;

	/**
     * @ORM\ManyToOne(targetEntity="Categories\Entities\Category", inversedBy="bookCategories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     **/
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     **/
    private $updatedAt;

    public function setBook(Book $book)
    {
        $this->book = $book;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
