<?php

use Behat\Symfony2Extension\Context\KernelAwareContext;
# use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;

use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\TasksPage;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use  Oro\Bundle\DataGridBundle\Tests\Behat\Context\GridContext;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Element\Element;

class TasksPageContext extends PageObjectContext
{
    use AssertTrait;


    private $tasksPage;


    public function __construct(TasksPage $tasksPage)
    {
        $this->tasksPage = $tasksPage;
    }

    /**
     * @Given /^(?:|I )visited tasks page/
     */
    public function iVisitedThePage()
    {
        $this->tasksPage->getPage(TasksPage::class)->open();
    }


    /**
     * @Then Tasks Grid Row number should be almost :arg1
     */
    public function rowNumber($arg1)
    {
        $rowCounts = $this->tasksPage->getRowsCount();
        self::assertTrue($rowCounts >= $arg1, 'Row count: ' . $rowCounts . " - Expected >=  " . $arg1);


    }

    /**
     * @Then Tasks Grid Row number should be equal to :arg1
     */
    public function rowNumberUqualTo($arg1)
    {
        $rowCounts = $this->tasksPage->getRowsCount();
        self::assertTrue($rowCounts == $arg1, 'Row count: ' . $rowCounts . " - Expected =  " . $arg1);

    }


    /**
     * @Then /^I should see following tasks grid:$/
     */
    public function iShouldSeeFollowingList(TableNode $table)
    {
        $grid = $this->tasksPage->getElement('TableBody');
        self::assertEquals((count($table->getHash())), $this->tasksPage->getRowsCount());
        $rowNumber = 1;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                $cell = $this->tasksPage->getCell($rowNumber, $this->tasksPage->getColumnPosition($columnName));
                self::assertEquals($cellValue, $cell->getText());
            }
            $rowNumber++;
        }
    }

    /**
     * @Then /^I should see following tasks in the grid:$/
     */
    public function iShouldSeeFollowingListInGrid(TableNode $table)
    {
        $grid = $this->tasksPage->getElement('TableBody');
        #    self::assertEquals((count($table->getHash())), $this->tasksPage->getRowsCount());
        #   $rowNumber = 1;


        $stopRowCheck = 5;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                for ($i = 1; $i <= $stopRowCheck; $i++) {
                    $cell = $this->tasksPage->getCell($i, $this->tasksPage->getColumnPosition($columnName));

                    if ($cellValue == $cell->getText()) {
                        break;
                    }
                    #   stop after some number of row checks in the grid
                    if ($i == $stopRowCheck) {
                        self::assertEquals($cellValue, $cell->getText(), 'Expected:' . $cellValue . ', found: ' . $cell->getText());
                    }
                }
                #      $rowNumber++;
            }
        }
    }


    /**
     * @When I search task by fullText :arg1
     */
    public function iSearchTaskByFullText($arg1)
    {
        $this->tasksPage->getElement("fullTextSearch")->setValue($arg1);
        $this->getPage(TasksPage::class)->getSession()->wait(1000);
    }


    /**
     * @When I click on Type filter in task grid
     */
    public function iClickOnTypeFilter()
    {
        $this->tasksPage->getElement("TypeFilter")->click();
    }

    /**
     * @When I click on Status filter in task grid
     */
    public function iClickOnStatusFilter()
    {
        $this->tasksPage->getElement("StatusFilter")->click();
    }

    /**
     * @When I click on Assigned To filter in task grid
     */
    public function iClickOnAssignedToFilter()
    {
        $this->tasksPage->getElement("AssignedToFilter")->click();
    }

    /**
     * @Then /^I click on first row$/
     */
    public function iClickOnFirstRow()
    {
        $this->tasksPage->getElement("FirstRow")->click();
        $this->getPage(TasksPage::class)->getSession()->wait(1000);
    }

    /**
     * @When /^I open lead qualification by name (.*)$/
     */
    public function iOpenLeadQualificationByName($param)
    {
        $this->getPage(\Page\TasksPage::class)->open();
        $this->getPage(TasksPage::class)->getSession()->wait(1000);
        $this->tasksPage->getElement("fullTextSearch")->setValue($param);
        $this->getPage(TasksPage::class)->getSession()->wait(1000);
        $this->tasksPage->getElement("FirstRow")->click();
        $this->getPage(TasksPage::class)->getSession()->wait(3000);

    }

}
