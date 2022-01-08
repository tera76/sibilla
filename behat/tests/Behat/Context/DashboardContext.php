<?php

use Behat\Symfony2Extension\Context\KernelAwareContext;
# use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;
use Oro\Bundle\TestFrameworkBundle\Behat\Fixtures\FixtureLoaderAwareInterface;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\Dashboard;
use Behat\MinkExtension\Context\RawMinkContext;


class DashboardContext extends PageObjectContext
{
    use AssertTrait;


    private $dashboard;


    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * @Given /^(?:|I )visited dashboard/
     */
    public function iVisitedThePage()
    {
        $this->getPage(Dashboard::class)->open();
    }

    /**
     * @Then /^Dashboard title should be "(?P<expected>[\w\s]+)"$/
     */
    public function     dashboardTitleShouldBe($expected)
    {

        self::assertEquals( $this->dashboard->getTitle(), $expected, "Dashboard Title value is not the expected.");


    }
}