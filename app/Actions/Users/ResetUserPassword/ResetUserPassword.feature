Feature: Forgotten password reset
  Scenario: a user should be able to choose a new password
    Given a user has a valid password reset request
    When they provide a confirmed new password
    Then they can use the new password to sign in

  Scenario: a password reset should require matching confirmation
    Given a user has a valid password reset request
    When their password confirmation does not match
    Then their password is not changed
