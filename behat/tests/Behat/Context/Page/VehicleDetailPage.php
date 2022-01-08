<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;


class VehicleDetailPage extends Page
{
    private $vehicleId = 0;


    protected $elements = array(
        "Title" => array('css' => 'div.page-header__title.ls-grid-item'),
        "Select_Vehicle_Status" => array('xpath' => '//select[@name="status"]'),
        "Select_Fail_Reason" => array('xpath' => '(//select[@name="status"])[2]')
    );

    protected $path = '/vehicles/vehicle-detail/{Id}';


    public function iFillFormWith(TableNode $table)
    {

        foreach ($table->getRows() as $row) {
            list($label, $value) = $row;
            # working with select
                $this->getElement($label)->selectOption($value);
            $this->getPage(OpportunityDetailPage::class)->getSession()->wait(1000);

        }
    }
}
