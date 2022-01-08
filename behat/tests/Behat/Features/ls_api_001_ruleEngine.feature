@api
Feature: Using api GET and POST for testing api rules  -

  Background: Retrieve Authentication token
    Given Authentication token is done


  @api_post
  Scenario: Api - POST lead qualification rule creation
    Given the rule engine request body for "Demo Srl" is:
      """
{
	"ruleChain": {
		"id": "6aa92f21-4fa4-40c3-a035-df13d3e87f5b"
	},
	"rowIndex": 1,
	"status": "enabled",
	"name": "testRule basicAndy",
	"ruleDescription": "Conditions Andy rule description",
	"actionDescription": "Action Andy rule description",
	"fullDescription": "task_assign_to|%demoBUName%",
	"action": {
		"configurationAction": {
			"id": "bfbc1b39-c8df-4a30-ade1-9fef38c7f645"
		},
		"values": [{
			"value": "%demoBUid%",
			"configurationActArg": {
				"id": "e0a64cff-f88c-4748-8d84-4206d3e4a0fc"
			}
		}]
	},
	"process": {
		"context": "process_context_lead_qualification",
		"notificationTargets": null,
		"step": {
			"activityType": "call",
			"dueDate": 7200,
			"notifyAt": 300,
			"child": {
				"activityType": "call",
				"dueDate": 14400,
				"notifyAt": 300,
				"child": {
					"activityType": "call",
					"dueDate": 86400,
					"notifyAt": 300,
					"child": null
				}
			}
		}
	},
	"conditionGroup": {
		"rowIndex": 0,
		"logicalOperator": {
			"id": "69fc6595-d073-4b9f-bc1c-bbf5adcb3a1a"
		},
		"conditions": [{
			"rowIndex": 0,
			"conditionalOperator": {
				"id": "9ffc526e-4f02-425b-8b52-55b0a9a7273f"
			},
			"configurationAttribute": {
				"id": "f3bca018-0f00-45b9-bae6-5a8d1c12bf41"
			},
			"values": ["vehicle"]
		}],
		"conditionsGroup": []
	}
}
      """
    And the "Content-Type" request header contains "application/json"
    When I request "/rule_engine/rules" using HTTP POST
    Then the response code is 201


  @api_post
  Scenario: Api - POST Opportunity rule creation
    Given the rule engine request body for "Demo Srl" is:
      """
      {
	"ruleChain": {
		"id": "b2342b58-df5d-41a4-a6d7-e9b71215b29b"
	},
	"rowIndex": 1,
	"status": "enabled",
	"name": "OpportunityRule test1",
	"ruleDescription": "Conditions rule description",
	"actionDescription": "Action rule description",
	"fullDescription": "task_assign_to_business_unit|%demoBUName%",
	"action": {
		"configurationAction": {
			"id": "64af5f91-8d65-4857-af74-37eccaee414b"
		},
		"values": [{
			"value": "%demoBUid%",
			"configurationActArg": {
				"id": "74311d22-1c8a-4144-af4a-e8e30fa11766"
			}
		}]
	},
	"process": {
		"context": "process_context_follow_up",
		"notificationTargets": null,
		"step": {
			"activityType": "call",
			"dueDate": 3600,
			"notifyAt": 300,
			"child": null
		}
	},
	"conditionGroup": {
		"rowIndex": 0,
		"logicalOperator": {
			"id": "69fc6595-d073-4b9f-bc1c-bbf5adcb3a1a"
		},
		"conditions": [{
			"rowIndex": 0,
			"conditionalOperator": {
				"id": "9ffc526e-4f02-425b-8b52-55b0a9a7273f"
			},
			"configurationAttribute": {
				"id": "9fd525f4-61f0-407f-b8eb-011ccab7ec5b"
			},
			"values": ["04283fc7-4a4e-4d1e-8e72-60c20e7b0dae"]
		}],
		"conditionsGroup": []
	},
	"delay": 0
}

      """
    And the "Content-Type" request header contains "application/json"
    When I request "/rule_engine/rules" using HTTP POST
    Then the response code is 201
