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

        tap($this->client->getResponse()->getContent(), function($response) use ($book) {
            $decoded = json_decode($response, true);

            $this->assertCount(1, $decoded);
            $this->assertEquals(1, $decoded[0]['id']);
            $this->assertEquals('Some Title', $decoded[0]['title']);
            $this->assertEquals('some-title', $decoded[0]['slug']);
            $this->assertEquals($book->getImagePath(), $decoded[0]['image_path']);
            $this->assertEquals($book->getDescription(), $decoded[0]['description']);
            $this->assertEquals(250, $decoded[0]['page_count']);
            $this->assertEquals('2010-10-10', $decoded[0]['published_date']);
            $this->assertNotNull($decoded[0]['updated_at']);
            $this->assertNotNull($decoded[0]['created_at']);
            $this->assertEquals($decoded[0]['updated_at'], $decoded[0]['created_at']);
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

        tap($this->client->getResponse()->getContent(), function($response) use ($book) {
            $decoded = json_decode($response, true);

            $this->assertEquals(1, $decoded[0]['id']);
            $this->assertEquals('Some Title', $decoded[0]['title']);
            $this->assertEquals('some-title', $decoded[0]['slug']);
            $this->assertEquals($book->getImagePath(), $decoded[0]['image_path']);
            $this->assertEquals($book->getDescription(), $decoded[0]['description']);
            $this->assertEquals(250, $decoded[0]['page_count']);
            $this->assertEquals('2010-10-10', $decoded[0]['published_date']);
            $this->assertNotNull($decoded[0]['updated_at']);
            $this->assertNotNull($decoded[0]['created_at']);
            $this->assertEquals($decoded[0]['updated_at'], $decoded[0]['created_at']);
        });
    }
}
