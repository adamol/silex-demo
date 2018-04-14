<?php

class CreateBooksTest extends ControllerTestCase
{
    /** @test */
    function books_can_be_created()
    {
        $this->client->request('POST', '/books', [
            'title' => 'Some Title',
            'image_path' => '/some/image/path',
            'description' => 'Lorem ipsum dolor sit amet',
            'page_count' => 250,
            'published_date' => '2010-10-10',
        ]);

        tap($this->client->getResponse()->getContent(), function($response) {
            $decoded = json_decode($response, true);

            $this->assertTrue($decoded['success']);
            $this->assertEquals(1, $decoded['last_inserted_id']);
        });

        tap($this->app['books.repository']->findBy('id', 1), function($book) {
            $this->assertEquals(1, $book->getId());
            $this->assertEquals('Some Title', $book->getTitle());
            $this->assertEquals('some-title', $book->getSlug());
            $this->assertEquals(250, $book->getPageCount());
            $this->assertEquals('2010-10-10', $book->getPublishedDate());
            $this->assertNotNull($book->getUpdatedAt());
            $this->assertNotNull($book->getCreatedAt());
            $this->assertEquals($book->getUpdatedAt(), $book->getCreatedAt());
        });
    }

    /** @test */
    function title_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/books', [
            'title' => '',
            'image_path' => '/some/image/path',
            'description' => 'Lorem ipsum dolor sit amet',
            'page_count' => 250,
            'published_date' => '2010-10-10',
        ]);
    }

    /** @test */
    function image_path_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/books', [
            'title' => 'Some Title',
            'image_path' => '',
            'description' => 'Lorem ipsum dolor sit amet',
            'page_count' => 250,
            'published_date' => '2010-10-10',
        ]);
    }

    /** @test */
    function description_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/books', [
            'title' => 'Some Title',
            'image_path' => '/some/image/path',
            'description' => '',
            'page_count' => 250,
            'published_date' => '2010-10-10',
        ]);
    }

    /** @test */
    function page_count_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/books', [
            'title' => 'Some Title',
            'image_path' => '/some/image/path',
            'description' => 'Lorem ipsum dolor sit amet',
            'page_count' => null,
            'published_date' => '2010-10-10',
        ]);
    }

    /** @test */
    function published_date_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/books', [
            'title' => 'Some Title',
            'image_path' => '/some/image/path',
            'description' => 'Lorem ipsum dolor sit amet',
            'page_count' => 250,
            'published_date' => '',
        ]);
    }
}

