Feature: Calendar
  User want a calendar of training plan to train

  Scenario: Get training calendar
    When I send a GET request to "/api/calendar/10/8/3"
    Then the response code should be 200
    And the response should contain "content"
