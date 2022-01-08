<?php

use Behat\Symfony2Extension\Context\KernelAwareContext;
# use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;

use Page\LeadQualificationPage;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\LeadsPage;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use  Oro\Bundle\DataGridBundle\Tests\Behat\Context\GridContext;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Element\Element;

class LeadsPageContext extends PageObjectContext
{
    use AssertTrait;


    private $leadsPage;


    public function __construct(LeadsPage $leadsPage)
    {
        $this->leadsPage = $leadsPage;
    }

    /**
     * @Given /^(?:|I )visited leads page/
     */
    public function iVisitedThePage()
    {
        $this->leadsPage->getPage(LeadsPage::class)->open();
    }




    /**
     * @Then Leads Grid Row number should be almost :arg1
     */
    public function rowNumber($arg1)
    {
        $rowCounts = $this->leadsPage->getRowsCount();
        self::assertTrue($rowCounts>= $arg1, 'Row count: ' . $rowCounts . " - Expected >=  ". $arg1);


    }









    /**
     * @Then /^I should see following leads grid:$/
     */
    public function iShouldSeeFollowingList(TableNode $table)
    {
        $grid = $this->leadsPage->getElement('TableBody');
        self::assertEquals((count($table->getHash())), $this->leadsPage->getRowsCount());
        $rowNumber = 1;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                $cell = $this->leadsPage->getCell($rowNumber, $this->leadsPage->getColumnPosition($columnName));
                self::assertEquals($cellValue,$cell->getText());
            }
            $rowNumber++;
        }
    }

    /**
     * @Then /^I should see following leads in the grid:$/
     */
    public function iShouldSeeFollowingListInGrid(TableNode $table)
    {
        $grid = $this->leadsPage->getElement('TableBody');
    #    self::assertEquals((count($table->getHash())), $this->leadsPage->getRowsCount());
     #   $rowNumber = 1;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                for($i=1;$i<=20;$i++){



                $cell = $this->leadsPage->getCell($i, $this->leadsPage->getColumnPosition($columnName));
                var_dump($cell->getText());
                if($cellValue==$cell->getText()) {break;}
                if($i==20) {
                self::assertEquals($cellValue,$cell->getText());}
            }
      #      $rowNumber++;
        }
    }  }

    /**
     * @When Search and open lead for fullText :arg1
     */
    public function iSearchAndOpenForFullText($arg1)
    {
        $this->leadsPage->searchForFullText($arg1);
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
    #    $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->clickFirstRow();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
    }

    /**
     * @When Search lead for fullText :arg1
     */
    public function iSearchForFullText($arg1)
    {
        $this->leadsPage->searchForFullText($arg1);

    }


    /**
     * @When /^I search leads by filter Not Interested/
     */
    public function iSearchLeadsByFilterNotInterested()
    {

        $this->leadsPage->getElement("StatusFilter")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("Disqualified")->click();
        $this->leadsPage->getElement("Ok")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);

    }

    /**
     * @When /^I search leads by filter Not Valid/
     */
    public function iSearchLeadsByFilterNotValid()
    {

        $this->leadsPage->getElement("StatusFilter")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("SelectAll")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("SelectAll")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("Not Valid")->click();
        $this->leadsPage->getElement("Ok")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);

    }

    /**
     * @When /^I search leads by filter Qualified/
     */
    public function iSearchLeadsByFilterQualified()
    {

        $this->leadsPage->getElement("StatusFilter")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("SelectAll")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("SelectAll")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("Qualified")->click();
        $this->leadsPage->getElement("Ok")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);

    }

    /**
     * @When /^I search leads by filter Unqualified/
     */
    public function iSearchLeadsByFilterUnqualified()
    {

        $this->leadsPage->getElement("StatusFilter")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("SelectAll")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("SelectAll")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("Unqualified")->click();
        $this->leadsPage->getElement("Ok")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);

    }


    /**
     * @When /^I search leads by filter Valid/
     */
    public function iSearchLeadsByFilterValid()
    {

        $this->leadsPage->getElement("StatusFilter")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("SelectAll")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("SelectAll")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->leadsPage->getElement("Valid")->click();
        $this->leadsPage->getElement("Ok")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);

    }

    /**
     * @When /^I click 15 on the datagrid$/
     */
    public function iClick15OnTheDatagrid()
    {
        $this->leadsPage->getElement("15")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
    }

    /**
     * @When /^I click 50 on the datagrid$/
     */
    public function iClick50OnTheDatagrid()
    {
        $this->leadsPage->getElement("50")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
    }

    /**
     * @When /^I click 100 on the datagrid$/
     */
    public function iClick100OnTheDatagrid()
    {
        $this->leadsPage->getElement("100")->click();
        $this->getPage(LeadsPage::class)->getSession()->wait(1000);
    }


    /**
     * @Then /^Leads Grid Row number should be (\d+)$/
     */
    public function leadsGridRowNumberShouldBe($arg1)
    {
        $rowCounts = $this->leadsPage->getRowsCount();
        self::assertTrue($rowCounts == $arg1, 'Row count: ' . $rowCounts . " - Expected =  ". $arg1);
    }

    /**
     * @When /^Search lead by fullText "([^"]*)"$/
     */
    public function searchLeadByFullText($arg1)
    {
       $this->leadsPage->fillField('fullText',$arg1);
       $this->getPage(LeadsPage::class)->getSession()->wait(1000);
    }


}
