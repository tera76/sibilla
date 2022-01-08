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

use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class ChiliCASContext extends PageObjectContext # implements SnippetAcceptingContext
{
    use AssertTrait;


    private $contactDetail;
    private $params;
    private $baseUrl;

    public function __construct(ContactDetailPage $contactDetail, array $parameters)
    {
        $this->contactDetail = $contactDetail;
        $this->params = !empty($parameters) ? $parameters : array();


    }


    /**
     * @Given Encrypt sha2 :arg1
     */
    public function encryptSha2($arg1)
    {

        var_dump($arg1);
        die();

    }


}
