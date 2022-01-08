@api
@api_import
@api_import_offer_vehicle_stock
Feature: Using api POST for testing api import offer_vehicle_stock route

  Background: Retrieve Authentication token
    Given I am authenticated as admin user

  Scenario Outline: send POST to import offerVehicleStock. Expect the data to be persisted.
    Given the request body is:
    """
    {
      "externalId": "<offer.external_id>",
      "createdAt": "2019-09-02 15:47:56",
      "opportunity": {
          "name": "<opportunity.name>",
          "status": {
              "name": "won"
          },
          "ownerUser": {
              "externalId": "4024",
              "name": "AGIZZA STEFANIA"
          },
          "ownerBusinessUnit": {
              "externalId": "2",
              "name": "Parma"
          },
          "contact": {
              "account": {
                  "accountType": {
                      "name": "private"
                  }
              },
              "externalId": "<contact.external_id>",
              "firstName": "CAVATORTA ",
              "lastName": "MARCO",
              "dateOfBirth": "1964-09-10",
              "phones": [
                  {
                      "phoneNumber": "<contact_phone.phone_number>"
                  }
              ],
              "emails": [
                  {
                      "email": "<contact_email.email>"
                  }
              ],
              "privacyPreferenceSet": {
                  "privacyPreferences": [
                      {
                          "privacyPreferenceChannels": [
                              {
                                  "privacyPreferenceChannelDetails": [
                                      {
                                          "isAccepted": 1,
                                          "value": "marcox1fx1f_109@libero.it"
                                      }
                                  ],
                                  "privacyChannelType": {
                                      "name": "email"
                                  }
                              },
                              {
                                  "privacyPreferenceChannelDetails": [
                                      {
                                          "isAccepted": 1,
                                          "value": "3402525674"
                                      }
                                  ],
                                  "privacyChannelType": {
                                      "name": "sms"
                                  }
                              },
                              {
                                  "privacyPreferenceChannelDetails": [
                                      {
                                          "isAccepted": 1,
                                          "value": "3402525674"
                                      }
                                  ],
                                  "privacyChannelType": {
                                      "name": "call"
                                  }
                              }
                          ],
                          "privacyPreferenceType": {
                              "name": "marketing"
                          }
                      }
                  ]
              },
              "city": "LANGHIRANO",
              "region": "PR",
              "street": "Piazza DELLA PACE,1",
              "postalCode": "43013"
          },
          "tradeIn": {
              "make": {
                  "name": "KIA"
              },
              "model": "Sportage 2u00aa serie",
              "plate": "<opportunity_trade_in.plate>",
              "vin": "KNEJE55256K229502",
              "registryDate": "2006-09-21 15:47:56",
              "km": 238000,
              "evaluation": 1500
          }
      },
      "closedAt": "2019-09-02 15:47:56",
      "vehicleRegistryItem": {
          "type": {
              "name": "NUOVO"
          },
          "vehicle": {
              "make": {
                  "name": "KIA"
              },
              "model": "QL(S)",
              "version": "NEW SPORTAGE 6D 1.6 GDI ENERGY",
              "externalId": "<vehicle.external_id>",
              "vin": "U5YPH814ALL778366",
              "km": 0
          },
          "listPrice": 24450
      },
      "financing": false
  }
    """
    When I request "/import/offer_vehicle_stock" using HTTP POST
    Then the response code is 201
    And records match example row for all columns with possible duplicates
    Examples:
      | contact.external_id | contact_phone.phone_number | contact_email.email | vehicle.external_id | offer.external_id | opportunity.name | opportunity_trade_in.plate |
      | 11                  | 333-111-222-331            | example1@email.com  | 475486-N            | 0099352@250863CN  | name1            | PLATE1                     |
      | 21                  | 333-111-222-332            | example2@email.com  | 475486-N            | 0099352@250863CN  | name2            | PLATE2                     |
      | 31                  | 333-111-222-333            | example3@email.com  | 475486-N            | 0099352@250863CN  | name3            | PLATE3                     |
