@sibilla

Feature: api external to corriere - change using the current data to external api

  Scenario: Api - direct call to corrie first news - to be changed giletti
    When I request "https://toprated.rcs.it/toprated/rest/request.action?site=rcscorriereproddef&dominio=www.corriere.it&tipologia=articolo&interazione=piuvisti&giorni=1&numerorisultati=10" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
    /"position":1,"totViews"/
      """

  Scenario: Api - call to external corriere test fixed param
    Given the request body is:
    """
{
	"request": [{
	"name": "login",
		"parameters": {
			"authenticationCode": "1976"
		}
	}, {
		"name": "externalServiceGetCorriereFixedParam",
		"parameters": {
			"externalUrl": "https://toprated.rcs.it/toprated/rest/request.action?site=rcscorriereproddef&dominio=www.corriere.it&tipologia=articolo&interazione=piuvisti&giorni=1&numerorisultati=10",
			"password": "pass"
		}
	}]
}
      """
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body matches:
      """
   /{"position":1,"totViews":/
      """
    And the response body matches:
      """
  /,"titleSubstring":/
       """


  Scenario: Api - call to external corriere and retrieve generic values from tree
    Given the request body is:
    """
  {
      "request": [{
      "name": "login",
          "parameters": {
              "authenticationCode": "1976"
          }
      }, {
          "name": "externalServiceGet",
          "parameters": {
              "externalUrl": "https://toprated.rcs.it/toprated/rest/request.action?site=rcscorriereproddef&dominio=www.corriere.it&tipologia=articolo&interazione=piuvisti&giorni=1&numerorisultati=10",
              "get": {
                  "val1": "classifica.dettaglioClassifica.0.position",
                  "val2": "classifica.dettaglioClassifica.0.siteName"
              }
          }
      }]
  }
      """
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body is:
      """
 {"response":[{"from":"externalServiceGet","values":{"val1":1,"val2":"Corriere della Sera"}}]}
      """


  Scenario: Api - get titleSubstring from corriere
    Given the request body is:
    """
{
	"request": [{
		"name": "login",
		"parameters": {
			"authenticationCode": "1976"
		}
	}, {
		"name": "getTitleSubstringFromCorriere"
	}]
}
      """
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body matches:
      """
/"response":\[{"from":"externalServiceGet","values":{"title"/
       """
    And the response body matches:
      """
/"from":"getTitleSubstringFromCorriere","values"/
       """
    And the response body matches:
      """
/"from":"getTitleSubstringFromCorriere","values"/
       """
    And the response body matches:
      """
/"titleSubstring"/
       """
