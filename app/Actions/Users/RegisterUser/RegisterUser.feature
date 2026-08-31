Feature: User registration
  Scenario: a guest should be able to create an account
    Given a guest provides valid account details
    When they register
    Then their account is created

  Scenario: an email address should belong to only one account
    Given an account already uses an email address
    When a guest registers with the same email address
    Then the new account is not created
