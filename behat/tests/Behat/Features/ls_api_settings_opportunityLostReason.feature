@api

Feature: Using api GET and POST for testing api opportunity

  Background: Retrieve Authentication token
    Given Authentication token is done

  Scenario: Api - GET opportunity_lost_reasons: Retrieves the collection of OpportunityLostReason resources.
    When I request "/opportunity_lost_reasons" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"name":"Anagrafica errata"/
      """
    And the response body matches:
      """
   /"name":"Cessata attivit/
      """
    And the response body matches:
      """
   /"name":"Veicolo non disponibile"/
      """
    And the response body matches:
      """
   /"name":"Trattativa duplicata o annullata"/
      """


  Scenario: Api - GET opportunity_lost_reasons id: Retrieves a OpportunityLostReason resource.
    When I request "/opportunity_lost_reasons/Anagrafica%20errata" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"name":"Anagrafica errata"/
      """


  Scenario: Api - POST admin opportunity_lost_reasons: Creates a OpportunityLostReason resource. - bug
    And the request body is:
      """
      {
      "name": "Malessere diffuso"
      }
      """
    And the "Accept" request header contains "application/json"
    And the "Content-Type" request header contains "application/json"
    When I request "/admin/opportunity_lost_reasons" using HTTP POST
    Then the response code is 201

