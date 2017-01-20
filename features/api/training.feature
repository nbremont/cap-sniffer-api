Feature: Training
  User want a training plan to train

  Scenario: Get training plan for 10km with 3 seances by week on 8 weeks
    When I send a GET request to "/api/training/10/8/3"
    Then the response code should be 200
    And the json response contains result of fixture for "10" km "8" weeks and "3" seances

  Scenario: Get training plan for 10km with 4 seances by week on 8 weeks
    When I send a GET request to "/api/training/10/8/4"
    Then the response code should be 200
    And the json response contains result of fixture for "10" km "8" weeks and "4" seances

  Scenario: Get training plan for 10km with 5 seances by week on 8 weeks
    When I send a GET request to "/api/training/10/8/5"
    Then the response code should be 200
    And the json response contains result of fixture for "10" km "8" weeks and "5" seances

  Scenario: Get training plan for 21km with 4 seances by week on 12 weeks
    When I send a GET request to "/api/training/21/12/4"
    Then the response code should be 200
    And the json response contains result of fixture for "21" km "12" weeks and "4" seances
