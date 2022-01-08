@sibilla

Feature: api testAction

  Scenario: Api - check sibilla testAction
    Given the request body is:
      """
{
	"request": [{
	"name": "login",
		"parameters": {
			"email": "ciccio",
			"password": "pass",
			"authenticationCode": "1976"
		}
	}, {
		"name": "test",
		"parameters": {
			"email": "ciccio",
			"password": "pass"
		}
	}]
}
      """
    # And the "Content-Type" request header contains "application/json"
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body is:
      """
   {"response":[{"from":"test","values":{"testActionStatus":"true"}}]}
      """


  Scenario: Api - check sibilla testAction without login
    Given the request body is:
      """
{
	"request": [{
		"name": "test",
		"parameters": {
			"email": "ciccio",
			"password": "pass"
		}
	}]
}
      """
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body is:
      """
{"response":[{"from":"login","values":{"authenticationStatus":"false"}}]}
      """

