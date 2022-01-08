@sibilla

Feature: api alarmsAction

  Scenario: Api - check sibilla update alarmsAction
    Given the request body is:
      """
{
	"request": [{
	"name": "login",
		"parameters": {
			"authenticationCode": "1976"
		}
	}, {
		"name": "updateAlarms"
	}]
}
      """
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body matches:
      """
/"from":"sql","quaery":"INSERT INTO syb_alarms_history \(data,value\) VALUES/
"""

