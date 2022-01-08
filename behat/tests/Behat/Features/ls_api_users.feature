  @api

Feature: Using api GET and POST for testing api users - ok develop 28/05/2019


  Background: Retrieve Authentication token
    Given Authentication token is done

  Scenario: Api - GET users
    When I request "/users?page=1&itemsPerPage=200" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
       /"name":"Demo","surname":"Test","email":"demotest@ew1.eu","roles":\["ROLE_SALES_REP","ROLE_USER"]\}/
      """




  Scenario: Api - GET sellers
    When I request "/sellers" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
       /"name"/
      """
    And the response body matches:
      """
       /"surname"/
      """
    And the response body matches:
      """
       /"email"/
      """
    And the response body matches:
      """
       /"roles"/
      """


