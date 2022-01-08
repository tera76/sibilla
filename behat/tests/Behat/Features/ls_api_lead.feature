@api
Feature: Using api GET and POST for testing api leads  - ok dev 26/09

  Background: Retrieve Authentication token
    Given Authentication token is done

    # *** LeadTypes

  Scenario: Api - GET lead_statuses: Retrieves the collection of LeadStatus resources.
    When I request "/lead_types" using HTTP GET
    Then the response code is 200
    And the response body is:
      """
[{"id":"after_sales","name":"after_sales","position":1},{"id":"other_services","name":"other_services","position":2},{"id":"vehicle","name":"vehicle","position":0}]
     """


   # *** LeadStatus

  Scenario: Api - GET lead_statuses: Retrieves the collection of LeadStatus resources.
    When I request "/lead_statuses" using HTTP GET
    Then the response code is 200
    And the response body is:
      """
[{"id":"disqualified","name":"disqualified","position":0},{"id":"not_valid","name":"not_valid","position":1},{"id":"qualified","name":"qualified","position":2},{"id":"unqualified","name":"unqualified","position":3},{"id":"valid","name":"valid","position":4}]
      """

  Scenario Outline: Api - GET lead_statuses: Retrieves a LeadStatus resource.
    When I request "/lead_statuses/<id>" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"name":"<name>"/
      """

    Examples:
      | id           | name         |
      | disqualified | disqualified |
      | not_valid    | not_valid    |
      | qualified    | qualified    |
      | unqualified  | unqualified  |
      | valid        | valid        |


    # *** LeadCreation

  @api_post
  Scenario Outline: Api - POST lead creation, unqualified and valid
    Given the request body is:
      """
          {
            "requests": [
              {
                "@type": "general",
                "make": "Jeep",
                "model": "Renegade",
                "version": "2.0",
                "sourceUrl": "https://jeep.com"
              }
            ],
            "firstName": "<firstName>",
            "lastName": "<lastName>",
            "notes": "Richiesta SUV compatto",
              "activities": [],
            "email": "<email>",
            "phoneNumber": "<phone>",
            "addresses": [
              {
                "isPrimary": true,
                "city": "New York",
                "postalCode": "10011",
                "country": {
                  "code": "US"
                }
              }
            ],
            "type": {
              "id": "<type>"
            },
            "status": {
              "id": "<status>"
            },
            "source": {
                "id": "4177bc00-ad45-4d6e-a880-f9f6a2cf7632"
            },
            "sourceDetail": {
                "id": "55c05fd4-da49-41d3-96aa-38a053634d8e"
            },
	"contact": {
		"id": "<contactId>",
		"code": null,
		"street": null,
		"street2": null,
		"city": null,
		"postalCode": null,
		"region": null,
		"country": {
			"code": "AM",
			"active": false
		},
		"firstName": "Andy Contact1",
		"lastName": "Fixture",
		"emails": [{
			"id": "0c47cf48-8378-4eb3-ab13-35d34e15f320",
			"email": "andyfixture.contact1@ew1.eu",
			"notes": null
		}],
		"phones": [{
			"id": "11e52a65-7ca8-48e7-917b-4ddeff3b977b",
			"phoneNumber": "3286937764"
		}],
		"account": {
			"id": "19794d90-996e-48bc-95eb-3db5c51547fd",
			"name": "Andy Fixture1 Account",
			"taxCode": "",
			"accountType": "/account_types/private",
			"channel": null,
			"channelIntegration": null
		},
		"dateOfBirth": null,
		"gender": null,
		"channel": null,
		"channelIntegration": null
	  }
	  }
      """
    And the "Content-Type" request header contains "application/json"
    When I request "/leads" using HTTP POST
    Then the response code is 201

    Examples:
      | firstName       | lastName           | status      | email                  | phone              | type        | contactId                            |
      | Andy Scott      | Lead Unqualified1  | unqualified |                        |                    | vehicle     |                                      |
      | Andy Art        | Lead Unqualified2  | unqualified |                        |                    | vehicle     |                                      |
      | Andy Duke       | Lead Unqualified3  | unqualified |                        |                    | after_sales |                                      |
      | Andy Earl       | Lead Unqualified4  | unqualified |                        |                    | after_sales |                                      |
      | Andy Ahmad      | Lead Unqualified5  | unqualified | edit_this_lead1@ew1.eu |                    | vehicle     |                                      |
      | Andy Oscar      | Lead Unqualified6  | unqualified |                        |                    | vehicle     |                                      |
      | Andy Horace     | Lead Unqualified7  | unqualified | edit_this_lead2@ew1.eu |                    | vehicle     |                                      |
      | Andy Chick      | Lead Unqualified8  | unqualified |                        |                    | vehicle     |                                      |
      | Andy Hiromi     | Lead Unqualified9  | unqualified |                        |                    | vehicle     |                                      |
      | Andy Keith      | Lead Unqualified10 | unqualified | k.jarrett@ew1.eu       |                    | vehicle     |                                      |
      | Andy Herbie     | Lead Unqualified11 | unqualified | Hancock                |                    | vehicle     |                                      |
      | Andy Glenn      | Lead Unqualified12 | unqualified | qualify_this@ew1.eu    | +3932869377640010  | vehicle     |                                      |
      | Andy Bill       | Lead Valid1        | valid       | qualify_this@ew1.eu    | +39328612177640011 | vehicle     | f1c39dac-4b22-474d-96cf-f3a05cc28e13 |
      | Andy Charlie    | Lead Valid2        | valid       | invalidate_this@ew1.eu | 3932869377640012   | vehicle     | f1c39dac-4b22-474d-96cf-f3a05cc28e13 |
      | Andy Dizzy      | Lead Valid3        | valid       | dizzy.gillespie@ew1.eu | 39323322377640013  | vehicle     | f1c39dac-4b22-474d-96cf-f3a05cc28e13 |
      | Andy Erroll     | Lead Valid4        | valid       |                        | 393233223776400014 | vehicle     | f1c39dac-4b22-474d-96cf-f3a05cc28e13 |
      | Andy Bud        | Lead Valid5        | valid       |                        | 3932869377640015   | vehicle     | f1c39dac-4b22-474d-96cf-f3a05cc28e13 |
      | Andy Cecil      | Lead Valid6        | valid       | cecil.taylor@ew1.eu    | 39323322377640017  | after_sales | f1c39dac-4b22-474d-96cf-f3a05cc28e13 |
      | Andy Lennie     | Lead Valid7        | valid       | l.tristano@ew1.eu      | +39328612177643218 | after_sales | f1c39dac-4b22-474d-96cf-f3a05cc28e13 |
      | Andy Glenn      | Lead Unqualified13 | unqualified | qualify_this@ew1.eu    | +3932869377640010  | vehicle     |                                      |
      | Andy Glenn      | Lead Unqualified14 | unqualified | qualify_this2@ew1.eu   | +3932869377640012  | vehicle     |                                      |
      | Andy Bill       | Lead Valid10       | valid       | qualify_this@ew2.eu    | +39328312177640011 | vehicle     | f1c39dac-4b22-474d-96cf-f3a05cc28e13 |
      | Andy Thelonious | Lead Unqualified15 | unqualified | t.monk@ew1.eu          | 3932869377640016   | vehicle     |                                      |

  Scenario Outline: Api - GET lead  - ok dev 01/07
    When I request lead by name "<firstName> <lastName>" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"firstName":"<firstName>","lastName":"<lastName>","notes":"Richiesta SUV compatto",/
      """
    And the response body matches:
          """
   /"make":"Jeep","model":"Renegade","version":"2.0"/
      """
    And the response body matches:
          """
   /"city":"New York"/
   """
    And the response body matches:
      """
   /"status":{"id":"<status>"/
      """
    And the response body matches:
      """
   /"contact"/
      """

    Examples:
      | firstName    | lastName          | status      |
      | Andy Scott   | Lead Unqualified1 | unqualified |
      | Andy Art     | Lead Unqualified2 | unqualified |
      | Andy Bill    | Lead Valid1       | valid       |
      | Andy Charlie | Lead Valid2       | valid       |
      | Andy Dizzy   | Lead Valid3       | valid       |

  @api_post
  Scenario Outline: Api - POST lead creation validation, error expected  - ok dev 01/07
    Given the request body is:
      """
        {
          "requests": [
            {
              "@type": "general",
              "make": "Jeep",
              "model": "Renegade",
              "version": "2.0",
              "sourceUrl": "https://jeep.com"
            }
          ],
          "firstName": "<firstName>",
          "lastName": "<lastName>",
          "notes": "Richiesta SUV compatto",
            "activities": [],
          "email": "<email>",
          "phoneNumber": "<phone>",
          "addresses": [
            {
              "isPrimary": true,
              "city": "New York",
              "postalCode": "10011",
              "country": {
                "code": "US"
              }
            }
          ],
          "type": {
            "id": "<type>"
          },
          "status": {
            "id": "<status>"
          },
          "source": {
            "id": 1
          },
          "sourceDetail": {
            "id": <source>
          }
        }
      """
    And the "Content-Type" request header contains "application/json"
    When I request "/leads" using HTTP POST
    Then the response code is not 201

    Examples:
      | firstName   | lastName        | status      | email | phone | type    | source |
      | Andy Herbie | Lead Red        | unqualified |       |       | vehicle |        |
      |             | Andy Lead Green |             |       |       | vehicle | 1      |
      |             |                 |             |       |       | vehicle | 1      |


  Scenario: Api - GET full text lead search one: one item result  - ok dev 01/07
    When I request "/leads?page=1&itemsPerPage=50&fullText=Gillespie" using HTTP GET
    Then the response code is not 201
    And the response body matches:
      """
   /"email":"dizzy.gillespie@ew1.eu","phoneNumber":"39323322377640013","companyName":null,"jobTitle":null,"createdAt"/
      """

  @api_post
  Scenario Outline: Api - POST valid lead creation - duplicated case
    Given I insert test fixture base
    And the request body is:
      """
{
	"firstName": "Andy",
	"lastName": "<lastName>",
	"notes": null,
	 "source": {
        "id": "4177bc00-ad45-4d6e-a880-f9f6a2cf7632"
          },
     "sourceDetail": {
              "id": "55c05fd4-da49-41d3-96aa-38a053634d8e"
          },
	"channel": {
		"id": "55c05fd4-da49-41d3-96aa-38a053634d8f",
		"name": "test channel"
	},
	"type": {
		"id": "vehicle"
	},
	 "status": {
        "id": "valid"
          },
	"requests": [{
		"@type": "general",
		"make": "Jeep",
		"model": "Renegade",
		"version": "2.0",
		"vehicleType": {
			"id": "new",
			"name": ""
		},
                "sourceUrl": "https://jeep.com",
		"notes": "",
		"quantity": 1
	}],
	"addresses": [{
		"isPrimary": true,
		"city": "New York",
		"region": null,
		"postalCode": "10011",
		"street": null,
		"street2": null,
		"country": {
			"code": "US",
			"active": false
		}
	}],
	"contact": {
		"id": "f1c39dac-4b22-474d-96cf-f3a05cc28e13",
		"code": null,
		"street": null,
		"street2": null,
		"city": null,
		"postalCode": null,
		"region": null,
		"country": {
			"code": "AM",
			"active": false
		},
		"firstName": "Evey",
		"lastName": "Hammond",
		"emails": [{
			"id": "0c47cf48-8378-4eb3-ab13-35d34e15f320",
			"email": "evey.hammond@ew1.eu",
			"notes": null
		}],
		"phones": [{
			"id": "11e52a65-7ca8-48e7-917b-4ddeff3b977b",
			"phoneNumber": "3286937764"
		}],
		"account": {
			"id": "19794d90-996e-48bc-95eb-3db5c51547fd",
			"name": "Evey Hammond",
			"taxCode": "",
			"accountType": "/account_types/private",
			"channel": null,
			"channelIntegration": null
		},
		"dateOfBirth": null,
		"gender": null,
		"channel": null,
		"channelIntegration": null
	}
}
      """
    And the "Content-Type" request header contains "application/json"
    When I request "/leads" using HTTP POST
    Then the response code is 201

    Examples:
      | lastName             |
      | Post QALead valid1   |
      | Post QALead valid2   |
      | Post QALead valid3   |
      | Post QALead valid4   |
      | Post QALead valid5   |
      | Post QALead valid6   |
      | Post QALead LQ patch |

  @api_patch
  Scenario Outline: Api - PATCH lead add contact
    When patch the lead name "<name>" with payload:
    """
{
	"status": "valid",
	"requests": [{
		"make": "Jeep",
		"model": "Renegade",
		"version": "2.0",
		"price": null,
		"vehicleType": "new",
		"id": "%taskId%",
		"type": "general",
		"lead": "%leadId%",
		"notes": ""
	}],
	"contact": {
		"id": "%contactId%",
		"code": null,
		"street": null,
		"street2": null,
		"city": null,
		"postalCode": null,
		"region": null,
		"country": {
			"code": "IT",
			"active": true
		},
		"firstName": "Evey",
		"lastName": "Hammond",
		"emails": [{
			"id": "%emailsId%",
			"email": "evey.hammond@ew1.eu",
			"notes": null,
			"createdAt": "-0001-11-30T00:00:00+00:00",
			"updatedAt": "-0001-11-30T00:00:00+00:00"
		}],
		"phones": [{
			"id": "%phonesId%",
			"phoneNumber": "3286937764",
			"createdAt": "-0001-11-30T00:00:00+00:00",
			"updatedAt": "-0001-11-30T00:00:00+00:00"
		}],
		"account": {
			"id": "%accountId%",
			"name": "Evey Hammond Account",
			"taxCode": null,
			"accountType": {
				"id": "private",
				"name": "private"
			},
			"createdAt": "2019-10-01T13:25:09+00:00",
			"updatedAt": "2019-10-01T13:25:09+00:00",
			"externalId": null,
			"channel": null,
			"channelIntegration": null
		},
		"dateOfBirth": null,
		"gender": null,
		"createdAt": "2019-10-01T13:25:09+00:00",
		"updatedAt": "2019-10-01T13:25:09+00:00",
		"externalId": null,
		"channel": null,
		"channelIntegration": null,
		"privacySet": null
	},
	"vehicleOptionals": [],
	"notes": null,
	"features": [],
	"paymentOption": null
}
"""

    Then the response code is 201

    Examples:
      | name                      |
      | Andy Post QALead LQ patch |
