Feature: Profile settings
  Scenario: a user should be able to update their profile
    Given a user is signed in
    When they change their name or email address
    Then their profile contains the new details

  Scenario: changing an email address should require verification again
    Given a user has a verified email address
    When they change their email address
    Then the new email address is unverified
