Feature: Create product

    Scenario: I can create new product
        When I create new product named "Fallout", with price 1.99 USD
        Then new product should be created

    Scenario: I cannot create new product with duplicated name across whole system
        Given there is some product in system named "Fallout"
        When I create new product named "Fallout", with price 1.99 USD
        Then new product should not be created, because "Name is not unique"
