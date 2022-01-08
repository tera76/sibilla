@chili

Feature: Decrypt password from an old chili cas db sha256

  Scenario Outline: Decrypt example password and check if it is in db
    Given Encrypt sha2 <password>
    Examples:
    |password|
    |chili123|

