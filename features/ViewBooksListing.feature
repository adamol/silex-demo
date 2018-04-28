Feature: Viewing books listing

    Background:
        Given there are "5" books in the system
        And the books with id "1,2" are of category "thriller"
        And the books with id "3,4" are of category "comedy"
        And the books with id "5" are of category "thriller,comedy"

    Scenario: Viewing all books
        When I send a "GET" request to "/books"
        Then I should see "5" books

    Scenario: Viewing all books by category
        When I send a "GET" request to "/books?categories=thriller"
        Then I should see "3" books
        And the response contains json:
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
