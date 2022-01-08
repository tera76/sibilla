<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;


class LeadQualificationPage extends Page
{
    private $leadId = 0;

    private $leadsPage;


    protected $elements = array(
        'Title' => array('css' => 'span.title-with-status'),

        "Search_fullText" => array('xpath' => '//*/input[@name="fullText"]'),
        "Contact_FirstItem" => array('xpath' => '//*/table/tbody/tr[1]/td[1]/div/div/div/div/div'),


        "PaymentMethod" => array('xpath' => '//*[@id="section-lead-additional-info"]/div[2]/div[8]/div/div/div/select'),
        "postponeByDate" => array('xpath' => '//*[@id="postponeByDate"]'),
        "dateTask" => array('xpath' => '//*[@id="section-lead-planning"]/div[2]/div/div/div[2]/div/div/div/div[1]/div/div/div[1]/div[2]/label/div/div[2]/div/div[1]/div/div/div/div[1]/input'),
        "arrowNext" => array('xpath' => '//*[@id="section-lead-planning"]/div[2]/div/div/div[2]/div/div/div/div[1]/div/div/div[1]/div[2]/label/div/div[2]/div/div[1]/div/div/div/div[1]/div[1]/header/span[3]'),
        "dayCell" => array('xpath' => '//*[@id="section-lead-planning"]/div[2]/div/div/div[2]/div/div/div/div[1]/div/div/div[1]/div[2]/label/div/div[2]/div/div[1]/div/div/div/div[1]/div[1]/div/div[2]/div[14]/span'),
        "timeTask" => array('xpath' => '//*[@id="section-lead-planning"]/div[2]/div/div/div[2]/div/div/div/div[1]/div/div/div[1]/div[2]/label/div/div[2]/div/div[2]/div/div/input'),
        //    "First_contact_search_flag"  => array('xpath' => '//*/div[1]/div[1]/div/div[2]/form/div/div[2]/div/div/table/tbody/tr[1]/td[1]/div/input'),
        "selectSeller" => array('xpath' => '//*[@id="section-lead-planning"]/div[2]/div/div/div[2]/div/div[1]/div/div/div[1]/div[3]/div/div/div/div/div[1]/input'),
        "CalendarNextDayArrow" => array('xpath' =>  '//button[@class=\'fc-next-button fc-button fc-button-primary\']'),
        "TabCalendarReadyToSell" => array('xpath' => '//*[@id="section-lead-planning"]/div[2]/div/div/div[1]/div[1]/label'),
        "CalendarDay" => array('xpath' => '//*[@id="section-lead-planning"]/div[2]/div/div/div[2]/div/div[1]/div/div/div[2]/div/div[2]/div/table/tbody/tr/td/div/div/div[2]/table/tbody/tr[4]/td[2]'),
        "SelectActivity" => array('xpath' => '//*/select'),
        "SaveTaskPlanningButton" =>array('xpath' => '//*/button[@name="submit"]'),
        "QualificationButton" => array('xpath' => '//*[@id="app-wrapper__page"]/div/div/div[1]/form/div[1]/div[3]/div/div[2]/div/div[2]/button'),
        "OwnedVehicle_make" => array('xpath' =>  '//*/select[@name="valueMake"]'),
        "OwnedVehicle_model" => array('xpath' =>  '//*/input[@name="valueModel"]'),
        "First row" => array('xpath' => '//*[@id="app-wrapper__page"]/div/div[2]/div/div/div[2]/div/div[6]/div/table/tbody/tr[1]'),
        "Not valid" => array('xpath' => '//*[@id="app-wrapper__page"]/div/div/div[1]/form/div[1]/div[2]/div/div[2]/div/div[2]/button'),
        "Confirm" => array('xpath' => '//*/div[1]/div[1]/div/div[2]/form/div/div[3]/div/div[2]/button'),
        "Ok" => array('xpath' => '//*/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[3]/div[1]/div[1]/button[1]'),
        "section-lead-contact" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[1]/form[1]/div[3]'),
        "section-lead-request" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[1]/form[1]/div[4]'),
        "section-lead-additional-info" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[1]/form[1]/div[5]'),
        "section-lead-trade-in" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[1]/form[1]/div[6]'),
        "section-lead-planning" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[1]/form[1]/div[7]'),
        "Telephone1SectionContact" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[1]/form[1]/div[2]/div[2]/div[1]/div[2]/div[1]/div[2]'),
        "SidebarTasks" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[2]/a[1]/*'),
        "SmsSendTimeSidebarTask" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[2]/aside[1]/div[1]/div[1]/div[2]/ul[1]/li[1]/div[1]/div[1]/div[1]/div[1]/div[2]/div[1]'),
        "SendSMS" => array('xpath' => '//*/div[contains(text(),\'Invia un SMS\')]'),
        "NumberOfCharacter" => array('xpath' => '//*/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/form[1]/div[3]/div[1]/div[2]'),
        "SendEmail" => array('xpath' => '//*/div[contains(text(),\'Invia una mail\')]'),
        "EmailSendTimeSidebarTask" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[2]/aside[1]/div[1]/div[1]/div[2]/ul[1]/li[1]/div[1]/div[1]/div[1]/div[1]/div[2]/div[1]'),
        "TextArea" => array('xpath' => '//*/div[3]/div[3]/div[2]/div[2]/div[1]/div[1]/div[1]/div[1]/textarea[1]'),
        "AddCall" => array('xpath' => '//*/div[contains(text(),\'Aggiungi una chiamata\')]'),
        "AddCallTimeSidebarTask" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[2]/aside[1]/div[1]/div[1]/div[2]/ul[1]/li[1]/div[1]/div[1]/div[1]/div[1]/div[2]/div[1]'),

    );

    protected $path = 'tasks/leads-qualification/{leadId}';




    public function iSearchAndAddContact($contact)
    {
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $this->getElement('Search_fullText')->setValue($contact);
       // $this->pressButton('Cerca');
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $this->getElement('Contact_FirstItem')->click();
        $this->pressButton('Conferma');
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);


    }


