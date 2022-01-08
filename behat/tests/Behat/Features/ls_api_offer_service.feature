@api
Feature: Using api GET and POST for testing api offer_service


  Background: Retrieve Authentication token
    Given Authentication token is done


  @api_post
  Scenario Outline: Api - POST offer_service_defaults
    Given the request body is:
      """
         {
	"name": "<name> ",
	"price": "<price>"
	}
      """
    And the "Content-Type" request header contains "application/json"
    When I request "/admin/offer_service_defaults" using HTTP POST
    Then the response code is 201
    Examples:
      | name                | price |
      | Free Casco          | 0     |
      | Здравно осигуряване | 4500  |
      | Test servize        | 400   |

  Scenario: Api - GET offer_optional_defaults
    When I request "/offer_service_defaults?page=1&itemsPerPage=50" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"createdAt":/
      """
    And the response body matches:
      """
   /"id":/
      """
    And the response body matches:
      """
   /"name":/
      """
    And the response body matches:
      """
   /"price":/
      """
    And the response body matches:
      """
   /"priceCanBeNegative":false/
      """
    And the response body matches:
      """
   /"readOnly":false/
      """
    And the response body matches:
      """
   /"updatedAt":/
      """




