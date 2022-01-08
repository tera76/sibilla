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
/"from":"sql","query":"INSERT INTO syb_alarms_history \(data,value\) VALUES/
"""
    And the response body matches:
      """
/"values":\{"cicciolina_altezza":"168 cm"\}/
"""
    And the response body matches:
      """
/"from":"sql","query":"SELECT name as \'name\', url as \'url\', locator as \'locator\'/
"""


  Scenario: Api - check sibilla getAlarmsDZero alarmsAction
    Given the request body is:
      """
{
	"request": [{
	"name": "login",
		"parameters": {
			"authenticationCode": "1976"
		}
	}, {
		"name": "getAlarmsDZero"
	}]
}
      """
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body matches:
      """
/"from":"sql","query":"SELECT value from syb_alarms_history where data =/
"""

  Scenario: Api - check sibilla getAlarms_source_link alarmsAction
    Given the request body is:
      """
{
    "request": [
        {
            "name": "login",
            "parameters": {
                "authenticationCode": "1976"
            }
        },
        {
            "name": "getAlarms_source_link",
            "parameters": {
                "name": "total_population"
            }
        }
    ]
}
      """
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body matches:
      """
    /"from":"getAlarms_source_json_total_population"/
"""
    And the response body matches:
      """
  /today-and-tomorrow/
"""

