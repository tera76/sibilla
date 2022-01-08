<?php

use Behat\Symfony2Extension\Context\KernelAwareContext;
# use Oro\Bundle\TestFrameworkBundle\Behat\Context\AssertTrait;

use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Behat\Context\Context;
use Page\SmsTemplatesPage;
use Page\EmailTemplatesPage;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use  Oro\Bundle\DataGridBundle\Tests\Behat\Context\GridContext;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Element\Element;

class SmsEmailTemplatesPageContext extends PageObjectContext
{
    use AssertTrait;


    private $smsTemplatesPage;
    private $emailTemplatesPage;


    public function __construct(SmsTemplatesPage $smsTemplatesPage, EmailTemplatesPage $emailTemplatesPage )
    {
        $this->smsTemplatesPage = $smsTemplatesPage;
        $this->emailTemplatesPage = $emailTemplatesPage;
    }

    /**
     * @Given /^(?:|I )visited SmsTemplates page/
     */
    public function iVisitedSmsTemplatePage()
    {
        $this->smsTemplatesPage->getPage(SmsTemplatesPage::class)->open();
    }

    /**
     * @Given /^(?:|I )visited EmailTemplates page/
     */
    public function iVisitedEmailTemplatePage()
    {
        $this->emailTemplatesPage->getPage(EmailTemplatesPage::class)->open();
    }



    /**
     * @Then SmsTemplates Grid Row number should be almost :arg1
     */
    public function rowNumberSms($arg1)
    {
        $rowCounts = $this->smsTemplatesPage->getRowsCount();
        self::assertTrue($rowCounts>= $arg1, 'Row count: ' . $rowCounts . " - Expected >=  ". $arg1);


    }

    /**
     * @Then EmailTemplates Grid Row number should be almost :arg1
     */
    public function rowNumberEmail($arg1)
    {
        $rowCounts = $this->emailTemplatesPage->getRowsCount();
        self::assertTrue($rowCounts>= $arg1, 'Row count: ' . $rowCounts . " - Expected >=  ". $arg1);


    }







    /**
     * @Then /^I should see following SmsTemplates grid:$/
     */
    public function iShouldSeeFollowingSmsTemplateList(TableNode $table)
    {
        $grid = $this->smsTemplatesPage->getElement('TableBody');
        self::assertEquals((count($table->getHash())), $this->smsTemplatesPage->getRowsCount());
        $rowNumber = 1;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                $cell = $this->smsTemplatesPage->getCell($rowNumber, $this->smsTemplatesPage->getColumnPosition($columnName));
                self::assertEquals($cellValue,$cell->getText());
            }
            $rowNumber++;
        }
    }

    /**
     * @Then /^I should see following EmailTemplates grid:$/
     */
    public function iShouldSeeFollowingEmailTemplateList(TableNode $table)
    {
        $grid = $this->emailTemplatesPage->getElement('TableBody');
        self::assertEquals((count($table->getHash())), $this->emailTemplatesPage->getRowsCount());
        $rowNumber = 1;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                $cell = $this->emailTemplatesPage->getCell($rowNumber, $this->emailTemplatesPage->getColumnPosition($columnName));
                self::assertEquals($cellValue,$cell->getText());
            }
            $rowNumber++;
        }
    }

    /**
     * @Then /^I should see following SmsTemplates in the grid:$/
     */
    public function iShouldSeeFollowingSmsTemplateListInGrid(TableNode $table)
    {

        # to be corrected, check only the first n rows
            $stopRowCheck=10;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                for($i=1;$i<=$stopRowCheck;$i++){
                $cell = $this->smsTemplatesPage->getCell($i, $this->smsTemplatesPage->getColumnPosition($columnName));
                if($cellValue==$cell->getText()) {break;}
                if($i==$stopRowCheck) {
                self::assertEquals($cellValue,$cell->getText());}
            }
      #      $rowNumber++;
        }
    }  }

    /**
     * @Then /^I should see following emailTemplates in the grid:$/
     */
    public function iShouldSeeFollowingEmaiTemplateListInGrid(TableNode $table)
    {

        # to be corrected, check only the first n rows
        $stopRowCheck=10;
        foreach ($table->getHash() as $row) {
            foreach ($row as $columnName => $cellValue) {
                for($i=1;$i<=$stopRowCheck;$i++){
                    $cell = $this->emailTemplatesPage->getCell($i, $this->emailTemplatesPage->getColumnPosition($columnName));
                    if($cellValue==$cell->getText()) {break;}
                    if($i==$stopRowCheck) {
                        self::assertEquals($cellValue,$cell->getText());}
                }
                #      $rowNumber++;
            }
        }  }
}
