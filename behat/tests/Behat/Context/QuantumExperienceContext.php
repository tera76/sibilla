<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
#use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;

use Page\LoginPage;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\ContactDetailPage;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Element\Element;
use Base\ApiFeaturesContext;
use Page\OpportunityDetailPage;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class QuantumExperienceContext extends PageObjectContext # implements SnippetAcceptingContext
{
    use AssertTrait;


    private $opportunityDetailPage;
    private $params;
    private $baseUrl;


    public function __construct(OpportunityDetailPage $opportunityDetailPage)
    {
        $this->opportunityDetailPage = $opportunityDetailPage;
        // $this->params = !empty($parameters) ? $parameters : array();


    }


    /**
     * @Given ccc
     */
    public function encryptSha2($arg1)
    {

        var_dump($arg1);
        die();

    }


}