    public function iSetDate()
    {
        $this->getElement("postponeByDate")->click();

        $this->getElement("dateTask")->click();

        $this->getElement("arrowNext")->click();

        $this->getElement("dayCell")->click();

        #     $this->leadQualification->getElement("dateTask")->setValue( "30/03/2029");

    }


    public function iSetATaskCalendar()
    {
        $this->getElement("TabCalendarReadyToSell")->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $this->getElement("selectSeller")->click();
        $this->getElement("selectSeller")->setValue("L\n");

       // $this->getElement("selectSeller")->keyPress(13);
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $this->getElement("CalendarNextDayArrow")->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $this->getElement("CalendarDay")->click();
        $this->getElement("SelectActivity")->setValue("appointment");
     #   $this->waitForNext();
        #     $this->leadQualification->getElement("dateTask")->setValue( "30/03/2029");
        $this->getElement("SaveTaskPlanningButton")->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
   #      var_dump("ciccio");
     #   $this->waitForNext();
       # $this->getElement("QualificationButton")->click();
     #   $this->waitForNext();
      #  $this->pressButton("Conferma");
     #   $this->waitForNext();
    }

    public function waitForNext()
    {
        $line = readline("Command: ");
        if ($line == 'exit') exit();
        if ($line == 'die') die();
        if ($line == 'e') exit();
    }

    public function ShouldSeeLeadContactAndLeadRequestSections()
    {
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(2000);
        try{
            $Ok = $this->getElement('Ok');
            $Ok->click();
        }catch (Exception $elementNotFound){
            echo $elementNotFound;
        }

        $this->findById("section-contact");
        $this->findById("section-requests");
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
    }

    public function ShouldSeeLeadRequestAndLeadAdditionalInfoSections()
    {
        $this->findById("section-lead-request");
        $this->findById("section-lead-additional-info");
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
    }

    public function ShouldSeeLeadAdditionalInfoSection()
    {
        $this->findById("section-lead-additional-info");
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);

    }
    public function ShouldSeeLeadTradeInAndLeadPlanningSections()
    {
        $this->findById("section-lead-trade-in");
        $this->findById("section-lead-planning");
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);

    }

    public function iFillOwnedVehicle(TableNode $table)
    {

        foreach ($table->getRows() as $row) {
            list($label, $value) = $row;
            try {
                $this->getElement($label)->setValue($value);
            } catch
            (Exception $e) {
                $this->getElement($label)->selectOption($value);
            }


        }
    }

    public function insertActivity($value)
    {


            $this->getElement("SelectActivity")->setValue($value);



    }
}
