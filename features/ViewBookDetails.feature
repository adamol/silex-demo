As a customer
In order to find the book I want
I need to be able to view details of a given book

    Background:
        GIVEN there is "1" "book" in the system
        AND the "book" with id "1" has properties:
        '''
        {
            "title": "Some Title"
            "slug": "some-title"
            "image_path": "/some/image/path"
            "description": "Lorem ipsum dolor sit amet"
            "page_count": 250
            "price": 1000
            "published_date": "2010-10-10"
        }
        '''
        AND the "book" with id "1" has category "thriller"

    Scenario: Viewing book details
        WHEN I send a request to the book details page for id "1"
        THEN I should see the fields:
        '''
        {
            "title": "Some Title",
            "slug": "some-title",
            "image_path": "/some/image/path",
            "description": "Lorem ipsum dolor sit amet",
            "page_count": 250,
            "price": 10.00 £,
            "published_date": "2010-10-10",
            "category": "thriller"
        }
        '''

