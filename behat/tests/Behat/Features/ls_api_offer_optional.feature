@api
Feature: Using api GET and POST for testing api offer_optional


  Background: Retrieve Authentication token
    Given Authentication token is done


  @api_post
  Scenario Outline: Api - POST offer_optional_defaults
    Given the request body is:
      """
         {
	"name": "<name> ",
	"price": "<price>",
	"readOnly": <readOnly>
	}
      """
    And the "Content-Type" request header contains "application/json"
    When I request "/admin/offer_optional_defaults" using HTTP POST
    Then the response code is 201
    Examples:
      | name              | price | readOnly |
      | Albero deodorante | 23    | true     |
      | хладилен пепелник | 4500  | false    |
      | Asse da stiro     | 0     | false    |

  Scenario: Api - GET offer_optional_defaults
    When I request "/offer_optional_defaults?page=1&itemsPerPage=50" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"name":"Sensori di parcheggio posteriori/
      """
    And the response body matches:
      """
   /"priceCanBeNegative":false/
      """






