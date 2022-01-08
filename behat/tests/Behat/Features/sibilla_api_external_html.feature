@sibilla

Feature: get value from html page using xpath



  Scenario: Api - get data from wikipedia using xpath from corriere
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
              "name": "externalPageGet",
              "parameters": {
                  "externalUrl": "https://it.wikipedia.org/wiki/Ilona_Staller",
                  "get": {
                      "cicciolina_altezza": "//*[@id=\"mw-content-text\"]/div/table[1]/tbody/tr[7]/td"
                  }
              }
          }
      ]
  }
      """
    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body is:
      """
    {"response":[{"from":"externalPageGetAction","values":{"cicciolina_altezza":"168 cm"}}]}
      """