#
#  Scenario Outline: send POST to import offerAfterSale. Expect the data to be updated.
#    Given the request body is:
#    """
#    {
#  "opportunity": {
#    "leadSparkCrmId": <opportunity.lead_spark_crm_id>,
#    "externalId": "1",
#    "closedAt": "2019-08-23",
#    "status": {
#      "name": "won"
#    },
#    "updatedAt": "2019-08-25 20:32:07",
#    "contact": {
#      "leadSparkCrmId": <contact.lead_spark_crm_id>,
#      "externalId": "05251790720@295314",
#      "emails": {
#        "1": {
#          "email": "<>"
#        }
#      },
#      "phones": {
#        "1": {
#          "phoneNumber": "3663468911"
#        },
#        "2": {
#          "phoneNumber": "3663468911"
#        }
#      },
#      "street": "<contact.street>",
#      "city": "TORITTO",
#      "postalCode": "70020",
#      "region": "BA",
#      "country": {
#        "code": "IT"
#      },
#      "firstName": "<contact.first_name>",
#      "lastName": "<contact.last_name>",
#      "dateOfBirth": "1978-05-13",
#      "updatedAt": "2019-08-25 20:32:25",
#      "privacyPreferenceSet": {
#        "privacyPreferences": {
#          "3": {
#            "privacyPreferenceChannels": {
#              "1": {
#                "privacyChannelType": {
#                  "name": "email"
#                },
#                "privacyPreferenceChannelDetails": {
#                  "1": {
#                    "isAccepted": true,
#                    "value": "v.ancona@bppb.it"
#                  },
#                  "2": {
#                    "isAccepted": true
#                  }
#                }
#              },
#              "2": {
#                "privacyChannelType": {
#                  "name": "sms"
#                },
#                "privacyPreferenceChannelDetails": {
#                  "1": {
#                    "isAccepted": true,
#                    "value": "3663468911"
#                  },
#                  "2": {
#                    "isAccepted": true,
#                    "value": "3663468911"
#                  }
#                }
#              },
#              "3": {
#                "privacyChannelType": {
#                  "name": "call"
#                },
#                "privacyPreferenceChannelDetails": {
#                  "1": {
#                    "isAccepted": true,
#                    "value": "3663468911"
#                  },
#                  "2": {
#                    "isAccepted": true,
#                    "value": "3663468911"
#                  }
#                }
#              }
#            },
#            "privacyPreferenceType": {
#              "name": "marketing"
#            },
#            "isAccepted": false
#          },
#          "1": {
#            "privacyPreferenceType": {
#              "name": "data_processing"
#            },
#            "isAccepted": true
#          },
#          "2": {
#            "privacyPreferenceType": {
#              "name": "third_party_assignment"
#            }
#          }
#        }
#      },
#      "account": {
#        "accountType": {
#          "name": "private"
#        },
#        "leadSparkCrmId": "281989"
#      }
#    },
#    "tradeIn": {
#      "leadSparkCrmId": "304629",
#      "make": {
#        "name": "Ford"
#      },
#      "model": "Fusion",
#      "km": 168000,
#      "plate": "DE102YD",
#      "registryDate": "2007-01-26",
#      "evaluation": 1500
#    }
#  },
#  "isMainOffer": true,
#  "isWon": true,
#  "totalAmount": 18088,
#  "discount": 0,
#  "deposit": 0,
#  "vehicleRegistryItem": {
#    "listPrice": 0,
#    "discountedPrice": 0,
#    "type": {
#      "name": "new"
#    },
#    "vehicle": {
#      "leadSparkCrmId": 97125,
#      "externalId": "N134303",
#      "make": {
#        "name": "Fiat"
#      },
#      "model": "500x Cross-Look Serie 3 1.6 E-Torq 110cv E6dtemp City Cross",
#      "km": 0,
#      "vin": "ZFA3340000P793819",
#      "color": "019"
#    }
#  }
#}
#    """
#    When I request "/import/vehicle_offer" using HTTP POST
#    Then the response code is 201
#    And there is exactly 1 opportunity with "lead_spark_crm_id = <opportunity.lead_spark_crm_id>"
#    And there is exactly 1 contact with "lead_spark_crm_id = <contact.lead_spark_crm_id>, street = <contact.street>"
#    Examples:
#      | opportunity.lead_spark_crm_id | contact.lead_spark_crm_id | contact.street | contact.first_name | contact.last_name |
#      | 11                            | 11                        | street1        | firstname1         | lastname1         |
#      | 11                            | 21                        | street2        | firstname2         | lastname2         |
#      | 11                            | 31                        | street3        | firstname3         | lastname3         |
