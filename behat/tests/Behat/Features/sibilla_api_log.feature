@sibilla @log

Feature: api log

  Scenario: Api - check single log call
    Given logs are disabled
    And the request body is:
      """
{
	"request": [{
		"name": "login",
		"parameters": {
			"authenticationCode": "1976"
		}
	}, {
		"name": "log"
	}]
}
      """

    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body is:
      """
{"response":[{"from":"log","values":{"message":"logged action performed"}},{"from":"sql","query":"INSERT INTO syb_log (request,response) VALUES ('[{\"name\":\"login\",\"parameters\":{\"authenticationCode\":\"1976\"}},{\"name\":\"log\"}]','{\"response\":[{\"from\":\"log\",\"values\":{\"message\":\"logged action performed\"}}]}');","values":true}]}
"""


  Scenario: Api - check basic test and logs for debugging
    Given logs are disabled
    And the request body is:
      """
{
	"request": [{
		"name": "login",
		"parameters": {
			"authenticationCode": "1976"
		}
	}, {
		"name": "test"
	},{
		"name": "log"
	}]
}
      """

    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body is:
      """
    {"response":[{"from":"test","values":{"testActionStatus":"true"}},{"from":"log","values":{"message":"logged action performed"}},{"from":"sql","query":"INSERT INTO syb_log (request,response) VALUES ('[{\"name\":\"login\",\"parameters\":{\"authenticationCode\":\"1976\"}},{\"name\":\"test\"},{\"name\":\"log\"}]','{\"response\":[{\"from\":\"test\",\"values\":{\"testActionStatus\":\"true\"}},{\"from\":\"log\",\"values\":{\"message\":\"logged action performed\"}}]}');","values":true}]}
"""


  Scenario: Api - getLog with limit
    Given logs are disabled
    And the request body is:
      """
{
	"request": [{
		"name": "login",
		"parameters": {
			"authenticationCode": "1976"
		}
	}, {
		"name": "getLog",
		"parameters": {
			"limit": "5"
		}
	}]
}
      """
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body matches:
    """
      /"from":"sql"/
     """
    And the response body matches:
      """
/"query":"SELECT id,timestamp, request, response from  syb_log order by id desc limit 5;"/
"""
    And the response body matches:
      """
/"from":"getLog"/
"""

