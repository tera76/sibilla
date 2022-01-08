<?php

use Behat\Gherkin\Node\TableNode;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\RulesEnginePage;
use Behat\MinkExtension\Context\RawMinkContext;

class RulesEngineContext extends PageObjectContext
{
    use AssertTrait;


    private $rulesEnginePage;
    private $params;

    public function __construct(RulesEnginePage $rulesEnginePage,  array $parameters)
    {
        $this->rulesEnginePage = $rulesEnginePage;
        $this->params = !empty($parameters) ? $parameters : array();
    }

    /**
     * @Then RulesEngine insert name
     */
    public function rulesEngineEditFormShouldContainsValues()
    {

        $form = $this->rulesEnginePage->createRole("ciccio");
    }




    /**
     * Fill form with data
     * Example: And fill form with:
     *            | Subject     | Simple text     |
     *            | Users       | [Charlie, Pitt] |
     *            | Date        | 2017-08-24      |
     *
     * @When /^(?:|I )fill RuleEngine form with:$/
     */
    public function iFillFormWith(TableNode $table)
    {
        $form = $this->rulesEnginePage->iFillFormWith($table);

    }








    /**
     * @param TableNode $table
     */
    public function assertText(TableNode $table)
    {
        foreach ($table->getRows() as $row) {
            list($label, $value) = $row;
            $locator = isset($this->options['mapping'][$label]) ? $this->options['mapping'][$label] : $label;
            $field = $this->findField($locator);
            self::assertNotNull($field, sprintf('Field `%s` not found', $label));

            $field = $this->wrapField($label, $field);

            $expectedValue = self::normalizeValue($value);
            $fieldValue = self::normalizeValue($field->getText());
            self::assertEquals($expectedValue, $fieldValue, sprintf('Field "%s" value is not as expected', $label));
        }
    }


    /**
     * Delete  item in rule engine grid
     *
     * @When I delete rule by name :arg1
     */
    public function iDeleteRuleByName($arg1)
    {

        $util = new \Base\ApiFeaturesContext($this->params);
        $id = $util->getRuleIdByName($arg1);

          $this->rulesEnginePage->deleteRuleById($id);


    }


}
