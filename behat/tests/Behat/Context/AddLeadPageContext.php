<?php

use Behat\Mink\Driver\DriverInterface;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Page\ContactsPage;
use Page\TasksPage;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\AddLeadPage;
use Page\Element\Table;
use  Oro\Bundle\DataGridBundle\Tests\Behat\Context\GridContext;
use Behat\Mink\Element\Element;
use Behat\Mink\Driver;

class AddLeadPageContext extends PageObjectContext
{
    /**
     * Driver.
     *
     * @var DriverInterface
     */
    private $driver;

    private $xpath;


    use AssertTrait;


    private $addLeadPage;


    public function __construct(AddLeadPage $addLeadPage)
    {
        $this->addLeadPage = $addLeadPage;
        $this->sleepFactor = 2;
    }

    /**
     * @Given /^(?:|I )visited add leads page/
     */
    public function iVisitedThePage()
    {
        $this->addLeadPage->getPage(AddLeadPage::class)->open();
    }




    /**
     * @Given I create a sale ":arg1" request
     */
    public function iCreateSaleRequest($make)
    {

   #     $this->addLeadPage->addLeadRequestStep1("Sale");

        $this->addLeadPage->addLeadStockStep2("types__used_Check", $make);
        $this->addLeadPage->addLeadNotesStep3("do re mi fa");

    }

    /**
     * @Then I validate lead sales form step3
     */
    public function iValidateSaleRequestStep3()
    {

        #     $this->addLeadPage->addLeadRequestStep1("Sale");
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000 * $this->sleepFactor);
        $this->addLeadPage->addLeadStockStep2("types__km0_Check", "Fiat");
        $this->addLeadPage->validateStep3("Seleziona", "Seleziona");
        $this->addLeadPage->validateStep3("Seleziona", "Web");
        $this->addLeadPage->validateStep3("Seleziona", "Terze parti");
        $this->addLeadPage->validateStep3("Seleziona", "Altro");
        $this->addLeadPage->validateStep3("Seleziona", "Marketing");
        $this->addLeadPage->validateStep3("Telefonata", "Seleziona");
        $this->addLeadPage->validateStep3("Visita", "Seleziona");
        $this->addLeadPage->validateStep3("Importazione manuale", "Seleziona");
        $this->addLeadPage->validateStep3("E-mail", "Seleziona");
        $this->addLeadPage->validateStep3("Altro", "Seleziona");
        $this->addLeadPage->validateStep3("WhatsApp", "Seleziona");

    }

    /**
     * @Then /^I create a private contact$/
     * @param string $name
     * @throws ElementNotFoundException
     */
      public function iCreateAPrivateContact()
      {
          $this->addLeadPage->CreateAPrivateContact();
       }

    /**
     * @Given /^I create a stock sale request$/
     */
    public function iCreateAStockSaleRequest()
    {
        $this->addLeadPage->CreateAStockSaleRequest();
    }

    /**
     * @Then /^I create a new sale request$/
     */
    public function iCreateANewSaleRequest()
    {
       $this->addLeadPage->CreateANewSaleRequest();
    }

    /**
     * @Then /^I create a company contact$/
     */
    public function iCreateACompanyContact()
    {
        $this->addLeadPage->CreateACompanyContact();
    }

    /**
     * @When I Add private contact by searching fullText :arg1
     */
    public function iAddPrivateContactBySearchingFullText($arg1)
    {
        $this->addLeadPage->pressButton('Cerca contatto');
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000);
        $this->addLeadPage->fillField('fullText',$arg1);
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000);
        $this->addLeadPage->getElement("firstRowModalSearchContact")->click();
        $this->addLeadPage->pressButton('Conferma');
        $this->getPage(AddLeadPage::class)->getSession()->wait(1000);
    }

}
