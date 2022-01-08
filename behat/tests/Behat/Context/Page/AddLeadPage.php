<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ResponseTextException;
use Page\Element\Table;
use PHPUnit\Framework\Assert as Assert;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;
use AssertTrait;


class AddLeadPage extends Page
{


    protected $elements = array(
        'Sale' => array('xpath' => '//*/div[1]/div[1]/div/div[2]/form/div/div[2]/form/div[2]/div/div[1]/div'),
        'AfterSale' => array('xpath' => '//*/div[1]/div[1]/div/div[2]/form/div/div[2]/form/div[2]/div/div[2]/div'),
        'FirstVehicleCheck' => array('xpath' => '//*/div[1]/div[1]/div/div[2]/form/div/div[2]/form/div[2]/div/div[2]/div/div[2]/div/div[6]/div/table/tbody/tr[1]/td[1]'),
        'types__km0_Check' => array('xpath' => '//*/input[@name="type__km0"]'),
        'types__new_Check' => array('xpath' => '//*/input[@name="type__new"]'),
        'types__used_Check' => array('xpath' => '//*/input[@name="type__used"]'),
        'AddContact' => array('xpath' => '//*/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/div[1]/div[2]/div[1]/div[2]/div[2]/div[1]/div[2]/button[1]'),
        'SaveContact' => array('xpath' => '//*/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[3]/div[1]/div[2]/button[1]'),
        'Create new' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[2]/div[2]/div[2]/button[1]'),
        'First row' => array('xpath' => '//*/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/form[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/div[6]/div[1]/table[1]/tbody[1]/tr[1]'),
        'Next' => array('xpath' => '//*/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/form[1]/div[3]/div[1]/div[2]/button[1]'),
        'SaveRequest' => array('xpath' => '//*/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/form[1]/div[3]/div[1]/div[3]/button[1]'),
        'Account Type' => array('xpath' => '//*/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/form[1]/div[1]/div[1]/div[1]/div[1]/div[1]/div[1]/div[1]/input[1]'),
        'Add New' => array('xpath' => '//*/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/form[1]/div[2]/div[1]/div[1]/div[2]/div[1]/div[2]/button[1]'),
        'fullTextModalSearchContact' => array('xpath' => '//*/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/div[1]/div[1]/div[1]/div[1]/div[1]/input[1]'),
        'firstRowModalSearchContact' => array('xpath' => '//*/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/div[1]/div[2]/div[1]/div[6]/div[1]/table[1]/tbody[1]/tr[1]'),
        'confirmModalSearchContact' => array('xpath' => '//*/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[3]/div[1]/div[3]/button[1]'),
        'Skip' => array('xpath' => '//*/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/form[1]/div[3]/div[1]/div[1]/div[1]/button[1]'),
        'Qualify' => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[1]/form[1]/div[1]/div[2]/div[1]/div[2]/div[1]/div[3]/button[1]'),
        'ModalNewContactTitle' => array('xpath' => '//*/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[1]/div[1]/div[1]'),



    );

    protected $path = '/leads-add';
    public $sleepFactor = 2;

