@api
@api1
Feature: task api requests

  Background: Retrieve Authentication token
    Given Authentication token is done

  Scenario: Api - GET tasks: Retrieves the collection of Task resources.
    When I request "/task-queue?page=1&itemsPerPage=200&fullText=QALead" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"subject":"Andy Post QALead valid4","description":"Jeep Renegade","status":"open","taskType":"lead_qualification","vehicleType":null,"leadId"/
      """
    And the response body matches:
      """
   /"subject":"Andy Post QALead valid5","description":"Jeep Renegade","status":"open","taskType":"lead_qualification","vehicleType":null,"leadId"/
      """

    # step actions

  Scenario: Api - GET tasks current-step: Retrieves a StepInstanceDto resource.
    When I request tasks current-step by subject "Andy Charlie Lead Valid2" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"activityType":"call","status":"process_step_status_active"/
      """


  Scenario: Api - GET tasks next-step: Retrieves a StepInstanceDto resource.
    When I request tasks next-step by subject "Andy Charlie Lead Valid2" using HTTP GET
    Then the response code is 200
    And the response body matches:
      """
   /"activityType":"call","status":"process_step_status_waiting"/
      """


