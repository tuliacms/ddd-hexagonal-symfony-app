Feature: Add product to cart

    Background:
        Given there is a cart
        And there is product named "Fallout", with price 199 USD
        And there is product named "Don’t Starve", with price 299 USD
        And there is product named "Baldur’s Gate", with price 399 USD
        And there is product named "Icewind Dale", with price 499 USD

    Scenario: I can add new product to cart
        When I add product "Fallout" to cart, with qty of 3
        Then new product should be added to cart

    Scenario: I can add product that already exists in cart, and increase it's qty
        Given there is a "Fallout" product in cart, with qty of 3
        When I add product "Fallout" to cart, with qty of 3
        Then product qty should be increased by 3

    Scenario: I cannot add more than 10 pieces of the same product to cart
        Given there is a "Fallout" product in cart, with qty of 10
        When I add product "Fallout" to cart, with qty of 1
        Then product qty should not be increased, because "Qty limit for one product exceeded"

    Scenario: I cannot add non-existent product to cart
        When I add product "Non-existent product" to cart, with qty of 1
        Then new product should not be added to cart, because "Product does not exists"

    Scenario: I cannot add more than 3 different products to cart
        Given there is a "Fallout" product in cart, with qty of 1
        And there is a "Don’t Starve" product in cart, with qty of 1
        And there is a "Baldur’s Gate" product in cart, with qty of 1
        When I add product "Icewind Dale" to cart, with qty of 1
        Then new product should not be added to cart, because "Limit of products in cart exceeded"
