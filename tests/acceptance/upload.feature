Feature: upload
  In order to upload files
  As a user
  I need to upload them to given location

  Scenario: upload
    Given I have "test.upload" file
    When I upload "test.upload" file to "uploaded/" location
    Then I can find "test.upload+suffix" file in "uploaded/" location
