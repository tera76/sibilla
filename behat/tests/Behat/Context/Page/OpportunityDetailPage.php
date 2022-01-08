<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;
use AssertTrait;

class OpportunityDetailPage extends Page
{
    private $opportunityId = 0;
    use AssertTrait;


    protected $elements = array(
        "Title" => array('css' => 'span.title-with-status'),
        "Select_Opportunity_Status" => array('xpath' => '//select[@name="status"]'),
        "Select_Fail_Reason" => array('xpath' => '(//select[@name="status"])[2]'),

        "SendSMS" => array('xpath' =>   '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[1]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]'),
        "SendMail" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[1]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[2]'),
        "AddANote" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[1]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[3]'),
        "TelephoneModalToSms" => array('xpath' => '//*/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/form[1]/div[1]/div[1]/div[1]/div[1]/select[1]/option[1]'),
        "NavbarActivities" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/nav[1]/ul[1]/li[6]/a[1]'),
        "OpenAccordionActivities" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[6]/div[3]/span[1]/div[1]/div[1]/div[1]/div[1]/a[1]'),
        "TelephoneSectionActivities" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[6]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[2]/div[1]/div[2]'),
        "SmsMessageSectionActivities" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[6]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[2]/div[1]/div[3]'),
        "NumberOfCharacter" => array('xpath' => '//*/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/form[1]/div[3]/div[1]/div[2]'),
        "TextArea" => array('xpath' => '//*/div[3]/div[3]/div[2]/div[2]/div[1]/div[1]/div[1]/div[1]/textarea[1]'),
        "EmailSendModalTo" => array('xpath' => '//*/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/form[1]/div[1]/div[1]/div[1]/div[1]/select[1]/option[1]'),
        "EmailSubjectSectionActivities" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[6]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[2]/div[1]/div[1]'),
        "EmailSectionActivities" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[6]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[2]/div[1]/div[2]'),
        "EmailMessageSectionActivities" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[6]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[2]/div[1]/div[3]'),
        "NoteDescriptionSectionActivities" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[6]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[2]/div[1]/div[3]'),
        "AddCall" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[1]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[5]'),
        "AddCallTimeActivities" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[6]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[1]/div[2]'),
        "CallMessageActivities" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[6]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[2]/div[1]/div[3]'),
        "AddAnOfferButton" => array('xpath' => '//*[@id="section-offers"]/div[1]/div[2]/button'),
        'firstRowModalSearchContact' => array('xpath' => '//*/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/div[1]/div[2]/div[1]/div[6]/div[1]/table[1]/tbody[1]/tr[1]'),
        'FirstVehicleCheck' => array('xpath' => '//*/div[1]/div[1]/div/div[2]/form/div/div[2]/form/div[2]/div/div[2]/div/div[2]/div/div[6]/div/table/tbody/tr[1]/td[1]'),
        'CloseOpportunity' => array('xpath' => '//*[contains(text(),"Chiudi opportunità")]'),
        'CloseStatus' => array('xpath' => '//*/select'),
        'ContractDateInput' => array('xpath' => '//input[@name="contractDate"]'),
         'CalendarArrowDatePrev' => array('css' => 'span.datepicker__arrow.datepicker__arrow--prev.prev'),
       'Day18Calendar' => array('xpath' => '//span[contains(text(),"18")]'),
       );

    protected $path = '/opportunity/opportunity-detail/{opportunityId}';


    public function iFillFormWith(TableNode $table)
    {

        foreach ($table->getRows() as $row) {
            list($label, $value) = $row;
            # working with select
            $this->getElement($label)->selectOption($value);
            $this->getPage(OpportunityDetailPage::class)->getSession()->wait(1000);

        }
    }


    public function sendSMS($message)
    {
        $this->pressButton("Altre azioni");
        $this->getElement('SendSMS')->press();
        $this->fillField("message", $message);
        $this->pressButton("Invia");
        $this->getPage(OpportunityDetailPage::class)->getSession()->wait(1000);


    }

    public function sendMail($template)
    {
        $this->pressButton("Altre azioni");
        $this->getSession()->wait(1000);
        $this->getElement('SendMail')->press();
        $this->getSession()->wait(1000);
        # $this->getSession()->wait( 1000);
        $this->selectFieldOption("template", $template);
        $this->getSession()->wait(1000);
        $this->pressButton("Invia");
        $this->getSession()->wait(1000);


    }


    public function addANote($message)
    {
        $this->pressButton("Altre azioni");
        $this->getElement('AddANote')->press();
        $this->fillField("description", $message);
        $this->pressButton("Invia");
        $this->getPage(OpportunityDetailPage::class)->getSession()->wait(1000);


    }

    public function addACall()
    {

        $this->fillField("notes", "do re mi");
        $this->pressButton("Invia");
        $this->getSession()->wait(1000);


    }

    public function SendASmsWithMessageFromOpportunityDetail($arg1, $numberOfCharacterBefore = 'Caratteri: 160/0', $numberOfCharacterAfter = 'Caratteri: 146/1')
    {
        $this->getSession()->wait(1000);
        $this->pressButton("Altre azioni");
        $this->getElement('SendSMS')->click();
        $this->getSession()->wait(1000);
        $numberOfCharacter = $this->getElement('NumberOfCharacter')->getText();
        var_dump($numberOfCharacter);
        self::assertTrue($numberOfCharacter == $numberOfCharacterBefore);
        $this->fillField("message", $arg1);
        $numberOfCharacter = $this->getElement('NumberOfCharacter')->getText();
        var_dump($numberOfCharacter);
        self::assertTrue($numberOfCharacter == $numberOfCharacterAfter);
        $this->pressButton("Invia");
        $this->getSession()->wait(1000);
    }

