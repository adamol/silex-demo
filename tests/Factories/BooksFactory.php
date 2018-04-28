<?php

namespace Factories;

class BooksFactory
{

    private $booksRepository;

    private $booksItemRepository;

    private $categoryRepository;

    private $bookCategoryRepository;

    public function __construct(
        Books\Repository $booksRepository,
        Books\Item\Repository $booksItemRepository,
        Category\Repository $categoryRepository,
        BookCategory\Repository $bookCategoryRepository

    ) {
        $this->booksRepository = $booksRepository;
        $this->booksItemRepository = $booksItemRepository;
        $this->categoryRepository = $categoryRepository;
        $this->bookCategoryRepository = $bookCategoryRepository;
    }

    public function create($amount)
    {
        foreach ($i range(0, $amount) {
            $this->createBookEntry();
        }
    }

    private function createBookEntry()
    {
        $book = (new Books\Model)
            ->setTitle('Some Title')
            ->setSlug('some-title')
            ->setImagePath('some-image.jpg')
            ->setDescription('Lorem ipsum dolor sit amet')
            ->setPageCount(250)
            ->setPrice(1000)
            ->setPublishedDate('2010-10-10')
            ->setCreatedAt('2015-10-10')
            ->setUpdatedAt('2015-10-10');

        $this->booksRepository->save($book);
    }

    public function createCategoryForBook($id, $categoryType)
    {
        $foundCategory = $this->categoryRepository->findByType($categoryType);

        if (! $foundCategory instanceof Category\Model) {
            $category = new Category\Model;

            $categoryId = $this->categoryRepository->save($category);
        } else {
            $categoryId = $foundCategory->getId();
        }

        $bookCategory = new BookCategory\Model;
        $this->bookCategoryRepository->save($bookCategory);
    }
}
