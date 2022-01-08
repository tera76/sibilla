@api

Feature: Using api GET and POST for testing api opportunity

  Background: Retrieve Authentication token
    Given Authentication token is done

  @api_post
  Scenario Outline: Api - POST opportunities
    Given I post opportunity for contact "<contact>" with payload:
      """
{
  "name": "<name>",
  "type":   "<type_id>",
  "notes": "99 problems but a b**** ain't one",
  "additionalComments": "what was he thinking?",
  "account": {
  	"companyName" : "Behat Piano Jazz",
  	"taxCode" : "123456TAXCODE",
		"type": "private"
  },
  "contact" : {"id": "%contactId%"}
}
      """
    And the "Content-Type" request header contains "application/json"
    When I request "/opportunities" using HTTP POST
    Then the response code is 201

    Examples:
      | name                           | contact             | type_id        |
      | andy great one opportunity     | Andy One Contact1   | vehicle        |
      | andy great two opportunity     | Andy Two Contact2   | vehicle        |
      | andy great three opportunity   | Andy three Contact3 | vehicle        |
      | andy great four opportunity    | Andy One Contact1   | vehicle        |
      | andy close this opportunity1   | Andy One Contact1   | after_sales    |
      | andy close this opportunity2   | Andy One Contact1   | after_sales    |
      | andy close this opportunity3   | Andy One Contact1   | other_services |
      | andy close this opportunity4   | Andy One Contact1   | other_services |
      | andy is a contact opportunity  | Andy One Contact1   | other_services |
      | andy addOffer opportunity1     | Andy One Contact1   | other_services |
      | andy addOffer opportunity2     | Andy One Contact1   | other_services |
      | andy patch opportunity status1 | Andy One Contact1   | vehicle        |


  Scenario: Api - GET opportunities: Retrieves the collection of Opportunity resources. All!
    When I request "/opportunities" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"firstName":"Andy One","lastName":"Contact1","emailPrimary"/
      """
    And the response body matches:
      """
   /"email":"scott.joplin@ew1.eu"/
      """
    And the response body matches:
      """
   /"phoneSecondary":null/
      """

  Scenario Outline: Api - GET opportunities: Retrieves a Opportunity resource.
    When I request opportunity by name "<name>" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"firstName":"<firstName>","lastName":"<lastName>","emailPrimary"/
      """
    And the response body matches:
      """
   /"lastName":"<lastName>"/
      """
    And the response body matches:
      """
   /"email":"<email1>"/
      """
    And the response body matches:
      """
   /"name":"<name>"/
      """
    And the response body matches:
      """
   /"status":\{"id":"<status>","name":"<status>"\}/
      """

    Examples:
      | name                               | firstName    | lastName    | email1                | status |
      | Task Delivery Feedback Opportunity | Mario        | Rossi       | mario.rossi@gmail.com | won    |
      | andy great one opportunity         | Andy One     | Contact1    | scott.joplin@ew1.eu   | open   |
      | andy great two opportunity         | Andy Two     | Contact2    |                       | open   |
      | andy great three opportunity       | Andy three   | Contact3    |                       | open   |
      | andy close this opportunity1       | Andy One     | Contact1    | scott.joplin@ew1.eu   | open   |

# ************ opportunity_types **************

  Scenario: Api - GET opportunity_types: Retrieves the collection of OpportunityType resources.
    When I request "/opportunity_types" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"name":"vehicle"/
      """
    And the response body matches:
      """
   /"name":"after_sales"/
      """
    And the response body matches:
      """
   /"name":"other_services"/
      """

  Scenario: Api - GET opportunity_types: Retrieves a OpportunityType resource.
    When I request "/opportunity_types/other_services" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
{"id":"other_services","name":"other_services"}
       """



# ************ patch opportunity status **************

  @api_patch
  Scenario: Api - PATCH opportunity status to lost
    Given patch the status opportunity name "andy patch opportunity status1" with payload:
      """
{
	"id": "%opportunityId%",
	"status": "lost"
}
      """
    Then the response code is 200
    And the response body matches:
    """
    /"status":"lost"/
    """
