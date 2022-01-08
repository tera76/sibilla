<?php


#use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;
use Behat\MinkExtension\Context\MinkContext;
use Page\Dashboard;
use Page\LoginPage;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\MinkExtension\Context;

use \Behat\MinkExtension\Context\RawMinkContext;

/**
 * Leadspark context.
 */
class  LoginContext extends PageObjectContext
{

    use AssertTrait;


    private $loginPage;


    public function __construct(LoginPage $loginPage)
    {
        $this->loginPage = $loginPage;
    }


    /**
     * @Given /^(?:|I )visited login page/
     */
    public function iVisitedThePage()
    {
        $this->getPage(LoginPage::class)->open();
    }


    /**
     * @Given /^(?:|I )login as administrator$/
     *
     */
    public function loginAsUserWithPassword($login = 'admin@leadspark.app', $password = 'admin')
    {



            $this->getPage(LoginPage::class)->getSession()->getDriver()->reset();
            $this->getPage(LoginPage::class)->open();

            $this->loginPage->loginUserPassword($login, $password);

    }



    public function imAlreadyLoggedIn()
    {
        try {
            $this->getPage(\Page\LeadsPage::class)->open();
        } catch
        (Exception $e) {
            return false;
        }

        return true;
    }

}







