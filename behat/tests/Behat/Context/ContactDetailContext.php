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

class ContactDetailContext extends PageObjectContext # implements SnippetAcceptingContext
{
    use AssertTrait;


    private $contactDetail;
    private $params;
    private $baseUrl;

    public function __construct(ContactDetailPage $contactDetail, array $parameters)
    {
        $this->contactDetail = $contactDetail;
        $this->params=  !empty($parameters) ? $parameters : array();



    }







    /**
     * @Then Contact Detail title should be :arg1
     */
    public function contactDetailTitleShouldBe($arg1)
    {


        self::assertEquals( $arg1, $this->contactDetail->getElement('Title')->getText());

    }


    /**
     * @Given I open contact detail for company name :arg1
     */
    public function iOpenContactDetailByName($arg1)
    {
        $util= new ApiFeaturesContext($this->params);
        $id = $util->getContactIdByContactName($arg1);
        $this->getPage(ContactDetailPage::class)->open(array('contactId' => $id));
        $this->getPage(ContactDetailPage::class)->getSession()->wait(1000);
    }



    public function iWait($timeout = 1)
    {
        $this->getPage()->getSession()->wait($timeout * 1000);
    }


    public function waitForNext()
    {
        $line = readline("Command: ");
        if($line=='exit') exit();
        if($line=='die') die();
        if($line=='e') exit();
    }

    /**
     * @Then I send a SMS with message :arg1
     */
    public function iSendASMS($arg1,$numberOfCharacterBefore = 'Caratteri: 160/0',$numberOfCharacterAfter = 'Caratteri: 146/1')
    {
        $this->getPage(ContactDetailPage::class)->getSession()->wait(1000);
        $this->contactDetail->pressButton("Altre azioni");
        $this->contactDetail->getElement('SendSMS')->click();
        $this->getPage(ContactDetailPage::class)->getSession()->wait(1000);
        $numberOfCharacter=$this->contactDetail->getElement('NumberOfCharacter')->getText();
        self::assertTrue($numberOfCharacter == $numberOfCharacterBefore);
        $this->contactDetail->fillField("message",$arg1);
        $numberOfCharacter=$this->contactDetail->getElement('NumberOfCharacter')->getText();
        self::assertTrue($numberOfCharacter == $numberOfCharacterAfter);
        $this->contactDetail->pressButton("Invia");
        $this->getPage(ContactDetailPage::class)->getSession()->wait(1000);

    }


    /**
     * @Then I send an email with message :arg1
     */
    public function iSendAnEmailWithMessage($arg1)
    {
        $this->getPage(ContactDetailPage::class)->getSession()->wait(1000);
        $this->contactDetail->pressButton("Altre azioni");
        $this->contactDetail->getElement('SendEmail')->click();
        $this->getPage(ContactDetailPage::class)->getSession()->wait(3000);
        $this->contactDetail->fillField("subject",$arg1);
        $this->contactDetail->pressButton("Source code");
        $this->getPage(ContactDetailPage::class)->getSession()->wait(1000);
        $this->contactDetail->getElement("TextArea")->setValue($arg1);
        $this->contactDetail->pressButton("Save");
        $this->contactDetail->pressButton("Invia");
        $this->getPage(ContactDetailPage::class)->getSession()->wait(1000);

    }


}
