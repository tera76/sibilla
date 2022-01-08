<?php

namespace Page;

use Base\ApiFeaturesContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ElementNotFoundException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;

class RulesEnginePage extends Page
{


    protected $elements = array(
        'ManageRule_Form' => array('xpath' => "//*"),
        'ruleName' => array('xpath' => '//*/input[@name="ruleName"]'),
        'SelectConditions' => array('xpath' => '//*/div[1]/div[1]/div/div[2]/form/div/div[2]/form/div[5]/div/div/div[2]/div/div/div/div/div/div[1]/div/div/select'),
        'LogicalSelectConditions' => array('xpath' => '//*/div[1]/div[1]/div/div[2]/form/div/div[2]/form/div[5]/div/div/div[2]/div/div/div/div/div/div[2]/div/div/select'),
        'LeadTypeSelectConditions' => array('xpath' => '//*/div[1]/div[1]/div/div[2]/form/div/div[2]/form/div[5]/div/div/div[2]/div/div/div/div/div/div[3]/div/div/select'),
        'SelectActionType' => array('xpath' => '//*/div[1]/div[1]/div/div[2]/form/div/div[2]/form/div[6]/div/div/div[2]/div/div[1]/div/div/select'),
        'SelectActionTeam' => array('xpath' => '//*/div[1]/div[1]/div/div[2]/form/div/div[2]/form/div[6]/div/div/div[2]/div/div[2]/div/div/select'),
        'SelectTaskType' => array('xpath' => '//*/div[1]/div[1]/div/div/div[2]/form/div/div[2]/form/div[7]/div/div/div[2]/div[1]/div[2]/div/div/select'),
        'SelectTaskTime' => array('xpath' => '//*/div[1]/div[1]/div/div/div[2]/form/div/div[2]/form/div[7]/div/div/div[2]/div[1]/div[3]/div/div/select'),
        'SelectTaskNotify' => array('xpath' => '//*/div[1]/div[1]/div/div/div[2]/form/div/div[2]/form/div[7]/div/div/div[2]/div[1]/div[4]/div/div/select')


    );


    public function createRole($ruleName)
    {

        $this->getElement('ruleName')->setValue($ruleName);
        $this->getElement('ManageRule_Form')->pressButton('Salva');


    }


    public function iFillFormWith(TableNode $table)
    {

        foreach ($table->getRows() as $row) {
            list($label, $value) = $row;
            # working with select
            if ($label == 'SelectConditions' || $label == 'LogicalSelectConditions' || $label == 'LeadTypeSelectConditions'
                || $label == 'SelectActionType' || $label == 'SelectActionTeam'  || $label == 'SelectTaskType'   || $label == 'SelectTaskTime'   || $label == 'SelectTaskNotify' ) {
                if ($value <> '') {
                    $this->getElement($label)->selectOption($value);
                }

                #    $this->waitForNext();
            } else $this->getElement($label)->setValue($value);
        }
    }


    public function deleteRuleById($arg1)
    {


        $this->find('xpath', '//*[@id="' . $arg1 . '"]/div/div[5]')->click();

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

}
