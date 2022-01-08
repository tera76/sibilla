<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkAwareContext;
use Page\Element\Table;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\MinkContext;

class LoginPage extends Page
{

    protected $elements = array(
        'login_form' => array('xpath' =>  "//*")
    );

    protected $path = '/login';

    public function loginUserPassword($user,$password)
    {

        //$this->getElement('login_form')->fillField('email',$user);
        //$this->getElement('login_form')->fillField('password', $password);
        //$this->getElement('login_form')->pressButton('submit');
        $this->fillField('email',$user);
        $this->fillField('password', $password);
        $this->pressButton('submit');
        $this->iWait(2);

      //  $this->waitForNext();
        if($this->hasButton('submit')){
        $this->pressButton('submit');
        $this->iWait(1);}


    }


    public function waitForNext()
    {
        $line = readline("Command      login: ");
        if($line=='exit') exit();
        if($line=='die') die();
        if($line=='e') exit();
    }
    public function iWait($timeout = 1)
    {
        $this->getSession()->wait($timeout * 1000);
    }
}
