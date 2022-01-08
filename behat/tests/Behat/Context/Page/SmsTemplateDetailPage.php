<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;


class SmsTemplateDetailPage extends Page
{
    private $smsTemplateId = 0;


    protected $elements = array(
        "Title" => array('css' => 'div.page-header__title.ls-grid-item'),
        "Name" => array('xpath' => '//*[@id="input_3"]')
    );

    protected $path = '/activities/sms_templates/{smsTemplateId}';



}
