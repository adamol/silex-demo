<?php

class ViewBooksTest extends ControllerTestCase
{
    /** @test */
    function books_listing_can_be_viewed()
    {
        $book = new Books\Model('Some title', 'Some body', 1);

        $this->app['books.repository']->save($book);

        $this->client->request('GET', '/books');

        tap($this->client->getResponse()->getContent(), function($response) {
            $decoded = json_decode($response, true);

            $this->assertEquals('Some title', $decoded[0]['title']);
            $this->assertEquals('Some body', $decoded[0]['body']);
            $this->assertEquals(1, $decoded[0]['id']);
        });
    }

    /** @test */
    function book_details_can_be_viewed()
    {
        $book = new Books\Model('Some title', 'Some body', 1);

        $this->app['books.repository']->save($book);

        $this->client->request('GET', '/books/1');

        tap($this->client->getResponse()->getContent(), function($response) {
            $decoded = json_decode($response, true);

            $this->assertEquals('Some title', $decoded[0]['title']);
            $this->assertEquals('Some body', $decoded[0]['body']);
            $this->assertEquals(1, $decoded[0]['id']);
        });
    }
}
