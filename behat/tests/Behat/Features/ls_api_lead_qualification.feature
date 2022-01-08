@api
Feature: Using api GET and POST for testing api leads  - ok dev 26/09

  Background: Retrieve Authentication token
    Given Authentication token is done

  @api_post
  Scenario Outline: Api - POST invalidate lead qualification - unqualified
    When invalidate the lead qualification name "<name>" with payload:
    """
{
	"taskId": "%taskId%",
	"leadId": "%leadId%",
	"contactId": null
}
"""

    Then the response code is 200
    And the response body matches:
    """
    /"data":\{"leadStatus":"not_valid"\}/
  """

    Examples:
      | name                         |
      | Andy Scott Lead Unqualified1 |
      | Andy Art Lead Unqualified2   |


  @api_patch
  Scenario Outline: Api - POST lead qualification call
    When call the lead qualification name "<name>" with payload:
    """
{
	"toIsString": true,
	"isLoading": false,
	"contactPhone": {
		"id": "3286937764"
	},
	"subject": "answered",
	"notes": null,
	"callDate": "2019-10-17T01:58:50+02:00",
	"callTime": "01:58",
	"direction": "outgoing",
	"duration": null,
	"phoneNumber": "3286937764",
	"contact": null,
	"lead": "%leadId%",
	"task": "%taskId%"
}
"""

    Then the response code is 201
    And the response body matches:
    """
    /"activityType":"call"/
  """
    And the response body matches:
    """
    /"direction":"outgoing"/
  """
    And the response body matches:
    """
    /"phoneNumber":"3286937764"/
  """
    And the response body matches:
    """
    /"subject":"answered"/
  """

    Examples:
      | name                      |
      | Andy Post QALead valid2   |
      | Andy Post QALead LQ patch |
