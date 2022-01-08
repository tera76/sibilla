<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;


class EmailTemplateDetailPage extends Page
{
    private $smsTemplateId = 0;


    protected $elements = array(
        "Title" => array('css' => 'div.page-header__title.ls-grid-item'),
        "Name" => array('xpath' => '//*[@id="input_3"]')
    );

    protected $path = '/activities/email_templates/{emailTemplateId}';



}
