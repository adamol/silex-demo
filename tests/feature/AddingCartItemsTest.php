<?php

use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\BrowserKit\Cookie;

class AddingCartItemsTest extends ControllerTestCase
{
    /** @test */
    function items_are_stored_uniquely_for_each_session()
    {
        $harry = $this->client;
        $cookie = new Cookie('PHPSESSID', '1');
        $harry->getCookieJar()->set($cookie);
        $harry->request('POST', '/cart', [
            'book_id' => 3,
            'amount' => 2
        ]);

        $sally = static::createClient();
        $otherCookie = new Cookie('PHPSESSID', '2');
        $sally->getCookieJar()->set($otherCookie);
        $sally->request('POST', '/cart', [
            'book_id' => 7,
            'amount' => 1
        ]);

        $harry->request('POST', '/cart', [
            'book_id' => 10,
            'amount' => 1
        ]);

        $harry->request('GET', '/cart');

        tap($this->getJsonResponse($harry), function($response) {
            $this->assertCount(2, $response);
            $this->assertEquals(3, $response[0]['book_id']);
            $this->assertEquals(10, $response[1]['book_id']);
        });
    }

    /** @test */
    function book_id_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/books', [
            'book_id' => null,
            'amount' => 3
        ]);
    }

    /** @test */
    function amount_is_required()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->request('POST', '/books', [
            'book_id' => 1,
            'amount' => null
        ]);
    }
}
