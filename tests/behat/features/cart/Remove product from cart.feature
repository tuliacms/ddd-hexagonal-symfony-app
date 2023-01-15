Feature: Remove product from cart

    Background:
        Given there is product named "Fallout", with price 1.99 USD
        And there is a cart
        And there is a "Fallout" product in cart, with qty of 10

    Scenario: I can add new product to cart
        When I remove product "Fallout" from cart
        Then product "Fallout" should be removed from cart

    Scenario: I cannotr remove not-existent product from cart
        When I remove product "Non-existent product" from cart
        Then no product should be removed from cart
