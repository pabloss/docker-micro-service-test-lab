Feature: test_runner
  In order to define and run request body test
  As a user
  I need to check if the given test body is the same as received

  Background:
    Given I have uploaded
    And I have deployed micro service
  Scenario: test micro service request body
    Given I have micro service with some uuid
    And I have a form to define request by target url and body
    When I run test
    Then I should take request from last micro service
    And I should match requested body with received request body
