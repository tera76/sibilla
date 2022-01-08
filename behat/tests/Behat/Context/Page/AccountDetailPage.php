<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;




class AccountDetailPage extends Page
{
    private $accountId =0;






    protected $elements = array(
        'Title' => array('css' => 'div.page-header__title.ls-grid-item')

    );

    protected $path = '/accounts-detail/{accountId}';




}
