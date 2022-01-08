<?php

use Base\ApiFeaturesContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;


use Page\OpportunityDetailPage;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Page\Element\Table;


use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class OpportunityDetailContext extends PageObjectContext # implements SnippetAcceptingContext
{
    use AssertTrait;


    private $opportunityDetailPage;
    private $params;
    private $baseUrl;

    private $addLeadPage;

    public function __construct(OpportunityDetailPage $opportunityDetailPage, array $parameters)
    {
        $this->opportunityDetailPage = $opportunityDetailPage;
        $this->params = !empty($parameters) ? $parameters : array();


    }


    /**
     * @Then Opportunity Detail title should be :arg1
     */
    public function OpportunityDetailTitleShouldBe($arg1)
    {


        self::assertEquals($arg1, $this->opportunityDetailPage->getElement('Title')->getText());

    }


    /**
     * @Given I open opportunity detail for name :arg1
     */
    public function iOpenOpportunityDetailByName($arg1)
    {

        $util = new ApiFeaturesContext($this->params);
        $id = $util->getOpportunityIdByOpportunityName($arg1);
        $this->getPage(OpportunityDetailPage::class)->open(array('opportunityId' => $id));
        $this->getPage(OpportunityDetailPage::class)->getSession()->wait(1000);

    }


    /**
     * Fill form with data
     * Example: And fill form with:
     *            | Subject     | Simple text     |
     *            | Users       | [Charlie, Pitt] |
     *            | Date        | 2017-08-24      |
     *
     * @When /^(?:|I )fill OpportunityFail form with:$/
     */
    public function iFillFormWith(TableNode $table)
    {
        $this->opportunityDetailPage->iFillFormWith($table);

    }


    /**
     * @When I send an SMS with message :arg1
     */
    public function iSendAnSMS($arg1)
    {
        $this->opportunityDetailPage->sendSMS($arg1);

    }


    /**
     * @When I send a Mail with template :arg1
     */
    public function iSendAMail($arg1)
    {
        $this->opportunityDetailPage->sendMail($arg1);

    }



    /**
     * @When I add a note :arg1
     */
    public function iAddANote($arg1)
    {
        $this->opportunityDetailPage->addANote($arg1);

    }


    /**
     * @When I add a Call
     */
    public function iAddACall()
    {
        $this->opportunityDetailPage->addACall();


    }

    /**
     * @When /^I send a sms with message "([^"]*)" from opportunity\-detail$/
     */
    public function iSendASmsWithMessageFromOpportunityDetail($arg1)
    {
        $this->opportunityDetailPage->SendASmsWithMessageFromOpportunityDetail($arg1);
    }

    /**
     * @Then /^I check sms in opportunities activities with message "([^"]*)"$/
     */
    public function iCheckSmsInOpportunitiesActivitiesWithMessage($arg1)
    {
        $this->opportunityDetailPage->CheckSmsInOpportunitiesActivitiesWithMessage($arg1);
    }

    /**
     * @When /^I send an email with message "([^"]*)" from opportunity\-detail$/
     */
    public function iSendAnEmailInOpportunitiesActivitiesWithMessage($arg1)
    {
        $this->opportunityDetailPage->SendAnEmailInOpportunitiesActivitiesWithMessage($arg1);
    }

    /**
     * @Then /^I check email in opportunities activities with message "([^"]*)"$/
     */
    public function iCheckEmailInOpportunitiesActivitiesWithMessage($arg1)
    {
        $this->opportunityDetailPage->CheckEmailInOpportunitiesActivitiesWithMessage($arg1);
    }

    /**
     * @Then /^I check note in opportunities activities with description "([^"]*)"$/
     */
    public function iCheckNoteInOpportunitiesActivitiesWithDescription($arg1)
    {
        $this->opportunityDetailPage->CheckNoteInOpportunitiesActivitiesWithDescription($arg1);
    }

    /**
     * @When /^I add a "([^"]*)" outgoing call with note "([^"]*)" from opportunity\-detail$/
     */
    public function iAddAOutgoingCallWithNoteFromOpportunityDetail($arg1,$arg2)
    {
        $this->opportunityDetailPage->AddAOutgoingCallWithNoteFromOpportunityDetail($arg1,$arg2);
    }

    /**
     * @Then /^I check call in opportunities activities with note "([^"]*)"$/
     */
    public function iCheckCallInOpportunitiesActivitiesWithNote($arg1)
    {
        $this->opportunityDetailPage->CheckCallInOpportunitiesActivitiesWithNote($arg1);
    }


    /**
     * @Given I add an offer for :arg1
     *
     */
    public function addAnOffer($arg1)
    {


        $this->opportunityDetailPage->AddAnOffer($arg1);


    }

    /**
     * @Given I add sell opportunity
     *
     */
    public function addSellOpportunity()
    {


        $this->opportunityDetailPage->SellOpportunity();



    }

    /**
     * @When /^(?:|I )explode accordion opportunity/
     */
    public function iExplodeAccordionOpportunity()
    {
        $locator = '//*[contains(@class, "ls-accordion-toggle tp-size--s closed")]';

        while ($this->getPage(OpportunityDetailPage::class)->find('xpath', $locator)) {
            $this->getPage(OpportunityDetailPage::class)->find('xpath', $locator)->click();
            $this->getPage(OpportunityDetailPage::class)->getSession()->wait(1000);

        }
    }
}
