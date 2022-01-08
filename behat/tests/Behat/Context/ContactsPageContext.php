<?php

use Behat\Symfony2Extension\Context\KernelAwareContext;
# use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;

use Page\LeadQualificationPage;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\ContactsPage;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use  Oro\Bundle\DataGridBundle\Tests\Behat\Context\GridContext;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Element\Element;

class ContactsPageContext extends PageObjectContext
{
    use AssertTrait;


    private $contactsPage;


    public function __construct(ContactsPage $contactsPage)
    {
        $this->contactsPage = $contactsPage;
    }

    /**
     * @Given /^(?:|I )visited contacts page/
     */
    public function iVisitedThePage()
    {
        $this->contactsPage->getPage(ContactsPage::class)->open();
    }




    /**
     * @Then Contacts Grid Row number should be almost :arg1
     */
    public function rowNumber($arg1)
    {
        $rowCounts = $this->contactsPage->getRowsCount();
        self::assertTrue($rowCounts>= $arg1, 'Row count: ' . $rowCounts . " - Expected >=  ". $arg1);


    }







    /**
     * @Then /^I should see following contacts grid:$/
     */
    public function iShouldSeeFollowingList(TableNode $table)
    {
        $grid = $this->contactsPage->getElement('TableBody');
        self::assertEquals((count($table->getHash())), $this->contactsPage->getRowsCount());
        $rowNumber = 1;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                $cell = $this->contactsPage->getCell($rowNumber, $this->contactsPage->getColumnPosition($columnName));
                self::assertEquals($cellValue,$cell->getText());
            }
            $rowNumber++;
        }
    }

    /**
     * @Then /^I should see following contacts in the grid:$/
     */
    public function iShouldSeeFollowingListInGrid(TableNode $table)
    {
        $grid = $this->contactsPage->getElement('TableBody');
    #    self::assertEquals((count($table->getHash())), $this->leadsPage->getRowsCount());
     #   $rowNumber = 1;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                for($i=1;$i<=20;$i++){
                $cell = $this->contactsPage->getCell($i, $this->contactsPage->getColumnPosition($columnName));
                if($cellValue==$cell->getText()) {break;}
                if($i==20) {
                self::assertEquals($cellValue,$cell->getText());}
            }
      #      $rowNumber++;
        }
    }  }

    /**
     * @When I Search and open contact for fullText :arg1
     */
    public function iSearchAndOpenContact($arg1)
    {
        $this->contactsPage->searchForFullText($arg1);
        $this->getPage(ContactsPage::class)->getSession()->wait(1000);
        $this->getPage(ContactsPage::class)->getSession()->wait(1000);
    #    $this->getPage(LeadsPage::class)->getSession()->wait(1000);
        $this->contactsPage->clickFirstLine($arg1);
        $this->getPage(ContactsPage::class)->getSession()->wait(1000);
    }


    /**
     * @When I Search contact for fullText :arg1
     */
    public function iSearchContact($arg1)
    {
        $this->contactsPage->searchForFullText($arg1);
        $this->getPage(ContactsPage::class)->getSession()->wait(1000);
        $this->getPage(ContactsPage::class)->getSession()->wait(1000);

    }



    /**
     * @When /^(?:|I )fill contact form with:$/
     */
    public function iFillContactFormWith(TableNode $table)
    {
        /** @var Form $form */
        //  $form = $this->createElement($formName);
        $form = $this->contactsPage->iFillContactFormWith($table);

    }
}
