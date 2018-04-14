<?php

class CreateBooksTest extends ControllerTestCase
{
    /** @test */
    function books_can_be_created()
    {
        $this->client->request('POST', '/books', [
            'title' => 'test title',
            'body' => 'test body'
        ]);

        tap($this->client->getResponse()->getContent(), function($response) {
            $decoded = json_decode($response, true);

            $this->assertTrue($decoded['success']);
            $this->assertEquals(1, $decoded['last_inserted_id']);
        });

        tap($this->app['books.repository']->findBy('id', 1), function($book) {
            $this->assertEquals('test title', $book->getTitle());
            $this->assertEquals('test body', $book->getBody());
        });
    }

    /** @test */
    function title_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/books', [
            'body' => 'test body'
        ]);
    }

    /** @test */
    function body_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/books', [
            'title' => 'test title',
        ]);
    }
}

