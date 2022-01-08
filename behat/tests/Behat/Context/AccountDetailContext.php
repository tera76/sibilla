<?php

use Base\ApiFeaturesContext;
use Page\AccountDetailPage;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

#use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;

class AccountDetailContext extends PageObjectContext # implements SnippetAcceptingContext
{
    use AssertTrait;


    private $accountDetail;
    private $params;
    private $baseUrl;

    public function __construct(AccountDetailPage $accountDetail, array $parameters)
    {
        $this->accountDetail = $accountDetail;
        $this->params=  !empty($parameters) ? $parameters : array();



    }







    /**
     * @Then Account Detail title should be :arg1
     */
    public function accountDetailTitleShouldBe($arg1)
    {


        self::assertEquals( $arg1, $this->accountDetail->getElement('Title')->getText());

    }


    /**
     * @Given I open account detail for name :arg1
     */
    public function iOpenAccountDetailByName($arg1)
    {
        $util= new ApiFeaturesContext($this->params);
        $id = $util->getAccountIdByAccountName($arg1);
        $this->getPage(AccountDetailPage::class)->open(array('accountId' => $id));
        $this->getPage(AccountDetailPage::class)->getSession()->wait(1000);
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


}
