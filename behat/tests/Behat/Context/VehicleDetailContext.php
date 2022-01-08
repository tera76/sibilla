<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;


use Page\VehicleDetailPage;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Page\Element\Table;


use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class VehicleDetailContext extends PageObjectContext # implements SnippetAcceptingContext
{
    use AssertTrait;


    private $vehicleDetailPage;
    private $params;
    private $baseUrl;

    public function __construct(VehicleDetailPage $vehicleDetailPage, array $parameters)
    {
        $this->vehicleDetailPage = $vehicleDetailPage;
        $this->params = !empty($parameters) ? $parameters : array();


    }


    /**
     * @Then Vehicle Detail title should be :arg1
     */
    public function VehicleDetailTitleShouldBe($arg1)
    {


        self::assertEquals($arg1, $this->vehicleDetailPage->getElement('Title')->getText());

    }




    /**
     * @Given I open vehicle detail by model and version :arg1
     */
    public function iOpenVehicleDetailByVersion($arg1)
    {

        $util = new \Base\ApiFeaturesContext($this->params);
        $id = $util->getVehicleIdByModelAndVersion($arg1);

        $this->getPage(vehicleDetailPage::class)->open(array('Id' => $id));
        $this->getPage(vehicleDetailPage::class)->getSession()->wait(1000);

    }





    /**
     * Fill form with data
     * Example: And fill form with:
     *            | Subject     | Simple text     |
     *            | Users       | [Charlie, Pitt] |
     *            | Date        | 2017-08-24      |
     *
     * @When /^(?:|I )fill vehicleFail form with:$/
     */
    public function iFillFormWith(TableNode $table)
    {
        $this->vehicleDetailPage->iFillFormWith($table);

    }


}
