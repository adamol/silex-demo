<?php

namespace Books\Entities;

use Categories\Entities\Category;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Books\Repository")
 * @ORM\Table(name="books")
 */
class Book
{
    const BOOK_COVER_IMAGE_PATH = 'images/book_covers/';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    private $id;

    /**
     * Many Books have Many Categories.
     * @ORM\ManyToMany(targetEntity="Categories\Entities\Category")
     * @ORM\JoinTable(name="book_category",
     *     joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id", unique=true)}
     * )
     **/
    private $categories;

    /**
     * One Book has Many BookItems.
     * @ORM\OneToMany(targetEntity="Books\Entities\BookItem", mappedBy="book")
     **/
    private $bookItems;

    /**
     * @ORM\Column(type="string")
     **/
    private $title;

    /**
     * @ORM\Column(type="string")
     **/
    private $slug;

    /**
     * @ORM\Column(type="string")
     **/
    private $imagePath;

    /**
     * @ORM\Column(type="text")
     **/
    private $description;

    /**
     * @ORM\Column(type="integer")
     **/
    private $pageCount;

    /**
     * @ORM\Column(type="integer")
     **/
    private $price;

    private $bookCount;

    /**
     * @ORM\Column(type="datetime")
     **/
    private $publishedDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     **/
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     **/
    private $createdAt;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->bookItems = new ArrayCollection();
    }

    /**
	* @param Categories\Entities\Category
    */
    public function addCategory(Category $category)
    {
        if ($this->categories->contains($category)) {
            return;
        }

        $this->categories->add($category);

        //$category->addBook($this);
    }

    /**
	* @param Books\Entities\Book
    */
    public function addBookItem(BookItem $bookItem)
    {
        if ($this->bookItems->contains($bookItem)) {
            return;
        }

        $this->bookItems->add($bookItem);

        $bookItem->setBook($this);
    }

    public function setId($value)
    {
        $this->id = $value;

        return $this;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function setTitleAndSlug($value)
    {
        return $this
            ->setTitle($value)
            ->setSlug(str_replace(' ', '-', strtolower($value)));
    }

    public function setTitle($value)
    {
        $this->title = $value;

        return $this;
    }

    public function setCategories($value)
    {
        $this->categories = $value;

        return $this;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath($value)
    {
        $this->imagePath = $value;

        return $this;
    }

    public static function generateImagePath($value)
    {
        return self::BOOK_COVER_IMAGE_PATH.md5($value).'.jpg';
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;

        return $this;
    }

    public function getPageCount()
    {
        return $this->pageCount;
    }

    public function setSlug($value)
    {
        $this->slug = $value;

        return $this;
    }

    public function setPageCount($value)
    {
        $this->pageCount = $value;

        return $this;
    }

    public function getPublishedDate()
    {
        // If publishedDate is in format Y-m-d we will return it straight away.
        // Otherwise it is in format Y-m-d H:i:s and we need to format it.
        if (strpos($this->publishedDate, ':') === false) {
            return $this->publishedDate;
        }

        $dateTime = \DateTime::createFromFormat("Y-m-d H:i:s", $this->publishedDate);

        return $dateTime->format('Y-m-d');
    }

    public function setPublishedDate($value)
    {
        $this->publishedDate = $value;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($value)
    {
        $this->price = $value;

        return $this;
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

    public function getBookCount()
    {
        return $this->bookCount;
    }

    public function setBookCount($value)
    {
        $this->bookCount = $value;

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

    /**
     * @return array
     */
    public function toArray()
    {
        return [
          'id' => $this->getId(),
          'title' => $this->getTitle(),
          'slug' => $this->getSlug(),
          'image_path' => $this->getImagePath(),
          'description' => $this->getDescription(),
          'page_count' => $this->getPageCount(),
          'price' => $this->getPrice(),
          'categories' => $this->getCategories(),
          'book_count' => $this->getBookCount(),
          'published_date' => $this->getPublishedDate(),
          'created_at' => $this->getCreatedAt(),
          'updated_at' => $this->getUpdatedAt()
        ];
    }
}
