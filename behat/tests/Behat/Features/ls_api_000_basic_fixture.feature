@api

Feature: Using api GET and POST for testing api leads

  Background: Retrieve Authentication token
    Given Authentication token is done

    # *** channels and sources and spurces_detail tst

  @api_post
  Scenario: Api - GET check channel test data - start up POST
    Given I insert test fixture base
    When I request "/channels/55c05fd4-da49-41d3-96aa-38a053634d8f" using HTTP GET
    Then the response code is not 201
    And the response body matches:
      """
   /"name":"test channel1Andy"/
      """

  Scenario: Api - GET sources test data
    When I request "/sources/4177bc00-ad45-4d6e-a880-f9f6a2cf7632" using HTTP GET
    Then the response code is not 201
    And the response body matches:
      """
   /"name":"TestWebAndy"/
      """

  Scenario: Api - GET sourceDetail test data
    When I request "/source_details/55c05fd4-da49-41d3-96aa-38a053634d8e" using HTTP GET
    Then the response code is not 201
    And the response body matches:
      """
    /"name":"www.testAndy.com","logoUrl":"www.testAndy.com"/
      """

  Scenario: Api - GET account test data
    When I request "/accounts/19794d90-996e-48bc-95eb-3db5c51547fd" using HTTP GET
    Then the response code is not 201
    And the response body matches:
      """
    /"name":"Andy Fixture1 Account"/
      """

  Scenario: Api - GET contact test data
    When I request "/contacts/f1c39dac-4b22-474d-96cf-f3a05cc28e13" using HTTP GET
    Then the response code is not 201
    And the response body matches:
      """
    /"firstName":"Andy Contact1","lastName":"Fixture"/
      """
  Scenario: Api - GET contact_email test data
    When I request "/contact_emails/0c47cf48-8378-4eb3-ab13-35d34e15f320" using HTTP GET
    Then the response code is not 201
    And the response body matches:
      """
    /"email":"andyfixture.contact1@ew1.eu"/
      """

  Scenario: Api - GET contact_phone test data
    When I request "/contact_phones/11e52a65-7ca8-48e7-917b-4ddeff3b977b" using HTTP GET
    Then the response code is not 201
    And the response body matches:
      """
    /"phoneNumber":"328100000"/
      """

