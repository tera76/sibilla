@api
Feature: Using api GET and POST for testing api authentication

  @api_post
  Scenario: Api - POST login token exists
    Given the request body is:
      """
        {"email":"admin@leadspark.app","password":"admin"}
      """
    And the "Content-Type" request header contains "application/json"
 #   And the "Accept" request header contains "*/*"
    When I request "/login" using HTTP POST
    Then the response code is 200
    And the response body matches:
      """
      /"token"/
      """


