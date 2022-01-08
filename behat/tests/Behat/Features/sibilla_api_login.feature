@sibilla

Feature: api authentication

  Scenario Outline: Api - check sibilla authentication code ok, valid login
    Given the request body is:
      """
{
	"request": [{
		"name": "login",
		"parameters": {
			"email": "cicciossd",
			"password": "pasdds",
			"authenticationCode": "<code>"
		}
	}]
}
      """
    # And the "Content-Type" request header contains "application/json"
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body is:
      """
{"response":[]}
      """
    Examples:
      | code        |
      | 1976        |
      | 1970        |

  Scenario Outline: Api - check sibilla authentication code ko
    Given the request body is:
      """
{
	"request": [{
		"name": "login",
		"parameters": {
			"email": "cicciossd",
			"password": "pasdds",
			"authenticationCode": "<code>"
		}
	}]
}
      """
    # And the "Content-Type" request header contains "application/json"
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body is:
      """
    {"response":[{"from":"login","values":{"authenticationStatus":"false"}}]}
      """
    Examples:
      | code        |
      | 1234        |
      | 32321   ds  |
      | sdfsdfsdfds |
