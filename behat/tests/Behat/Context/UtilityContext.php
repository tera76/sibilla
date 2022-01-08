<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Motork\Bundle\LeadsparkBundle\Tests\Behat\Element\LeadsparkForm;
use Oro\Bundle\TestFrameworkBundle\Behat\Driver\OroSelenium2Driver;
use \Behat\Mink\Session;
use\Behat\Behat\Context\TranslatableContext;
use Page\LeadDetailPage;
use Page\LoginPage;
use WebDriver\Exception\StaleElementReference;
use Behat\Behat\Definition\Call;


/**
 * Utility context.
 */
class UtilityContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
#    use PageObjectDictionary;
    private $output;
    private $params;


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */

    public function __construct(array $parameters)
    {

        $this->params = !empty($parameters) ? $parameters : array();
    }


    /**
     * @When Open ciccio
     */
    public function openCiccio()
    {

        $this->visitPath('http://localhost/sibilla/client/test.php');
        // die();


    }

    /**
     * @Given Wait for next
     */
    public function waitForNext()
    {
        $line = readline("Command: ");
        if ($line == 'exit') exit();
        if ($line == 'die') die();
        if ($line == 'e') exit();
    }


    /**
     * Example: Given I wait 1 second
     * Example: Given I wait 2 seconds
     *
     * @When /^(?:|I )wait (?P<timeout>\d) second(s){0,1}.*$/
     *
     * @param int $timeout
     */
    public function iWait($timeout = 1)
    {
        $this->getSession()->wait($timeout * 1000);
    }


    /**
     * Returns fixed step argument (with \\" replaced back to ")
     *
     * @param string $argument
     *
     * @return string
     */
    protected function fixStepArgument($argument)
    {
        return str_replace('\\"', '"', $argument);
    }

    /**
     * @return \Behat\Mink\Element\DocumentElement
     */
    private function getPage()
    {
        return $this->getSession()->getPage();
    }


    /**
     * Press xx in field chapter by chapter. Imitate real user input from keyboard
     * @Given /^(?:|I )press key "(?P<value>(?:[^"]|\\")*)" in "(?P<locator>(?:[^"]|\\")*)"$/
     */
    public function pressKeyValueInField($locator, $value)
    {

        /*
        var_dump($field,$value);
        $this->getSession()
        ->getPage()
        ->findField($field)
        ->keyPress($value);
*/


        $field = $this->fixStepArgument($locator);
        $value = $this->fixStepArgument($value);
        #   $this->getSession()->keyPress($field, $value);
        $this->getSession()->getPage()->findField($field)->keyPress($value, $field);
        //    $this->getSession()->keyPress($this->getXpath(), $char, $modifier);

    }

    /**
     * @When /^I Click on element "([^"]*)"$/
     */
    public function iClickOnElement($arg1)
    {
        $this->getSession()->getPage()->find("xpath", "//*[contains(text(),'" . $arg1 . "')]")->click();
    }
    /**
     * @Then /^(?:|I )click (?:on |)(?:|the )"([^"]*)"(?:|.*)$/
     */
    public function iClickOn($arg1)
    {
// to dooooooooooooooooo
        $findName = $this->getSession()->getPage()->find("css", $arg1);
        $findContains = $this->getSession()->getPage()->find("xpath", "//*[contains(text(),'" . $arg1 . "')]");
// var_dump($findContains);
// die();


        if ($findContains) {
            $findName->getOuterHtml()->click();
            return;
        }
 //       die();
        if (!$findName) {
            throw new Exception($arg1 . " could not be found");
        } else {
            $findName->click();
        }
    }


    /**
     * Click some text
     *
     * @When /^I click on the text "([^"]*)"$/
     */
    public function iClickOnTheText($text)
    {
        $session = $this->getSession();
        $element = $session->getPage()->find(
            'xpath',
            #   $session->getSelectorsHandler()->selectorToXpath('xpath', '*//*[text()="'. $text .'"]')
            $session->getSelectorsHandler()->selectorToXpath('xpath', '//*[contains(text(), $text)]')
        );
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Cannot find text: "%s"', $text));
        }

        $element->click();

    }


    /**
     * @Transform firsName_timestamp
     * @Transform name_timestamp
     */


    public function returnTimestampNameIdentifier($text)
    {

        return 'qaname_' . $GLOBALS['timestampIdentifier'];
    }

    /**
     * @Transform  /^email_timestamp$/
     */


    public function returnTimestampMailIdentifier($text)
    {

        return 'qamail_' . $GLOBALS['timestampIdentifier'] . '@ew1.eu';
    }

    /**
     * @Transform  /^phone_timestamp$/
     */

    public function returnTimestamPhoneIdentifier($text)
    {

        return '3323/' . $GLOBALS['timestampIdentifier'];
    }


    /**
     * @Given the timestamp is defined
     */
    public function defineTimestampIdentifier()
    {

        $GLOBALS['timestampIdentifier'] = time();

    }


    /**
     * Type value in field chapter by chapter. Imitate real user input from keyboard
     * Example: And type "Common" in "search"
     * Example: When I type "Create" in "Enter shortcut action"
     *
     * @When /^(?:|I )type "(?P<value>(?:[^"]|\\")*)" in "(?P<field>(?:[^"]|\\")*)"$/
     */
    public function iTypeInFieldWith($locator, $value)
    {
        $locator = $this->fixStepArgument($locator);
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($locator, $value);


    }


    /**
     * @Given I press :arg1 if exist
     */
    public function IPressIfExist($arg1)
    {
        try {
        $this->getSession()->getPage()->pressButton($arg1);
        } catch
        (Exception $e) {
            var_dump("Button " . $arg1 . " not found.");
        }
    }

    /**
     * Click on the element with the provided xpath query
     *
     * @When /^I click on the element with xpath "([^"]*)"$/
     */
    public function iClickOnTheElementWithXPath($xpath)
    {
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)
        ); // runs the actual query and returns the element

        // errors must not pass silently
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
        }

        // ok, let's click on it
        $element->click();

    }


}
