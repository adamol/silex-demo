Feature: Viewing book details

    Background:
        GIVEN there is "1" book in the system
        AND the book with id "1" has properties:
        """
        {
            "title": "Some Title"
            "slug": "some-title"
            "image": "some-image.jpg"
            "description": "Lorem ipsum dolor sit amet"
            "page_count": 250
            "price": 1000
            "published_date": "2010-10-10"
        }
        """
        AND the "book" with id "1" has category "thriller"
        AND the "book" with id "1" has "5" items in inventory

    Scenario: Viewing book details
        WHEN I send a "GET" request to "/books/1"
        THEN the response should contain json:
        """
        {
            "title": "Some Title",
            "slug": "some-title",
            "image": "http://localhost:8080/images/some-image.jpg",
            "description": "Lorem ipsum dolor sit amet",
            "page_count": 250,
            "price": 10.00 £,
            "published_date": "October 10th 2010",
            "category": "thriller"
        }
        """

