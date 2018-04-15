<?php

class ViewBooksTest extends ControllerTestCase
{
    /** @test */
    function books_listing_can_be_viewed()
    {
        $book = (new Books\Model())
            ->setTitleAndSlug('Some Title')
            ->setImagePath('/some/image/path')
            ->setDescription('Lorem ipsum dolor sit amet')
            ->setPageCount(250)
            ->setPublishedDate('2010-10-10');

        $this->app['books.repository']->save($book);

        $this->client->request('GET', '/books');

        tap($this->getJsonResponse(), function($response) use ($book) {
            $this->assertCount(1, $response);
            $this->assertEquals(1, $response[0]['id']);
            $this->assertEquals('Some Title', $response[0]['title']);
            $this->assertEquals('some-title', $response[0]['slug']);
            $this->assertEquals($book->getImagePath(), $response[0]['image_path']);
            $this->assertEquals($book->getDescription(), $response[0]['description']);
            $this->assertEquals(250, $response[0]['page_count']);
            $this->assertEquals('2010-10-10', $response[0]['published_date']);
            $this->assertNotNull($response[0]['updated_at']);
            $this->assertNotNull($response[0]['created_at']);
            $this->assertEquals($response[0]['updated_at'], $response[0]['created_at']);
        });
    }

    /** @test */
    function book_details_can_be_viewed()
    {
        $book = (new Books\Model())
            ->setTitleAndSlug('Some Title')
            ->setImagePath('/some/image/path')
            ->setDescription('Lorem ipsum dolor sit amet')
            ->setPageCount(250)
            ->setPublishedDate('2010-10-10');

        $this->app['books.repository']->save($book);

        $this->client->request('GET', '/books/1');

        tap($this->getJsonResponse(), function($response) use ($book) {
            $this->assertEquals(1, $response[0]['id']);
            $this->assertEquals('Some Title', $response[0]['title']);
            $this->assertEquals('some-title', $response[0]['slug']);
            $this->assertEquals($book->getImagePath(), $response[0]['image_path']);
            $this->assertEquals($book->getDescription(), $response[0]['description']);
            $this->assertEquals(250, $response[0]['page_count']);
            $this->assertEquals('2010-10-10', $response[0]['published_date']);
            $this->assertNotNull($response[0]['updated_at']);
            $this->assertNotNull($response[0]['created_at']);
            $this->assertEquals($response[0]['updated_at'], $response[0]['created_at']);
        });
    }
}
