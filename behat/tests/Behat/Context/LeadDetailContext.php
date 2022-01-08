<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
#use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;

use Page\LeadQualificationPage;
use Page\LeadsPage;
use Page\LoginPage;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\LeadDetailPage;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Element\Element;
use Base\ApiFeaturesContext;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class LeadDetailContext extends PageObjectContext # implements SnippetAcceptingContext
{
    use AssertTrait;


    private $leadDetail;
    private $params;
    private $baseUrl;

    public function __construct(LeadDetailPage $leadDetail, array $parameters)
    {
        $this->leadDetail = $leadDetail;
        $this->params = !empty($parameters) ? $parameters : array();


    }


    /**
     * @Then Lead Detail title should be :arg1
     */
    public function leadDetailTitleShouldBe($arg1)
    {


        self::assertEquals($arg1, $this->leadDetail->getElement('Title')->getText());

    }


    /**
     * @Given I open lead detail for name :arg1
     */
    public function iOpenLeadDetailByName($arg1)
    {
        $util = new ApiFeaturesContext($this->params);
        $id = $util->getLeadIdByLeadName($arg1);
        $this->getPage(LeadDetailPage::class)->open(array('leadId' => $id));
        $this->getPage(LeadDetailPage::class)->getSession()->wait(1000);

    }


    public function iWait($timeout = 1)
    {
        $this->getPage()->getSession()->wait($timeout * 1000);
    }


    public function waitForNext()
    {
        $line = readline("Command: ");
        if ($line == 'exit') exit();
        if ($line == 'die') die();
        if ($line == 'e') exit();
    }

    /**
     * @When /^(?:|I )fill lead edit form with:$/
     */
    public function iFillEditFormWith(TableNode $table)
    {
        /** @var Form $form */
        //  $form = $this->createElement($formName);
        $form = $this->leadDetail->iFillEditFormWith($table);

    }

    /**
     * @When /^(?:|I )explode accordion tasks$/
     */
    public function iExplodeAccordionTasks()
    {
         $locator = '//*[contains(@class, "ls-accordion-toggle tp-size--s closed")]';

        while ($this->getPage(LeadDetailPage::class)->find('xpath', $locator)) {
            $this->getPage(LeadDetailPage::class)->find('xpath', $locator)->click();
            $this->getPage(LeadDetailPage::class)->getSession()->wait(1000);

        }
    }


    /**
     * @Then /^I should see Contact and Request sections$/
     */
    public function iShouldSeeContactAndRequestSections()
    {
        $this->leadDetail->ShouldSeeContactAndRequestSections();
    }

    /**
     * @Then /^I Should see Request and AdditionalInformation sections$/
     */
    public function iShouldSeeRequestAndAdditionalInformationSections()
    {
        $this->leadDetail->ShouldSeeRequestAndAdditionalInformationSections();
    }

    /**
     * @Then /^I should see AdditionalInformation and TradeIn sections$/
     */
    public function iShouldSeeAdditionalInformationAndTradeInSections()
    {
        $this->leadDetail->ShouldSeeAdditionalInformationAndTradeInSections();

    }

    /**
     * @Then /^I should see TradeIn and Tasks sections$/
     */
    public function iShouldSeeTradeInAndTasksSections()
    {
        $this->leadDetail->ShouldSeeTradeInAndTasksSections();

    }

    /**
     * @Then /^I check sms in activities with message "([^"]*)"$/
     */
    public function iCheckSmsInActivitiesWithMessage($arg1)
    {
        $telephone1SectionContact=$this->leadDetail->getElement('Telephone1SectionContact')->getText();
        $this->leadDetail->getElement("NavbarTasks")->click();
        $this->getPage(LeadDetailPage::class)->getSession()->wait(1000);
        $this->leadDetail->getElement("OpenAccordionTasks")->click();
        $this->getPage(LeadDetailPage::class)->getSession()->wait(1000);
        $telephone1SectionTasks=$this->leadDetail->getElement('Telephone1SectionTasks')->getText();
        $smsMessageSectionTasks=$this->leadDetail->getElement('SmsMessageSectionTasks')->getText();
        self::assertTrue('Telefono: ' . $telephone1SectionContact == $telephone1SectionTasks);
        self::assertTrue($smsMessageSectionTasks == $arg1);
    }

    /**
     * @Then /^I check email in activities with message "([^"]*)"$/
     */
    public function iCheckEmailInActivitiesWithMessage($arg1)
    {
        $email1SectionContact=$this->leadDetail->getElement('Email1SectionContact')->getText();
        $this->leadDetail->getElement("NavbarTasks")->click();
        $this->getPage(LeadDetailPage::class)->getSession()->wait(1000);
        $this->leadDetail->getElement("OpenAccordionTasks")->click();
        $this->getPage(LeadDetailPage::class)->getSession()->wait(2000);
        $email1SectionTasks=$this->leadDetail->getElement('Email1SectionTasks')->getText();
        $emailMessageSectionTasks=$this->leadDetail->getElement('EmailMessageSectionTasks')->getText();
        self::assertTrue('A: ' . $email1SectionContact == $email1SectionTasks);
        self::assertTrue($emailMessageSectionTasks == $arg1);
    }

    /**
     * @Then /^I check note in activities with message "([^"]*)"$/
     */
    public function iCheckNoteInActivitiesWithMessage($arg1)
    {
        $this->leadDetail->getElement("NavbarTasks")->click();
        $this->getPage(LeadDetailPage::class)->getSession()->wait(1000);
        $this->leadDetail->getElement("OpenAccordionTasks")->click();
        $this->getPage(LeadDetailPage::class)->getSession()->wait(2000);
        $noteSectionTasks=$this->leadDetail->getElement('NoteSectionTasks')->getText();
        self::assertTrue($noteSectionTasks == $arg1);
    }

    /**
     * @Then /^I add an outgoing call$/
     */
    public function iAddAnOutgoingCall()
    {
        $this->leadDetail->addAnOutgoingCall();
    }

    /**
     * @Then /^I check call in activities$/
     */
    public function iCheckCallInActivities()
    {
        $telephone1SectionContact=$this->leadDetail->getElement('Telephone1SectionContact')->getText();
        $this->leadDetail->getElement("NavbarTasks")->click();
        $this->getPage(LeadDetailPage::class)->getSession()->wait(1000);
        $this->leadDetail->getElement("OpenAccordionTasks")->click();
        $this->getPage(LeadDetailPage::class)->getSession()->wait(2000);
        $telephone1SectionTasks=$this->leadDetail->getElement('Telephone1SectionTasks')->getText();
        self::assertTrue('Telefono: ' . $telephone1SectionContact . ' • Direzione: In uscita' == $telephone1SectionTasks);
    }

}
