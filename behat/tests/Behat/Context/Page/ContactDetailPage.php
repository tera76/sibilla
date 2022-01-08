<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;




class ContactDetailPage extends Page
{
    private $contactId =0;






    protected $elements = array(
        'Title' => array('css' => 'div.page-header__title.ls-grid-item'),
        "FirstRow" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[1]/div[2]/div[1]/div[6]/div[1]/table[1]/tbody[1]/tr[1]'),
        "SendSMS" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]'),
        "SendEmail" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[2]'),
        "TextArea" => array('xpath' => '//*/div[3]/div[3]/div[2]/div[2]/div[1]/div[1]/div[1]/div[1]/textarea[1]'),
        "NumberOfCharacter" => array('xpath' => '//*/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/form[1]/div[3]/div[1]/div[2]'),

    );

    protected $path = 'contacts/contact-detail/{contactId}';

}

