As a customer who has made a purchase
In order to view the status of my order
I need to have a page to see my order in its entirety

    Scenario: Viewing an order
        GIVEN I have placed an order with id "1"
        AND "order" with id "1" has attributes:
        '''
        {
            "email": "somebody@example.com",
            "confirmation_number": "CONFNUMBER1234",
            "card_last_four": 4242,
            "amount": 100000
        }
        '''
        AND that order contained 3 cart items
        AND cart item "1" has attributes:
        '''
        {
            "book_id": 1,
            "amount": 3
        }
        '''
        AND the "book" with id "1" has  attributes:
        '''
        {
            "price": 1500,
            "title": "Some Book Title"
        }
        '''
        WHEN I view order with id "1"
        THEN the response contains json:
        '''
        {
            "email": "somebody@example.com",
            "confirmation_number": "CONFNUMBER1234",
            "card_last_four": 4242,
            "amount": 100000,
            "items": [
                {
                    "book_id": 1,
                    "price": 1500,
                    "title": "Some Book Title",
                    "amount": 3
                }
            ]
        }
        '''

