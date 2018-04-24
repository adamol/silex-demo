As a customer
In order to receive my items
I need to be able to place an order for my cart

    Background:
        GIVEN there are "5" books in the system
        AND the books with ids "1,3,4" have a "price" of "1000"
        AND I have placed the following books in my cart:
            | id | amount |
            | 1  | 2      |
            | 3  | 4      |
            | 4  | 1      |

    Scenario: Placing a successful order
        GIVEN I have a stripe token "TESTTOKEN1234" for card ending in "4242"
        AND the OrderConfirmationNumberGenerator generates number "ORDERCONF1234"
        WHEN I place an order with params:
        '''
        {
            "email": "somebody@example.com",
            "payment_token": "TESTTOKEN1234",
        }
        '''
        THEN a charge is registered by stripe with params:
        '''
        {
            "amount": 7000,
            "payment_token": "TESTTOKEN1234",
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
