@sibilla

Feature: api callToAction


  Scenario Outline: Api - smoke calibration  callToAction ok login
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
			"name": "<name>",
			"parameters": {
				"email": "<email>",
				"password": "<password>",
				"": ""
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
      {"response":[<actionResponse>]}
      """

    Examples:
      | name     | email   | password | actionResponse                                                                                             |
      | test     | ciccio  | pass     | {"from":"test","values":{"testActionStatus":"true"}}                                                       |
      | loginfff | ciccio  | pass     | {"from":"callToAction","values":{"errorOrigin":"loginfff","callToActionStatus":"false","errorCode":"404"}} |
      | identity | ciccioz | passf    | {"from":"identity","values":{"name":"identity","parameters":{"email":"ciccioz","password":"passf","":""}}} |


  Scenario Outline: Api - smoke calibration bad ot empty login
    Given the request body is:
      """
{
	"request": [{
		"name": "<name>",
		"parameters": {
			"email": "<email>",
			"password": "<password>",
			"authenticationCode": "<authenticationCode>",
			"":""
		}
	}]
}
      """
    # And the "Content-Type" request header contains "application/json"
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body is:
      """
      {"response":[<actionResponse>]}
      """

    Examples:
      | name   | authenticationCode | email  | password | actionResponse                                             |
      | test   | 1976               | ciccio | pass     | {"from":"login","values":{"authenticationStatus":"false"}} |
      | login2 | bud                | ciccio | pass     | {"from":"login","values":{"authenticationStatus":"false"}} |


  Scenario: Api - check sibilla callToAction
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
	}, {
		"name": "login2",
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
{"response":[{"from":"test","values":{"testActionStatus":"true"}},{"from":"callToAction","values":{"errorOrigin":"login2","callToActionStatus":"false","errorCode":"404"}}]}
"""

