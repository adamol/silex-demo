As a customer
In order to find the book I want
I need to be able to view them by category

    Background:
        GIVEN there are "5" "book"s in the system
        AND the "book"s with id "1,2" are of category "thriller"
        AND the "book"s with id "3,4,5" are of category "comedy"

    Scenario: Viewing all books
        WHEN I send a request to the books listing page
        THEN I should see "5" "book"s

    Scenario: Viewing all books by category
        WHEN I send a request to the books listing page for category "thriller"
        THEN I should see "2" "book"s
        AND they should have ids "1,2"
