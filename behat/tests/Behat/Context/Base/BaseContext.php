<?php
declare(strict_types=1);
namespace Base;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use Services\DatabaseConnection;
use Services\Utility;
use Traits\ContainerAware;
use Traits\TokenTrait;
use Utils\Container;

/**
 * Class BaseContext
 */
final class BaseContext implements Context
{
    use TokenTrait;
    use ContainerAware;

    /**
     * @var ApiContext
     */
    private $apiContext;

    /**
     * @var Utility
     */
    private $utility;

    /**
     * @var BeforeScenarioScope
     */
    private $scope;

    /**
     * @var DatabaseConnection
     */
    private $databaseConnection;

    public function __construct($parameters = [])
    {
        $this->parameters = $parameters;
        $container = Container::getInstance();
        $this->databaseConnection = $container->get(DatabaseConnection::class);
        $this->utility = $container->get(Utility::class);
    }

    /**
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $this->scope = $scope;
        $this->apiContext = $scope->getEnvironment()->getContext('Base\ApiFeaturesContext');
    }

    /**
     * @Then I get the :field from the response as :name
     */
    public function getFromResponse($field, $saveAs)
    {
        $this->fieldNames[] = $saveAs;
        $this->fieldValues[] = $this->apiContext->getResponseBody()->$field;
    }

    /**
     * @Then I get the nested field from the response as :name
     */
    public function getNestedFromResponse($saveAs)
    {
        $this->fieldNames[] = $saveAs;
        $this->fieldValues[] = $this->apiContext->getResponseBody()->offers[0]->id;
    }

    /**
     * @Given the updated body:
     */
    public function theUpdatedBodyIs($body)
    {
        //$body = $this->replaceToke( $body);
        $this->apiContext->setRequestBody($body);
    }

    /**
     * @When I update with :path using HTTP :method
     */
    public function requestPath($path, $method = null)
    {
        $path = $this->replaceToken($path);
        return $this->apiContext->requestPath($path, $method);
    }

    /**
     * @Then records match example row for :tableName
     */
    public function match($tableName)
    {
        $examples = $this->utility->getExampleTable($this->scope);
        Assert::assertArrayHasKey($tableName, $examples);

        $sqlBase = 'SELECT COUNT(*) as count FROM ' . $tableName . ' where ';
        foreach ($examples[$tableName] as $condition) {
            $sql = $sqlBase;
            $first = true;
            foreach ($condition as $columnName => $value) {
                if (!$first) {
                    $sql .= ' AND ';
                } else {
                    $first = false;
                }
                $sql .= $columnName . ' = \'' . $value . '\'';
            }
            $result = $this->databaseConnection->doQuery($sql);
            try {
                Assert::assertCount(1, $result);
                Assert::assertEquals(1, $result[0]['count']);
            } catch (ExpectationFailedException $e) {
                $this->utility->printError($e->getMessage() . "Error during assert for table $tableName");
                throw $e;
            }
        }
    }

    /**
     * @Then records match example row for all columns without duplicates
     */
    public function matchAllWithoutDuplicates()
    {
        $this->matchAll();
    }

    /**
     * @Then records match example row for all columns with possible duplicates
     */
    public function matchAllWithDuplicates()
    {
        $this->matchAll(true);
    }

    public function matchAll($acceptDuplicate = false)
    {

        $examples = $this->utility->getExampleTable($this->scope);

        foreach ($examples as $tableName => $table) {
            $sqlBase = 'SELECT COUNT(*) as count FROM ' . $tableName . ' where ';
            foreach ($table as $condition) {
                $sql = $sqlBase;
                $first = true;
                foreach ($condition as $columnName => $value) {
                    if (!$first) {
                        $sql .= ' AND ';
                    } else {
                        $first = false;
                    }
                    $sql .= $columnName . ' = \'' . $value . '\'';
                }
                $result = $this->databaseConnection->doQuery($sql);
                try {
                    Assert::assertCount(1, $result);
                    if ($acceptDuplicate) {
                        Assert::assertGreaterThanOrEqual(1, $result[0]['count']);
                    } else {
                        Assert::assertEquals(1, $result[0]['count']);
                    }
                } catch (ExpectationFailedException $e) {
                    $this->utility->printError($e->getMessage() . "Error during assert for table $tableName with query: \"$sql\"");
                    throw $e;
                }
            }
        }
    }
}
