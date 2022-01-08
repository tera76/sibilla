<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use Exception;
use Page\Element\Table;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;




class LeadDetailPage extends Page
{
    private $leadId =0;






    protected $elements = array(
        'Title' => array('css' => 'span.title-with-status'),
        "Modifica" => array('xpath' => '//*[@id="app-wrapper__page"]/div/div/div/div[1]/div[2]/div/div[2]/div/div[1]/button'),
        "QualificaVeloce" => array('xpath' => '//*[@id="app-wrapper__page"]/div/div/div/div[2]/div/div[3]/button'),
        "paymentOption" => array('xpath' => '//*[@name="paymentOption"]'),
        "make" => array('xpath' => '//*/select[@name="make"]'),
        "model" => array('xpath' => '//*[@name="model"]'),
        "km" => array('xpath' => '//*[@name="km"]'),
        "plate" => array('xpath' => '//*[@name="plate"]'),
        'section-contact' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[1]/div[1]'),
        'section-request' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[1]/div[2]'),
        'section-additionalInformation' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[1]/div[3]'),
        'section-tradeIn' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[1]/div[4]'),
        'section-tasks' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]'),
        'Telephone1SectionContact' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/div[3]/div[7]/div[1]/div[2]'),
        'Telephone1SectionTasks' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[3]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[2]/div[1]/div[2]'),
        'NavbarTasks' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/nav[1]/ul[1]/li[5]'),
        'OpenAccordionTasks' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[3]/div[3]/span[1]/div[1]/div[1]/div[1]/div[1]/a[1]'),
        'SmsMessageSectionTasks' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[3]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[2]/div[1]/div[3]'),
        'Email1SectionContact' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/div[3]/div[5]/div[1]/div[2]'),
        'Email1SectionTasks' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[3]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[2]/div[1]/div[2]'),
        'EmailMessageSectionTasks' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[3]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[2]/div[1]/div[3]'),
        'NoteSectionTasks' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[3]/div[3]/span[1]/div[1]/div[1]/div[1]/div[3]/div[2]/div[1]/div[3]'),
        'AddACall' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[2]/div[1]/div[2]/div[1]/div[1]/div[1]/div[2]/div[4]'),



    );

    protected $path = '/leads-detail/{leadId}';


   // public function iFillContactFormWith(TableNode $table)
    //  {
    //
    //       foreach ($table->getRows() as $row) {
    //          list($label, $value) = $row;
    //           $this->getElement($label)->setValue($value);
    //
    //       }
    //   }

    public function iFillEditFormWith(TableNode $table)
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

    public function addAnOutgoingCall()
    {

        $this->pressButton("Altre azioni");
        $this->getElement('AddACall')->click();
        $this->pressButton("Invia");
        $this->getPage(LeadDetailPage::class)->getSession()->wait(1000);

    }

    public function ShouldSeeContactAndRequestSections()
    {
        $this->findById("section-contact");
        $this->findById("section-request");
        $this->getPage(LeadDetailPage::class)->getSession()->wait(1000);
    }

    public function ShouldSeeRequestAndAdditionalInformationSections()
    {
        $this->findById("section-request");
        $this->findById("section-additionalInformation");
        $this->getPage(LeadDetailPage::class)->getSession()->wait(1000);
    }

    public function ShouldSeeAdditionalInformationAndTradeInSections()
    {
        $this->findById("section-additionalInformation");
        $this->findById("section-tradeIn");
        $this->getPage(LeadDetailPage::class)->getSession()->wait(1000);

    }

    public function ShouldSeeTradeInAndTasksSections()
    {
        $this->findById("section-tradeIn");
        $this->findById("section-tasks");
        $this->getPage(LeadDetailPage::class)->getSession()->wait(1000);

    }



}
