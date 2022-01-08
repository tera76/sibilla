<?php

namespace Page;

use Behat\Gherkin\Node\TableNode;
use Page\Element\Table;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Element\NodeElement;


class TasksPage extends Page
{


    protected $elements = array(
        'TableHeader' => array('xpath' => '//*[@id="app-wrapper__page"]/div/div[2]/div/div/div/div/div[5]/div/table/tbody/tr'),
        "TableBody" => array('xpath' => '//*[@id="app-wrapper__page"]/div/div[2]/div/div/div/div/div[6]/div/table'),
        "fullTextSearch"=> array('xpath' => '//*/input[@name="fullText"]'),
        "TypeFilter" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[1]/div[2]/div[1]/div[5]/div[1]/table[1]/tbody[1]/tr[1]/td[1]/div[2]'),
        "StatusFilter" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[1]/div[2]/div[1]/div[5]/div[1]/table[1]/tbody[1]/tr[1]/td[3]/div[2]'),
        "AssignedToFilter" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[1]/div[2]/div[1]/div[5]/div[1]/table[1]/tbody[1]/tr[1]/td[4]/div[2]'),
        "FirstRow" => array('xpath' => '//*/div[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div[1]/div[1]/div[2]/div[1]/div[6]/div[1]/table[1]/tbody[1]/tr[1]'),

    );

    protected $path = '/tasks';


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
        $cell = $row->find('xpath', sprintf('//td[%d]/div', $columnPosition));
        #    var_dump($cell->getText());
     #   die();
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

        var_dump('no item found ciccio, return 0');
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


}
