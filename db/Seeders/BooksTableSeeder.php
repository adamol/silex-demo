<?php

namespace Seeders;

use Books\Entities\Book;
use Books\Entities\BookItem;
use Categories\Entities\Category;
use Categories\Entities\BookCategory;

class BooksTableSeeder
{
    private $availableCategories = [];

    private $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function seed()
    {
        try {
//            $this->entityManager->beginTransaction();
            $this->seedCategories();

            echo "Done seeding categories";

            $books = [];
            foreach (['First', 'Second', 'Third', 'Fourth', 'Fifth'] as $count) {
                $book = $this->getBook($count);
                $books[] = $book;

                $this->entityManager->persist($book);

                $this->entityManager->flush();
            }

            echo "Done seeding books\n";

            foreach ($books as $book) {
                $this->addBookItemsTo($book);

                $this->entityManager->persist($book);

                $this->entityManager->flush();
            }

            echo "Done seeding book_items\n";

            foreach ($books as $book) {
                $this->addCategoriesTo($book);

                $this->entityManager->persist($book);

                $this->entityManager->flush();
            }

            echo "Done seeding book_categories\n";

 //           $this->entityManager->commit();

        } catch (\Exception $e) {
            echo $e->getMessage();
 //           $this->entityManager->rollback();
        }
    }

    private function seedCategories()
    {
        foreach (['thriller', 'comedy', 'novel'] as $categoryType) {
            $category = new Category;

            $category->setType($categoryType);
            $category->setCreatedAt($this->randomDate('2018-01-01', '2018-05-01'));

            $this->entityManager->persist($category);

            $this->availableCategories[] = $category;
        }
    }

    private function getBook($count)
    {
        $book = new Book;

        $book->setTitle('Book '.$count);
        $book->setSlug(strtolower($count).'-book');
        $book->setImagePath('/images/book_covers/'.strtolower($count));
        $book->setDescription('Lorem ipsum dolor sit amet');
        $book->setPageCount(rand(250, 400));
        $book->setPrice(rand(500, 1500));
        $randInt = rand(0, 9);
        $book->setPublishedDate($this->randomDate('2001-01-01', '2010-10-10'));
        $book->setCreatedAt($this->randomDate('2018-01-01', '2018-05-01'));

        return $book;
    }

    private function addBookItemsTo(Book $book)
    {
        for ($i = 0; $i < 5; $i++) {
            $bookItem = new BookItem;

            $bookItem->setBook($book);
            $bookItem->setOrder(null);
            $bookItem->setReservedAt(null);
            $bookItem->setCreatedAt($this->randomDate('2018-01-01', '2018-05-01'));

            $this->entityManager->persist($bookItem);

            $book->addBookItem($bookItem);
        }
    }

    private function addCategoriesTo(Book $book)
    {
        $categories = $this->availableCategories;

        do {
            $randomIndex = array_rand($categories);
            $category = $categories[$randomIndex];
            unset($categories[$randomIndex]);

            $bookCategory = new BookCategory;
            $bookCategory->setBook($book);
            $bookCategory->setCategory($category);
            $bookCategory->setCreatedAt($this->randomDate('2018-01-01', '2018-05-01'));

            $this->entityManager->persist($bookCategory);

            $randInt = rand(1, 10);
        } while ($randInt > 7 && ! empty($categoryIds));
    }

    public function randomDate($startDate, $endDate)
    {
        $randomTimestamp = rand(strtotime($startDate), strtotime($endDate));

        $randomDate = date('Y-m-d', $randomTimestamp);

        return \DateTime::createFromFormat('Y-m-d', $randomDate);
    }
}
