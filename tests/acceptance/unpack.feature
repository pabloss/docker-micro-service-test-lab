Feature: unpack
  In order to unpack ZIP file
  As a user
  I need to unpack it to given location

  Scenario: unpack
    Given I have "packed/test.zip" path
    When I unpack it to "unpacked/" path
    Then "unpacked/test" dir is created
    And content of unzipped "packed/test.zip" and "unpacked/test" are the same
