@sibilla @preconditions

Feature: check preconditions for sibilla test execution

  Scenario: Api - check login enabled
    Given login is enabled

  Scenario: Api - check default log disabled
    Given logs are disabled

  #  Scenario: Api - check db connection ok