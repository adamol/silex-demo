As a customer
In order to receive my items
I need to be able to place an order for my cart

    Background:
        GIVEN there are "5" books in the system
        AND I have placed the following books in my cart:
            | id | amount | price |
            | 1  | 2      | 1000  |
            | 3  | 4      | 1500  |
            | 4  | 1      | 500   |

    Scenario: Placing a successful order
        GIVEN I have a stripe token "tok_mastercard" for card ending in "4242"
        AND an order confirmation of "ORDERCONF1234" is generated
        WHEN I place an order with params:
        '''
        {
            "email": "somebody@example.com",
            "payment_token": "tok_mastercard",
        }
        '''
        THEN a charge is registered by stripe with params:
        '''
        {
            "amount": 8500,
            "payment_token": "tok_mastercard",
        }
        '''
        AND an "order" is saved to the database with fields:
        '''
        {
            "email": "somebody@example.com",
            "amount": 7000,
            "confirmation_number": "ORDERCONF1234"
        }
        '''

        --> and an email is sent to "somebody@example.com"
        --> check job entry "behind the scenes"

        AND a "job" is saved to the database with fields:
        '''
        {
            "status": "pending",
            "type": "send_email"
        }
        '''

    Scenario: Handling payment failures
        GIVEN I have a stripe token "TESTTOKEN1234" for card ending in "4242"
        AND the stripe payment fails
        WHEN I place an order with params:
        '''
        {
            "email": "somebody@example.com",
            "payment_token": "TESTTOKEN1234",
        }
        '''
        THEN no charge is registered with stripe
        AND no "order" entry is saved to the database
        AND no "jobs" entry is saved to the database
        AND the cart items are not reserved

    Scenario: Handling not enough inventory
        GIVEN I have a stripe token "TESTTOKEN1234" for card ending in "4242"
        AND inventory is insufficient for the order
        WHEN I place an order with params:
        '''
        {
            "email": "somebody@example.com",
            "payment_token": "TESTTOKEN1234",
        }
        '''
        THEN no charge is registered with stripe
        AND no "order" entry is saved to the database
        AND no "jobs" entry is saved to the database
        AND the cart items are not reserved
