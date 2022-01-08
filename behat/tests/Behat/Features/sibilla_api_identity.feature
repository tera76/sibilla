@sibilla

Feature: api identityAction

  Scenario Outline: Api - check sibilla identity
    Given the request body is:
      """
{
	"request": [{
			"name": "login",
			"parameters": {
				"authenticationCode": "1976"
			}
		},
		{
			"name": "identity",
			"parameters": {
				"email": "<email>",
				"password": "pass"
			}
		}
	]
}
      """
    # And the "Content-Type" request header contains "application/json"
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body is:
      """
      {"response":[{"from":"identity","values":{"name":"identity","parameters":{"email":"<email>","password":"pass"}}}]}
      """

    Examples:
      | email            |
      | ciccio           |
      | pasticcio@ddd.it |