    public function addLeadRequestStep1($type)
    {
        $this->getElement($type)->click();
        $this->getElement($type)->click();
        $this->pressButton("Avanti");
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000);

    }


    public function addLeadStockStep2($type, $search)
    {
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000 * $this->sleepFactor);
        $this->fillField("fullText",$search);
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000 * $this->sleepFactor );
        $this->getElement("FirstVehicleCheck")->click();
        $this->pressButton("Avanti");



    }

    public function CreateAPrivateContact($name = 'GregTest', $lastname = 'QA', $email = 'gregtestqa@ew1.eu')
    {
        //$this->addLeadPage->getElement("AddContact")->click();
        //$this->hasUncheckedField('privacy-data_processing');
        $this->pressButton('Aggiungi contatto');
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000);
        $this->fillField('firstName',$name);
        $this->fillField('lastName',$lastname);
        $this->fillField('emailPrimary',$email);
        $this->selectFieldOption("country","Italia");
        $this->pressButton('Salva');
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000 * $this->sleepFactor );
        $this->pageTextMustContains('Nuovo contatto');
        $this->selectFieldOption("privacy-data_processing","accepted");
        $this->selectFieldOption("privacy-profiling","accepted");
        $this->selectFieldOption("privacy-third_party_assignment","accepted");
        $this->pressButton('Salva');
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000 * $this->sleepFactor);
    }

    /**
     * Checks that current page must contains text.
     *
     * @param string $text
     *
     */
    public function pageTextMustContains($text)
    {
        $actualText = $this->getElement('ModalNewContactTitle')->getText();
        self::assertTrue($actualText == $text, 'Actual text: ' . $actualText . " - Expected =  ". $text);
    }

    /**
     * Asserts that a condition is true.
     *
     * @param bool   $condition
     * @param string $message
     */
    public static function assertTrue($condition, $message = '')
    {
        Assert::assertTrue($condition, $message);
    }


    public function CreateAStockSaleRequest()
    {
        //$this->getElement("Create new")->click();
        $this->pressButton('Crea nuovo');
        $this->getPage(AddLeadPage::class)->getSession()->wait(4000);
        $this->getElement("First row")->click();
        $this->getElement("Next")->click();
        $this->selectFieldOption("channel","E-mail");
        $this->selectFieldOption("origin","Web");
        $this->getElement("SaveRequest")->click();
        $this->getPage(AddLeadPage::class)->getSession()->wait(2000);
    }

    public function CreateANewSaleRequest($model = '595')
    {
        $this->getElement("Create new")->click();
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000);
        $this->getElement("Skip")->click();
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000);
        $this->selectFieldOption("type","new");
        $this->selectFieldOption("make","Abarth");
        $this->fillField('model',$model);
        $this->selectFieldOption("channel","E-mail");
        $this->selectFieldOption("origin","Web");
        $this->getElement("SaveRequest")->click();
        $this->getPage(AddLeadPage::class)->getSession()->wait(2000);
    }

    public function CreateACompanyContact($companyName = 'GregCompanyTest', $name = 'GregTest', $lastname = 'Test', $email = 'gregcompanytest@ew1.eu')
    {
        //$this->addLeadPage->getElement("Add contact")->click();
        $this->pressButton('Aggiungi contatto');
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000);
        $this->getElement("Account Type")->click();
        $this->getElement("Add New")->click();
        $this->fillField('companyName',$companyName);
        $this->fillField('firstName',$name);
        $this->fillField('lastName',$lastname);
        $this->fillField('emailPrimary',$email);
        $this->selectFieldOption("country","Italia");
        $this->pressButton('Salva');
        $this->getPage(AddLeadPage::class)->getSession()->wait(2000);
        $this->pageTextMustContains('Nuovo contatto');
        $this->selectFieldOption("privacy-data_processing","accepted");
        $this->selectFieldOption("privacy-profiling","accepted");
        $this->selectFieldOption("privacy-third_party_assignment","accepted");
        $this->pressButton('Salva');
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000);
    }

    public function waitForNext()
    {
        $line = readline("Command: ");
        if ($line == 'exit') exit();
        if ($line == 'die') die();
        if ($line == 'e') exit();
    }

    public function addLeadNotesStep3($notes)
    {

        $this->getPage(AddLeadPage::class)->getSession()->wait(1000  * $this->sleepFactor);
        $this->selectFieldOption("channel","Altro");
        $this->selectFieldOption("origin","Web");
        $this->fillField("notes", "$notes");
        $this->pressButton("Salva");
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000);


    }



    public function validateStep3($channel,$origin)
    {


        $this->selectFieldOption("channel",$channel);
        $this->selectFieldOption("origin",$origin);
        $this->pressButton("Salva");
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000);


    }

    public function searchForFullText($name)
    {
        $this->getElement('fullTextSearch')->setValue($name);

    }

}
