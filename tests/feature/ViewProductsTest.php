<?php

class ViewProductsTest extends ControllerTestCase
{
    /** @test */
    function products_listing_can_be_viewed()
    {
        $product = new Products\Model('Some title', 'Some body', 1);

        $this->app['products.repository']->save($product);

        $this->client->request('GET', '/products');

        tap($this->client->getResponse()->getContent(), function($response) {
            $decoded = json_decode($response, true);

            $this->assertEquals('Some title', $decoded[0]['title']);
            $this->assertEquals('Some body', $decoded[0]['body']);
            $this->assertEquals(1, $decoded[0]['id']);
        });
    }

    /** @test */
    function product_details_can_be_viewed()
    {
        $product = new Products\Model('Some title', 'Some body', 1);

        $this->app['products.repository']->save($product);

        $this->client->request('GET', '/products/1');

        tap($this->client->getResponse()->getContent(), function($response) {
            $decoded = json_decode($response, true);

            $this->assertEquals('Some title', $decoded[0]['title']);
            $this->assertEquals('Some body', $decoded[0]['body']);
            $this->assertEquals(1, $decoded[0]['id']);
        });
    }
}
