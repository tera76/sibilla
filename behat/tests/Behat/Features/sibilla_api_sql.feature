@sibilla @sql

Feature: api sql

  Scenario Outline: Api - check sibilla sql query status
    Given the request body is:
      """
{
	"request": [{
		"name": "login",
		"parameters": {
			"email": "ciccio",
			"password": "pass",
			"authenticationCode": "1976"
		}
	}, {
		"name": "sql",
		"parameters": {
			"query": "<query>"
		}
	}]
}
      """

    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 200
    And the response body is:
      """
	{"response":[{"from":"sql","query":"<query>","values":<results>}]}
      """

    Examples:
      | query                                                          | results             |
      | INSERT INTO syb_test (json_state) VALUES ('ddd1');             | true                |
      | INSERT INTO syb_test (json_state) VALUES ('ddd2'),('ddd3');    | true                |
      | INSERT INTOs syb_test (json_state) VALUES ('ddd');             | false               |
      | select json_state from syb_test  order by id desc limit 1;     | [["ddd3"]]          |
      | select json_state from syb_test  order by id desc limit 2;     | [["ddd3"],["ddd2"]] |
      | INSERTxxx INTO syb_test (json_state) VALUES ('ddd2'),('ddd3'); | false               |


  Scenario Outline: Api - check sibilla bad sql query, error 500
    Given the request body is:
      """
{
	"request": [{
		"name": "login",
		"parameters": {
			"email": "ciccio",
			"password": "pass",
			"authenticationCode": "1976"
		}
	}, {
		"name": "sql",
		"parameters": {
			"query": "<query>"
		}
	}]
}
      """

    When I request "/sibilla/api/post.php" using HTTP POST
    Then the response code is 500


    Examples:
      | query                                                         |
      | selectxxx json_state from syb_test  order by id desc limit 2; |
      | select json_state from syb_testxxx  order by id desc limit 2; |
