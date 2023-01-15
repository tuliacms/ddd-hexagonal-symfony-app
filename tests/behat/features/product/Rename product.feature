Feature: Rename product

    Scenario: I can rename product
        Given there is product named "Fallout", with price 199 USD
        When I rename this product to "Follout 76"
        Then this product should be renamed

    Scenario: I cannot rename product to name that is already used in another product
        Given there is some product in system named "Follout 76"
        And there is product named "Fallout", with price 199 USD
        When I rename this product to "Follout 76"
        Then this product should not be renamed, because "Name is not unique"
