Feature: upload
  In order to upload files
  As a user
  I need to upload them to given location

  Scenario: upload
    Given I have "test.upload" file
    When I upload "test.upload" file
    Then I can find file that name starts with "test" in "uploaded/" location
