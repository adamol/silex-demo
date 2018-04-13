<?php

class ViewPostsTest extends ControllerTestCase
{
    /** @test */
    function posts_listing_can_be_viewed()
    {
        $post = new Posts\Model('Some title', 'Some body', 1);

        $this->app['posts.repository']->save($post);

        $this->client->request('GET', '/posts');

        tap($this->client->getResponse()->getContent(), function($response) {
            $decoded = json_decode($response, true);

            $this->assertEquals('Some title', $decoded[0]['title']);
            $this->assertEquals('Some body', $decoded[0]['body']);
        });
    }
}
