<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class Dashboard extends Page
{


    protected $elements = array(
        //'Title' => array('xpath' => '//*[@id="app-wrapper__page"]/div/div/div/div[1]/div/div/div')
        'Title' => array('css' => 'div.page-header__header.ls-grid-item')

  );

    protected $path = '/dashboard';


    public function getTitle()
    {

       return $this->getElement('Title')->getText();

    }



}