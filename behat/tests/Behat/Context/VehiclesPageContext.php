<?php

use Behat\Symfony2Extension\Context\KernelAwareContext;
# use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;

use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\VehiclesPage;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use  Oro\Bundle\DataGridBundle\Tests\Behat\Context\GridContext;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Element\Element;
use Page\VehicleDetailPage;
use Behat\MinkExtension\Context\MinkContext;

class VehiclesPageContext extends PageObjectContext
{
    use AssertTrait;


    private $vehiclesPage;


    public function __construct(VehiclesPage $vehiclesPage)
    {
        $this->vehiclesPage = $vehiclesPage;
    }

    /**
     * @Given /^(?:|I )visited vehicles page/
     */
    public function iVisitedThePage()
    {
        $this->vehiclesPage->getPage(vehiclesPage::class)->open();
    }




    /**
     * @Then Vehicles Grid Row number should be almost :arg1
     */
    public function rowNumber($arg1)
    {
        $rowCounts = $this->vehiclesPage->getRowsCount();
        self::assertTrue($rowCounts>= $arg1, 'Row count: ' . $rowCounts . " - Expected >=  ". $arg1);


    }







    /**
     * @Then /^I should see following Vehicles grid:$/
     */
    public function iShouldSeeFollowingList(TableNode $table)
    {
        $grid = $this->vehiclesPage->getElement('TableBody');
        self::assertEquals((count($table->getHash())), $this->vehiclesPage->getRowsCount());
        $rowNumber = 1;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                $cell = $this->vehiclesPage->getCell($rowNumber, $this->vehiclesPage->getColumnPosition($columnName));
                self::assertEquals($cellValue,$cell->getText());
            }
            $rowNumber++;
        }
    }

    /**
     * @Then /^I should see following Vehicles in the grid:$/
     */
    public function iShouldSeeFollowingListInGrid(TableNode $table)
    {

        # to be corrected, check only the first n rows
            $stopRowCheck=50;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                for($i=1;$i<=$stopRowCheck;$i++){
                $cell = $this->vehiclesPage->getCell($i, $this->vehiclesPage->getColumnPosition($columnName));
                if($cellValue==$cell->getText()) {break;}
                if($i==$stopRowCheck) {
                self::assertEquals($cellValue,$cell->getText());}
            }
      #      $rowNumber++;
        }
    }  }

    /**
     * @Then /^I check data version$/
     */
    public function iCheckDataVersion()
    {
        $versionGrid=$this->vehiclesPage->getElement('VersionGrid')->getText();
        $this->vehiclesPage->getElement("FirstRow")->click();
        $this->getPage(vehiclesPage::class)->getSession()->wait(1000);
        $versionDetail=$this->vehiclesPage->getElement('VersionDetail')->getText();
        self::assertTrue($versionGrid == $versionDetail);
    }

    /**
     * @Then /^I check data horse power$/
     */
    public function iCheckDataHorsePower()
    {
        $horsePowerGrid=$this->vehiclesPage->getElement('HorsePowerGrid')->getText();
        $this->vehiclesPage->getElement("FirstRow")->click();
        $this->getPage(vehiclesPage::class)->getSession()->wait(1000);
        $horsePowerDetail=$this->vehiclesPage->getElement('HorsePowerDetail')->getText();
        self::assertTrue($horsePowerGrid == $horsePowerDetail);
    }

    /**
     * @Then /^I check data fuel supply$/
     */
    public function iCheckDataFuelSupply()
    {
        $fuelSupplyGrid=$this->vehiclesPage->getElement('FuelSupplyGrid')->getText();
        $this->vehiclesPage->getElement("FirstRow")->click();
        $this->getPage(vehiclesPage::class)->getSession()->wait(1000);
        $fuelSupplyDetail=$this->vehiclesPage->getElement('FuelSupplyDetail')->getText();
        self::assertTrue($fuelSupplyGrid == $fuelSupplyDetail);
        //$this->vehiclesPage->visit('/vehicles');

        /**$fp = fopen('Text.txt', 'a');
        *fwrite($fp, $powerGrid."\n");
        *fwrite($fp, $powerDetail);
        *fclose($fp);
         */

        /**
        * $fp = fopen('Text.txt', 'a');
        * fwrite($fp, $power);
        * fclose($fp);
        */
    }

    /**
     * @Given /^I check data trasmission$/
     */
    public function iCheckDataTrasmission()
    {
        $trasmissionGrid=$this->vehiclesPage->getElement('TrasmissionGrid')->getText();
        $this->vehiclesPage->getElement("FirstRow")->click();
        $this->getPage(vehiclesPage::class)->getSession()->wait(1000);
        $trasmissionDetail=$this->vehiclesPage->getElement('TrasmissionDetail')->getText();
        self::assertTrue($trasmissionGrid == $trasmissionDetail);
    }


}
