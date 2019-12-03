Feature: deploy_uploaded_unpacked_docker
  In order to deploy it
  As a user
  I need to upload, unpack, run docker commands (build, run) to deploy micro service

#  Scenario: try deploy_uploaded_unpacked_docker
#    Given I have "packed/test.zip" file
#    When I upload "packed/test.zip" file
#    Then I see uploaded and unpacked file in "unpacked" dir


  Scenario: try deploy deploy_uploaded_unpacked_docker
    Given I have "packed/micro-service-1.zip" file
    When I upload "packed/micro-service-1.zip" file
    And I deploy file in "unpacked" dir
    Then I see uploaded and unpacked file in "unpacked" dir
    And I see deploy process in console
