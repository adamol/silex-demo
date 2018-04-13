<?php

class CreatePostsTest extends ControllerTestCase
{
    /** @test */
    function posts_can_be_created()
    {
        $this->client->request('POST', '/posts', [
            'title' => 'test title',
            'body' => 'test body'
        ]);

        tap($this->client->getResponse()->getContent(), function($response) {
            $decoded = json_decode($response, true);

            $this->assertTrue($decoded['success']);
            $this->assertEquals(1, $decoded['last_inserted_id']);
        });

        tap($this->app['posts.repository']->findBy('id', 1), function($post) {
            $this->assertEquals('test title', $post->getTitle());
            $this->assertEquals('test body', $post->getBody());
        });
    }

    /** @test */
    function title_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/posts', [
            'body' => 'test body'
        ]);
    }

    /** @test */
    function body_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/posts', [
            'title' => 'test title',
        ]);
    }
}

