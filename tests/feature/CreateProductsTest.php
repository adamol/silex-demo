<?php

class CreateProductsTest extends ControllerTestCase
{
    /** @test */
    function products_can_be_created()
    {
        $this->client->request('POST', '/products', [
            'title' => 'test title',
            'body' => 'test body'
        ]);

        tap($this->client->getResponse()->getContent(), function($response) {
            $decoded = json_decode($response, true);

            $this->assertTrue($decoded['success']);
            $this->assertEquals(1, $decoded['last_inserted_id']);
        });

        tap($this->app['products.repository']->findBy('id', 1), function($product) {
            $this->assertEquals('test title', $product->getTitle());
            $this->assertEquals('test body', $product->getBody());
        });
    }

    /** @test */
    function title_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/products', [
            'body' => 'test body'
        ]);
    }

    /** @test */
    function body_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/products', [
            'title' => 'test title',
        ]);
    }
}

