@api_skip
@vehicles

Feature: vehicle api requests  - ok dev 23-06-2019

  Background: Retrieve Authentication token
    Given Authentication token is done

  Scenario: Api - GET vehicle by search  - ok dev 23-06-2019
    When I request "/vehicle_registry_items?page=1&itemsPerPage=20" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"name":"Fiat"/
      """
    And the response body matches:
      """
   /"plateNumber"/
      """


  Scenario: Api - GET vehicles: Retrieves a Vehicle resource registry item by version.  - ok dev 23-06-2019
    When I request vehicle_registry_items by version "Mini One D Countryman" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"name":"Mini","active":true,"synonyms":"Mini"/
      """
    And the response body matches:
      """
   /"fuelType":{"id":"diesel","name":"diesel"}/
      """






  Scenario: Api - GET vehicles: Retrieves a Vehicle resource by version.  - ok dev 23-06-2019
    When I request vehicle by version "Station Wagon 1,6 Mjt 120cv Lounge Sw Stock My 2017)" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"model":"Tipo","version":"Station Wagon 1,6 Mjt 120cv Lounge Sw Stock My 2017/
      """



