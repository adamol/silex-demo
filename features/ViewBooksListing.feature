Feature: Viewing books listing

    Background:
        GIVEN there are "5" books in the system
        AND the books with id "1,2" are of category "thriller"
        AND the books with id "3,4" are of category "comedy"
        AND the books with id "5" are of category "thriller,comedy"

    Scenario: Viewing all books
        WHEN I send a "GET" request to "/books"
        THEN I should see "5" books

    Scenario: Viewing all books by category
        WHEN I send a "GET" request to "/books?categories=thriller"
        THEN I should see "3" books
        AND the response contains json:
        """
        [
            {
                id: 1,
                categories: "thriller"
            },
            {
                id: 2,
                categories: "thriller"
            },
            {
                id: 5,
                categories: "thriller,comedy"
            },
        ]
        """
