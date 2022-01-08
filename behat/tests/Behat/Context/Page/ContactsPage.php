<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;


class ContactsPage extends Page
{


    protected $elements = array(
        'TableHeader' => array('css' => 'tr.dx-row.dx-header-row'),
        "TableBody" => array('xpath' => '//*[@id="app-wrapper__page"]/div/div[2]/div/div/div[2]/div/div[6]/div/table'),
        "fullTextSearch"=> array('xpath' => '//*/input[@name="fullText"]'),
        "FirstLine"=> array('xpath' => '//*[@id="app-wrapper__page"]/div/div[2]/div/div/div[2]/div/div[6]/div/table/tbody/tr[1]/td[7]'),

        "Contact_firstName" => array('xpath' => '//*/input[@name="firstName"]'),
        "Contact_lastName" => array('xpath' => '//*/input[@name="lastName"]'),
        "Contact_phone_number1" => array('xpath' => '//*/input[@name="phonePrimary"]'),
        "Contact_phone_number2" => array('xpath' => '//*/input[@name="phoneSecondary"]'),
        "Contact_email1" => array('xpath' => '//*/input[@name="emailPrimary"]'),
        "Contact_email2" => array('xpath' => '//*/input[@name="emailSecondary"]'),
        "Contact_gender" => array('xpath' =>  '//*/select[@name="gender"]'),
        "Contact_paese" => array('xpath' =>  '//*/select[@name="country"]'),
        "Contact_CAP" => array('xpath' =>  '//*/input[@name="postalCode"]'),
        "Contact_citta" => array('xpath' =>  '//*/input[@name="city"]'),

        "Contact_dateBirth" =>array('xpath' => '//*/input[@name="dateOfBirth"]'),

        "Privacy_data_yes" =>array('xpath' => '//*/input[@name="privacy-data_processing"][1]'),
        "Privacy_data_no" =>array('xpath' => '//*/input[@name="privacy-data_processing"][2]'),

        "Privacy_profiling_yes" =>array('xpath' => '//*/input[@name="privacy-profiling"][1]'),
        "Privacy_profiling_no" =>array('xpath' => '//*/input[@name="privacy-profiling"][2]'),

        "Privacy_third_party_yes" =>array('xpath' => '//*/input[@name="privacy-third_party_assignment"][1]'),
        "Privacy_third_party_no" =>array('xpath' => '//*/input[@name="privacy-third_party_assignment"][2]'),

        "Search_fullText" => array('xpath' => '//*/input[@name="fullText"]'),
        "Contact_FirstItem" => array('xpath' => '//*/table/tbody/tr[1]/td[1]/div/div/div/div/div'),

    );

    protected $path = '/contacts';


    public function getGridHeader()
    {

        $grid = $this->getElement('TableHeader');
        return $grid;
    }

    public function getGridBody()
    {

        $grid = $this->getElement('TableBody');
        return $grid;
    }


    public function getRowsCount(): int
    {
        return count($this->getGridBody()->findAll('css', 'tbody tr')) - 1;
    }


    public function getCell(int $rowPosition, int $columnPosition)
    {
        $row = $this->getGridBody()->find('xpath', sprintf('//tbody/tr[%d]', $rowPosition));
        $cell = $row->find('xpath', sprintf('//td[%d]', $columnPosition));
        return $cell;
    }

    public function getColumnPosition(string $columnTitle): int
    {

        $i = 0;
        $items = $this->getGridHeader()->findAll('css', 'td');

        //  var_dump($items->getText());
        //   die();

        foreach ($items as $i => $item) {
            if ($item && $columnTitle === $item->getText()) {
                return $i + 1;
            }
        }
# experimental return funcion
          return 0;
#        $availableColumns = array_map(function (NodeElement $item) {
#               return $item->getText();
#           }, $items);

    }

    public function getRowByNumber($rowNumber)
    {
        $rowIndex = $rowNumber - 1;
        $rows = $this->getRows();
        return $rows[$rowIndex];
    }

    public function getRows()
    {
        return $this->getRowElements(static::TABLE_ROW_ELEMENT);
    }

    public function searchForFullText($name)
    {
        $this->getElement('fullTextSearch')->setValue($name);

    }

    public function clickFirstLine()
    {
        $this->getElement('FirstLine')->click();

    }

    public function iFillContactFormWith(TableNode $table)
    {

        foreach ($table->getRows() as $row) {
            list($label, $value) = $row;
            if ($label == 'Contact_gender' || $label == 'Contact_paese') {
                $this->getElement($label)->selectOption($value);
            } else if ($label == 'Contact_dateBirth') {
                $this->getElement($label)->setValue($value);
            } else $this->getElement($label)->setValue($value);
        }

        $this->getSession()->wait(1000);

        $this->getElement("Privacy_data_yes")->click();
        $this->getElement("Privacy_profiling_yes")->click();
        $this->getElement("Privacy_third_party_yes")->click();

    }

}
