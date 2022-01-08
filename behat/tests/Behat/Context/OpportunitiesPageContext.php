<?php

use Behat\Symfony2Extension\Context\KernelAwareContext;
# use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;

use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\OpportunitiesPage;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use  Oro\Bundle\DataGridBundle\Tests\Behat\Context\GridContext;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Element\Element;

class OpportunitiesPageContext extends PageObjectContext
{
    use AssertTrait;


    private $opportunitiesPage;


    public function __construct(OpportunitiesPage $opportunitiesPage)
    {
        $this->opportunitiesPage = $opportunitiesPage;
    }

    /**
     * @Given /^(?:|I )visited Opportunities page/
     */
    public function iVisitedThePage()
    {
        $this->opportunitiesPage->getPage(OpportunitiesPage::class)->open();
    }




    /**
     * @Then Opportunities Grid Row number should be almost :arg1
     */
    public function rowNumber($arg1)
    {
        $rowCounts = $this->opportunitiesPage->getRowsCount();
        self::assertTrue($rowCounts>= $arg1, 'Row count: ' . $rowCounts . " - Expected >=  ". $arg1);


    }







    /**
     * @Then /^I should see following Opportunities grid:$/
     */
    public function iShouldSeeFollowingList(TableNode $table)
    {
        $grid = $this->opportunitiesPage->getElement('TableBody');
        self::assertEquals((count($table->getHash())), $this->opportunitiesPage->getRowsCount());
        $rowNumber = 1;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                $cell = $this->opportunitiesPage->getCell($rowNumber, $this->opportunitiesPage->getColumnPosition($columnName));
                self::assertEquals($cellValue,$cell->getText());
            }
            $rowNumber++;
        }
    }

    /**
     * @Then /^I should see following Opportunities in the grid:$/
     */
    public function iShouldSeeFollowingListInGrid(TableNode $table)
    {

        # to be corrected, check only the first n rows
            $stopRowCheck=20;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                for($i=1;$i<=$stopRowCheck;$i++){
                $cell = $this->opportunitiesPage->getCell($i, $this->opportunitiesPage->getColumnPosition($columnName));
                if($cellValue==$cell->getText()) {break;}
                if($i==$stopRowCheck) {
                self::assertEquals($cellValue,$cell->getText());}
            }
      #      $rowNumber++;
        }
    }  }

    /**
     * @When /^I click on Type filter in opportunities grid$/
     */
    public function iClickOnTypeFilterInOpportunitiesGrid()
    {
        $this->opportunitiesPage->getElement("StatusFilter")->click();
    }


}
