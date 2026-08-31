Feature: Account deletion
  Scenario: a user should be able to delete their account
    Given a user is signed in
    When they confirm account deletion with their password
    Then their account is deleted

  Scenario: an account should not be deleted with an incorrect password
    Given a user is signed in
    When they confirm account deletion with an incorrect password
    Then their account remains available
