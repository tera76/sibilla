@api

Feature: Using api GET and POST for testing api opportunity

  Background: Retrieve Authentication token
    Given Authentication token is done

  @api_post_greg
  Scenario: Api - POST opportunity
    Given the request body is:
      """
{
  "name": "Opportunity Api QA",
  "notes": "99 problems but a b**** ain't one",
  "additionalComments": "what was he thinking?",
  "type": "vehicle",
  "account": {
      "companyName" : "Peppino",
      "taxCode" : "123456",
      "type": "private"
  },
  "contact" : {
      "firstName": "Peppino",
    "lastName": "Bettino",
    "dateOfBirth": "2000-04-01T14:49:00.000Z",
    "gender": "M",
    "country": "",
    "postalCode": null,
    "city": null,
    "region": null,
    "street": null,
    "street2": null,
    "phones": [{
        "phoneNumber": "3333444477747"
    }, {
        "phoneNumber": "3333444477747"
    }],
    "emails": [{
        "email": "peppino.bettino@ew1.eu"
    }, {
        "email": "peppino.bettino@ew1.eu"
    }]
  }
}
      """
    And the "Content-Type" request header contains "application/json"
    When I request "/opportunities" using HTTP POST
    Then the response code is 201


  @api_post_greg
  Scenario Outline: Api - POST multiple opportunities creation
    Given the request body is:
      """
{
  "name": "<name>",
  "notes": "99 problems but a b**** ain't one",
  "additionalComments": "what was he thinking?",
  "type": "<type>",
  "account": {
      "companyName" : "<companyName>",
      "taxCode" : "123456",
      "type": "private"
  },
  "contact" : {
    "firstName": "<firstName>",
    "lastName": "<lastName>",
    "dateOfBirth": "2000-04-01T14:49:00.000Z",
    "gender": "M",
    "country": "",
    "postalCode": null,
    "city": null,
    "region": null,
    "street": null,
    "street2": null,
    "phones": [{
        "phoneNumber": "<phoneNumber>"
    }, {
        "phoneNumber": "<phoneNumber>"
    }],
    "emails": [{
        "email": "<email>"
    }, {
        "email": "<email>"
    }]
  }
}
      """
    And the "Content-Type" request header contains "application/json"
    When I request "/opportunities" using HTTP POST
    Then the response code is 201


    Examples:

      | name                 | firstName   | lastName | phoneNumber    | email         | type    | companyName |
      | Opportunity Api QA 1 | Opportunity | Api QA 1 | 33877766655441 | apiqa1@ew1.eu | vehicle | OPP1        |
      | Opportunity Api QA 2 | Opportunity | Api QA 2 | 33877766655442 | apiqa2@ew1.eu | vehicle | OPP2        |
      | Opportunity Api QA 3 | Opportunity | Api QA 3 | 33877766655443 | apiqa3@ew1.eu | vehicle | OPP3        |
      | Opportunity Api QA 4 | Opportunity | Api QA 4 | 33877766655444 | apiqa4@ew1.eu | vehicle | OPP4        |
      | Opportunity Api QA 5 | Opportunity | Api QA 5 | 33877766655445 | apiqa5@ew1.eu | vehicle | OPP5        |
