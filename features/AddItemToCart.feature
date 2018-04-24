As a customer
In order to make a purchase
I need to first be able to add my items to the cart

    Background:
        GIVEN there are "3" "books" in the system

    Scenario: Customers can place items in their cart
        GIVEN I have a session id of "1"
        AND I send a "POST" request to "carts" with payload:
        '''
        {
            "book_id": 1
            "amount": 3
        }
        '''
        AND I send a "POST" request to "carts" with payload:
        '''
        {
            "book_id": 2
            "amount": 2
        }
        '''
        WHEN I send a "GET" request to "carts"
        THEN the response contains json
        '''
        {
            "book_id": 1
            "amount": 3
        }
        '''
        AND the response contains json
        '''
        {
            "book_id": 2
            "amount": 2
        }
        '''



    Scenario: A given customer can not see items from other customers carts
        GIVEN I have a session id of "1"
        AND I add "2" items to my cart
        WHEN I have a session id of "2"
        AND I send a "POST" request to "carts" with payload:
        '''
        {
            "book_id": 2
            "amount": 2
        }
        '''
        WHEN I send a "GET" request to "carts"
        THEN the response contains "1" entries
        AND the response contains json
        '''
        {
            "book_id": 2
            "amount": 2
        }
        '''

    Scenario: book_id is required
        WHEN I send a "POST" request to "carts" with payload:
        '''
        {
            "book_id": null
            "amount": 2
        }
        '''
        THEN the response is an error
        AND the message contains 'book_id'
        WHEN I send a "GET" request to "carts"
        THEN the response contains "0" entries

    Scenario: amount is required
        WHEN I send a "POST" request to "carts" with payload:
        '''
        {
            "book_id": 1
            "amount": null
        }
        '''
        THEN the response is an error
        AND the message contains 'book_id'
        WHEN I send a "GET" request to "carts"
        THEN the response contains "0" entries

