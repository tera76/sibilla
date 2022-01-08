<?php

use Behat\Symfony2Extension\Context\KernelAwareContext;
# use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;

use Page\LeadQualificationPage;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\LeadsPage;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use  Oro\Bundle\DataGridBundle\Tests\Behat\Context\GridContext;
use Behat\Mink\Element\NodeElement;

# require __DIR__ . '/../../../../api/conf/environment.conf.php';
require __DIR__ . '/Base/environment.conf.php';


class SibillaLogContext extends PageObjectContext
{
    use AssertTrait;

    protected $parameters;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }


    /**
     * @Given logs are disabled
     */
    public function checkEnvLogStatus()
    {

        self::assertEquals(false, logAction);

    }

    /**
     * @Given login is enabled
     */
    public function checkLoginEnabled()
    {

        self::assertEquals(true, loginAction);

    }
}