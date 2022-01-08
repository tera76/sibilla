<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Symfony2Extension\Context\KernelAwareContext;
#use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;
use Behat\MinkExtension\Context\MinkContext;
use Page\ContactDetailPage;
use Page\OpportunityDetailPage;
use Page\LoginPage;
use Page\TasksPage;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\LeadQualificationPage;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Element\Element;

class LeadQualificationContext extends PageObjectContext # implements SnippetAcceptingContext
{
    use AssertTrait;


    private $leadQualification;
    private $params;
    public $sleepFactor;


    public function __construct(LeadQualificationPage $leadQualification, array $parameters)
    {
        $this->leadQualification = $leadQualification;
        $this->params=  !empty($parameters) ? $parameters : array();
        $this->sleepFactor=2;
    }







    /**
     * @Given /^(?:|I )visited leadsQualification page/
     */
    public function iVisitedThePage()
    {
        $this->getPage(LeadQualificationPage::class)->open();
    }




    /**
     * @Then LeadQualification title should be :arg1
     */
    public function leadQualificationTitleShouldBe($arg1)
    {

        self::assertEquals( $arg1, $this->leadQualification->getElement('Title')->getText());

    }


    /**
     *
     * @Given I open lead qualification for name :arg1 and status :arg2
     * @Given I open lead qualification for name :arg1
     */
    public function iOpenQualificationByName($arg1,$arg2='')
    {

        $util= new \Base\ApiFeaturesContext($this->params);
        $idLead = $util->getLeadIdByLeadName($arg1,$arg2);
        $id = $util->getTaskIdByLeadId($idLead);

        $this->getPage(LeadQualificationPage::class)->open(array('leadId' => $id));
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000 * $this->sleepFactor);


    }

    /**
     *
     * @Given I open lead qualification for name :arg1 and task status :arg2
     */
    public function iOpenQualificationByNameAndTaskStatus($arg1,$arg2='')
    {

        $util= new \Base\ApiFeaturesContext($this->params);
        $idLead = $util->getLeadIdByLeadNameAndStatusTask($arg1,$arg2);
        $id = $util->getTaskIdByLeadId($idLead);
        var_dump($id);
        $this->getPage(LeadQualificationPage::class)->open(array('leadId' => $id));
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000 * $this->sleepFactor);


    }

    /**
     * @Given I open lead qualification for lead statusId :arg1
     */
    public function iOpenQualificationForStatusId($arg1)
    {

        $util= new \Base\ApiFeaturesContext($this->params);
        $idLead = $util->getLeadIdByLeadStatus($arg1);
        var_dump("idLead: " . $idLead);
         $id = $util->getTaskIdByLeadId($idLead);
       var_dump("idTask: " . $id );

        $this->getPage(LeadQualificationPage::class)->open(array('leadId' => $id));
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000 * $this->sleepFactor);

        $GLOBALS['currentLeadId'] = $id;

    }


    /**
     * @When I insert activity ":arg1"
     */
    public function insertActivity($arg1)
    {
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $this->leadQualification->insertActivity($arg1);

    }



    /**
     * @Given I Add existing Contact for name :arg1 in lead qualification page
     */
    public function iAddExistingContactByName($arg1)
    {

        $form = $this->leadQualification->iSearchAndAddContact($arg1);

    }


    /**
     * @Given I set payment method :arg1 in LQ page
     */
    public function iSetPaymentMethod($arg1)
    {
          $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
          $this->leadQualification->getElement("PaymentMethod")->setValue($arg1);

    }

    /**
     * @Given I set date task in LQ page
     */
    public function iSetDateTask()
    {
  #      $this->leadQualification->getElement("postponeByDate")->click();
   #     $this->leadQualification->getSession()->getDriver()->executeScript("document.querySelectorAll('input.input-field')[9].removeAttribute('readonly');");

   #     $this->leadQualification->getElement("dateTask")->setValue( "30/03/2029");
        $this->leadQualification->iSetDate();
        $this->leadQualification->getElement("timeTask")->setValue("11:11 1");


    }

    /**
     * @Given I set a calendar task in LQ page
     */
    public function iSetCalendarTask()
    {

        $this->leadQualification->iSetATaskCalendar();


        #      $this->leadQualification->getElement("postponeByDate")->click();
        #     $this->leadQualification->getSession()->getDriver()->executeScript("document.querySelectorAll('input.input-field')[9].removeAttribute('readonly');");

        #     $this->leadQualification->getElement("dateTask")->setValue( "30/03/2029");
        #  #    $this->leadQualification->iSetDate();
        #  #  $this->leadQualification->getElement("timeTask")->setValue("11:11 1");


    }



    /**
    * @Given /^(?:|I )fill Owned Vehicle form in LQ page with:$/
    */
    public function iFillOwnedVehicleFormInLQPage(TableNode $table)
    {
        $this->leadQualification->iFillOwnedVehicle($table);

    }


    /**
     * @Then /^I set status Not valid$/
     */
    public function iSetStatusNotValid()
    {
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(3000);

        try{
            $Ok = $this->leadQualification->getElement('Ok');
            $Ok->click();
        }catch (Exception $elementNotFound){
            echo $elementNotFound;
        }

        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $this->leadQualification->pressButton('Non valido');
        //$this->leadQualification->getElement("Not valid")->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $this->leadQualification->pressButton('Conferma');
        //$this->leadQualification->getElement("Confirm")->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(2000);
    }

    /**
     * @Then /^I should see lead contact and lead request sections$/
     */
    public function iShouldSeeLeadContactAndLeadRequestSections()
    {
        $this->leadQualification->ShouldSeeLeadContactAndLeadRequestSections();
    }

    /**
     * @Then /^I should see lead request and lead additional info sections$/
     */
    public function iShouldSeeLeadRequestAndLeadAdditionalInfoSections()
    {
        $this->leadQualification->ShouldSeeLeadRequestAndLeadAdditionalInfoSections();

    }

    /**
     * @Then /^I should see lead additional info section$/
     */
    public function iShouldSeeLeadAdditionalInfoSection()
    {
      $this->leadQualification->ShouldSeeLeadAdditionalInfoSection();
    }

    /**
     * @Then /^I should see lead trade\-in and lead planning sections$/
     */
    public function iShouldSeeLeadTradeInAndLeadPlanningSections()
    {
        $this->leadQualification->ShouldSeeLeadTradeInAndLeadPlanningSections();

    }

    /**
     * @Then /^I send a sms with message "([^"]*)" from lead\-qualification$/
     */
    public function iSendASmsWithMessageFromLeadQualification($arg1,$numberOfCharacterBefore = 'Caratteri: 160/0',$numberOfCharacterAfter = 'Caratteri: 146/1')
    {{
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        try{
            $Ok = $this->leadQualification->getElement('Ok');
            $Ok->click();
        }catch (Exception $elementNotFound){
            echo $elementNotFound;
        }
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $this->leadQualification->pressButton("Altre azioni");
        $this->leadQualification->getElement('SendSMS')->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $numberOfCharacter=$this->leadQualification->getElement('NumberOfCharacter')->getText();
        self::assertTrue($numberOfCharacter == $numberOfCharacterBefore);
        $this->leadQualification->fillField("message",$arg1);
        $numberOfCharacter=$this->leadQualification->getElement('NumberOfCharacter')->getText();
        self::assertTrue($numberOfCharacter == $numberOfCharacterAfter);
        $this->leadQualification->pressButton("Invia");
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(2000);
    }}


    /**
     * @Then /^I check sms send time$/
     */
    public function iCheckSmsSendTime()
    {
        $smsSendTime = date("d/m/Y, H:i");
        $this->leadQualification->getElement("SidebarTasks")->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $smsSendTimeSidebarTaskBefore=$this->leadQualification->getElement('SmsSendTimeSidebarTask')->getText();
        var_dump($smsSendTimeSidebarTaskBefore);
        self::assertTrue($smsSendTimeSidebarTaskBefore == 'INVIATO SMS ' . $smsSendTime);
        $this->leadQualification->getSession()->reload();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(3000);
        $this->leadQualification->getElement("SidebarTasks")->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $smsSendTimeSidebarTaskAfter=$this->leadQualification->getElement('SmsSendTimeSidebarTask')->getText();
        var_dump($smsSendTimeSidebarTaskAfter);
        self::assertTrue($smsSendTimeSidebarTaskAfter == $smsSendTimeSidebarTaskBefore);
    }


    /**
     * @Then /^I send a email with message "([^"]*)" from lead\-qualification$/
     */
    public function iSendAEmailWithMessageFromLeadQualification($arg1)
    {
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        try{
            $Ok = $this->leadQualification->getElement('Ok');
            $Ok->click();
        }catch (Exception $elementNotFound){
            echo $elementNotFound;
        }
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $this->leadQualification->pressButton("Altre azioni");
        $this->leadQualification->getElement('SendEmail')->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(3000);
        $this->leadQualification->fillField("subject",$arg1);
        $this->leadQualification->pressButton("Source code");
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $this->leadQualification->getElement("TextArea")->setValue($arg1);
        $this->leadQualification->pressButton("Save");
        $this->leadQualification->pressButton("Invia");
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
    }

    /**
     * @Then /^I check email send time$/
     */
    public function iCheckEmailSendTime()
    {
        $emailSendTime = date("d/m/Y, H:i");
        $this->leadQualification->getElement("SidebarTasks")->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $emailSendTimeSidebarTaskBefore=$this->leadQualification->getElement('EmailSendTimeSidebarTask')->getText();
        var_dump($emailSendTimeSidebarTaskBefore);
        self::assertTrue($emailSendTimeSidebarTaskBefore == 'INVIATA E-MAIL ' . $emailSendTime);
        $this->leadQualification->getSession()->reload();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(3000);
        $this->leadQualification->getElement("SidebarTasks")->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $emailSendTimeSidebarTaskAfter=$this->leadQualification->getElement('EmailSendTimeSidebarTask')->getText();
        var_dump($emailSendTimeSidebarTaskAfter);
        self::assertTrue($emailSendTimeSidebarTaskAfter == $emailSendTimeSidebarTaskBefore);
    }

    /**
     * @Then /^I add an outgoing call from lead\-qualification$/
     */
    public function iAddAnOutgoingCallFromLeadQualification()
    {
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        try{
            $Ok = $this->leadQualification->getElement('Ok');
            $Ok->click();
        }catch (Exception $elementNotFound){
            echo $elementNotFound;
        }
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $this->leadQualification->pressButton("Altre azioni");
        $this->leadQualification->getElement('AddCall')->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(3000);
        $this->leadQualification->pressButton("Invia");
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
    }

    /**
     * @Then /^I check call add time$/
     */
    public function iCheckCallAddTime()
    {
        $callAddTime = date("d/m/Y, H:i");
        var_dump($callAddTime);
        $this->leadQualification->getElement("SidebarTasks")->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $callAddTimeSidebarTaskBefore=$this->leadQualification->getElement('AddCallTimeSidebarTask')->getText();
        var_dump($callAddTimeSidebarTaskBefore);
        self::assertTrue($callAddTimeSidebarTaskBefore == 'LOG CHIAMATA ' . $callAddTime);
        $this->leadQualification->getSession()->reload();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(3000);
        $this->leadQualification->getElement("SidebarTasks")->click();
        $this->getPage(LeadQualificationPage::class)->getSession()->wait(1000);
        $callAddTimeSidebarTaskAfter=$this->leadQualification->getElement('AddCallTimeSidebarTask')->getText();
        var_dump($callAddTimeSidebarTaskAfter);
        self::assertTrue($callAddTimeSidebarTaskAfter == $callAddTimeSidebarTaskBefore);
    }
}
