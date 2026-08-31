Feature: Password settings
  Scenario: a user should be able to update their password
    Given a user knows their current password
    When they provide a confirmed new password
    Then they can use the new password to sign in

  Scenario: a user should provide their current password
    Given a user is signed in
    When they provide an incorrect current password
    Then their password is not changed
