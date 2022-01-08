<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;


use Page\SmsTemplateDetailPage;
use Page\EmailTemplateDetailPage;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Element\Element;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class SmsEmailTemplateDetailContext extends PageObjectContext # implements SnippetAcceptingContext
{
    use AssertTrait;


    private $smsTemplateDetail;
    private $emailTemplateDetail;
    private $params;
    private $baseUrl;

    public function __construct(SmsTemplateDetailPage $smsTemplateDetail,EmailTemplateDetailPage $emailTemplateDetail,  array $parameters)
    {
        $this->smsTemplateDetail = $smsTemplateDetail;
        $this->emailTemplateDetail = $emailTemplateDetail;
        $this->params=  !empty($parameters) ? $parameters : array();


    }







    /**
     * @Then SmsTemplate Detail title should be :arg1
     */
    public function SmsTemplateDetailTitleShouldBe($arg1)
    {


        self::assertEquals( $arg1, $this->smsTemplateDetail->getElement('Title')->getText());

    }

    /**
     * @Then EmailTemplate Detail title should be :arg1
     */
    public function EmailTemplateDetailTitleShouldBe($arg1)
    {


        self::assertEquals( $arg1, $this->emailTemplateDetail->getElement('Title')->getText());

    }


    /**
     * @Then SmsTemplate Detail name should be :arg1
     */
    public function SmsTemplateDetailNameShouldBe($arg1)
    {


        self::assertEquals( $arg1, $this->smsTemplateDetail->getElement('Name')->getValue());

    }

    /**
     * @Then EmailTemplate Detail name should be :arg1
     */
    public function EmailTemplateDetailNameShouldBe($arg1)
    {


        self::assertEquals( $arg1, $this->emailTemplateDetail->getElement('Name')->getValue());

    }


    /**
     * @Given I open sms template detail for name :arg1
     */
    public function iOpenSmsTemplateDetailByName($arg1)
    {


        $apiUtil= new \Base\ApiFeaturesContext($this->params);
        $id = $apiUtil->getSmsEmailTemplateIdBySmsTemplateName($arg1);

        $this->getPage(SmsTemplateDetailPage::class)->open(array('smsTemplateId' => $id));
        $this->getPage(SmsTemplateDetailPage::class)->getSession()->wait(1000);

    }


    /**
     * @Given I open email template detail for name :arg1
     */
    public function iOpenEkmailTemplateDetailByName($arg1)
    {


        $apiUtil= new \Base\ApiFeaturesContext($this->params);
        $id = $apiUtil->getSmsEmailTemplateIdBySmsTemplateName($arg1);

        $this->getPage(EmailTemplateDetailPage::class)->open(array('emailTemplateId' => $id));
        $this->getPage(EmailTemplateDetailPage::class)->getSession()->wait(1000);

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
     * Fill sms form with data
     * Example: And fill form with:
     *            | Subject     | Simple text     |
     *            | Users       | [Charlie, Pitt] |
     *            | Date        | 2017-08-24      |
     *
     * @When /^(?:|I )fill SmsTemplate form with:$/
     */
    public function iFillSmsFormWith(TableNode $table)
    {
          $this->smsTemplateDetail->iFillFormWith($table);

    }

    /**
     * Fill email form with data
     * Example: And fill form with:
     *            | Subject     | Simple text     |
     *            | Users       | [Charlie, Pitt] |
     *            | Date        | 2017-08-24      |
     *
     * @When /^(?:|I )fill EmailTemplate form with:$/
     */
    public function iFillEmailFormWith(TableNode $table)
    {
        $this->emailTemplateDetail->iFillFormWith($table);

    }
}
