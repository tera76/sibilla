@api
Feature: Using api GET and POST for testing api leads

  Background: Retrieve Authentication token
    Given Authentication token is done

@api_post_greg
Scenario Outline: Api - POST multiple lead creation "Valid" and "Unqualified"
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
    | firstName  | lastName   | status      | email                    | phone              | type    | contactId                            |
    | Jorge      | Lorenzo    | unqualified | jorge.lorenzo@ew1.eu     | 3932869377640001   | vehicle |                                      |
    | Marc       | Marquez    | unqualified | danilo.petrucci@ew1.eu   | 3932869377640002   | vehicle |                                      |
    | Valentino  | Rossi      | unqualified | valentino.rossi@ew1.eu   | 3932869377640003   | vehicle |                                      |
    | Max        | Biaggi     | unqualified | max.biaggi@ew1.eu        | 3932869377640004   | vehicle |                                      |
    | Danilo     | Petrucci   | valid       | danilo.petrucci@ew1.eu   | 3932869377640005   | vehicle | f1c39dac-4b22-474d-96cf-f3a05cc28e13 |
    | Franco     | Morbidelli | unqualified | franck.morbidelli@ew1.eu | 3932869377640006   | vehicle |                                      |
    | Giacomo    | Agostini   | valid       | giacomo.agostini@ew1.eu  | 3932869377640007   | vehicle | f1c39dac-4b22-474d-96cf-f3a05cc28e13 |
    | Andrea     | Iannone    | valid       | andrea.iannone@ew1.eu    | 3932869377640008   | vehicle | f1c39dac-4b22-474d-96cf-f3a05cc28e13 |
    | Pol        | Espargarò  | valid       | pol.espargaro@ew1.eu     | 3932869377640009   | vehicle | f1c39dac-4b22-474d-96cf-f3a05cc28e13 |

  @api_post_greg
  Scenario Outline: Api - POST valid lead multiple creation "Valid"
    Given I insert test fixture base
    And the request body is:
      """
{
	"firstName": "<firstName>",
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
		"id": "",
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
		"firstName": "<firstName>",
		"lastName": "<lastName>",
		"emails": [{
			"id": "0c47cf48-8378-4eb3-ab13-35d34e15f320",
			"email": "<email>",
			"notes": null
		}],
		"phones": [{
			"id": "11e52a65-7ca8-48e7-917b-4ddeff3b977b",
			"phoneNumber": "<phone>"
		}],
		"account": {
			"id": "19794d90-996e-48bc-95eb-3db5c51547fd",
			"name": "<firstName> <lastName>",
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
      | firstName | lastName   | email                     | phone          |
      | Jesse     | Owens      | jesse.owens@ew1.eu        | 33354445464646 |
      | Mark      | Spitz      | mark.spitz@ew1.eu         | 33356457998848 |
      | Pietro    | Mennea     | pietro.mennea@ew1.eu      | 34556674855987 |
      | Nadia     | Comaneci   | nadia.comaneci@ew1.eu     | 34477766885758 |
      | Umberto   | Pellizzari | umberto.pellizzari@ew1.eu | 33355566777668 |