    public function CheckSmsInOpportunitiesActivitiesWithMessage($arg1)
    {
        $this->pressButton("Altre azioni");
        $this->getElement('SendSMS')->click();
        $telephoneModalToSms = $this->getElement('TelephoneModalToSms')->getText();
        $telephoneModalToSms = trim($telephoneModalToSms);
        var_dump($telephoneModalToSms);
        $this->pressButton("Annulla");
        $this->getSession()->wait(1000);
        $this->getElement("NavbarActivities")->click();
        $this->getSession()->wait(1000);
        $this->getElement("OpenAccordionActivities")->click();
        $this->getSession()->wait(1000);
        $telephoneSectionActivities = $this->getElement('TelephoneSectionActivities')->getText();
        var_dump($telephoneSectionActivities);
        $smsMessageSectionActivities = $this->getElement('SmsMessageSectionActivities')->getText();
        var_dump($smsMessageSectionActivities);
        self::assertTrue('Telefono: ' . $telephoneModalToSms == $telephoneSectionActivities);
        self::assertTrue($smsMessageSectionActivities == $arg1);
    }

    public function SendAnEmailInOpportunitiesActivitiesWithMessage($arg1)
    {
        $this->getSession()->wait(1000);
        $this->pressButton("Altre azioni");
        $this->getElement('SendMail')->click();
        $this->getSession()->wait(2000);
        $this->fillField("subject", $arg1);
        $this->pressButton("Source code");
        $this->getSession()->wait(1000);
        $this->getElement("TextArea")->setValue($arg1);
        $this->pressButton("Save");
        $this->pressButton("Invia");
        $this->getSession()->wait(1000);
    }

    public function CheckEmailInOpportunitiesActivitiesWithMessage($arg1)
    {
        $this->pressButton("Altre azioni");
        $this->getElement('SendMail')->click();
        $emailSendModalTo = $this->getElement('EmailSendModalTo')->getText();
        $emailSendModalTo = trim($emailSendModalTo);
        var_dump($emailSendModalTo);
        $this->pressButton("Annulla");
        $this->getSession()->wait(1000);
        $this->getElement("NavbarActivities")->click();
        $this->getSession()->wait(1000);
        $this->getElement("OpenAccordionActivities")->click();
        $this->getSession()->wait(1000);
        $emailSubjectSectionActivities = $this->getElement('EmailSubjectSectionActivities')->getText();
        var_dump($emailSubjectSectionActivities);
        $emailSectionActivities = $this->getElement('EmailSectionActivities')->getText();
        var_dump($emailSectionActivities);
        $emailMessageSectionActivities = $this->getElement('EmailMessageSectionActivities')->getText();
        var_dump($emailMessageSectionActivities);
        self::assertTrue('A: ' . $emailSendModalTo == $emailSectionActivities);
        self::assertTrue($emailSubjectSectionActivities == $arg1);
        self::assertTrue($emailMessageSectionActivities == $arg1);

    }

    public function CheckNoteInOpportunitiesActivitiesWithDescription($arg1)
    {
        $this->getElement("NavbarActivities")->click();
        $this->getSession()->wait(1000);
        $this->getElement("OpenAccordionActivities")->click();
        $this->getSession()->wait(1000);
        $noteDescriptionSectionActivities = $this->getElement('NoteDescriptionSectionActivities')->getText();
        var_dump($noteDescriptionSectionActivities);
        self::assertTrue($noteDescriptionSectionActivities == $arg1);
    }

    public function CheckCallInOpportunitiesActivitiesWithNote($arg1)
    {
        $this->getElement("NavbarActivities")->click();
        $this->getSession()->wait(1000);
        $this->getElement("OpenAccordionActivities")->click();
        $this->getSession()->wait(1000);
        $noteDescriptionSectionActivities = $this->getElement('NoteDescriptionSectionActivities')->getText();
        var_dump($noteDescriptionSectionActivities);
        self::assertTrue($noteDescriptionSectionActivities == $arg1);
    }


    public function AddAOutgoingCallWithNoteFromOpportunityDetail($arg1, $arg2)
    {
        $this->pressButton("Altre azioni");
        $this->getElement('AddCall')->click();
        $this->getSession()->wait(1000);
        $this->selectFieldOption("subject", "$arg1");
        $this->fillField("notes", $arg2);
        $this->pressButton("Invia");
    }


    public function AddAnOffer($search)
    {
        $this->getElement("AddAnOfferButton")->click();
        $this->getPage(OpportunityDetailPage::class)->getSession()->wait(5000);
        $this->fillField("fullText", $search);
        $this->getPage(OpportunityDetailPage::class)->getSession()->wait(5000);

        $this->getElement("FirstVehicleCheck")->click();
        //  $this->getPage(AddLeadPage::class)->getSession()->wait(3000);
        $this->pressButton("Avanti");
        $this->pressButton("Avanti");
        $this->pressButton("Salva ed esci");
        $this->getPage(OpportunityDetailPage::class)->getSession()->wait(1000);


    }


    public function SellOpportunity()
    {
        $this->getElement("CloseOpportunity")->click();
        $this->getElement("CloseStatus")->setValue("won");
        $this->getElement("ContractDateInput")->click();

        $this->getElement("CalendarArrowDatePrev")->click();

        $this->getElement("Day18Calendar")->click();

        $this->pressButton("Salva");
        $this->getPage(OpportunityDetailPage::class)->getSession()->wait(1000);


    }


    public function waitForNext()
    {
        $line = readline("Command      login: ");
        if ($line == 'exit') exit();
        if ($line == 'die') die();
        if ($line == 'e') exit();
    }
}
