Feature: unpack
  In order to unpack ZIP file
  As a user
  I need to unpack it to given location

  Scenario: unpack
    Given I have "tests/_data/test.zip" path
    When I unpack it to "tests/_data/unpacked/" path
    Then "tests/_data/test+prefix" dir is created
    And content of unzipped "tests/_data/test.zip" and "tests/_data/test+prefix" are the same
