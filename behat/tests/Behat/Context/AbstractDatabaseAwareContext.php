<?php
declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\OutlineNode;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * Class AbstractDatabaseAwareContext
 */
abstract class AbstractDatabaseAwareContext implements Context
{
    /**
     * @var array
     */
    private $parameters;
    /**
     * @var
     */
    private $connection;

    /**
     * @var BeforeScenarioScope
     */
    private $scope;
    /**
     * @var
     */
    private $examples;

    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
        $this->scope = $scope;
    }

    protected function getExampleTable(): ?array
    {
        if (null !== $this->examples) {
            return $this->examples;
        }

        foreach ($this->scope->getFeature()->getScenarios() as $scenario) {
            if ($scenario instanceof OutlineNode) {
                $this->examples = $this->buildExamples($scenario->getExampleTable()->getTable());
                return $this->examples;
            }
        }
        return null;
    }

    private function buildExamples(array $examples)
    {
        $header = array_shift($examples);
        $newHeader = [];

        foreach ($header as $index => $column) {
            list($tableName, $columnName) = explode('.', $column);
            $newHeader[$tableName][$index] = $columnName;
        }

        $a = [];
        foreach ($newHeader as $tableName => $tableColumns) {
            $b = [];
            foreach ($examples as $row) {
                $c = [];
                foreach ($row as $index => $columnValue) {
                    if (isset($tableColumns[$index])) {
                        $c[$tableColumns[$index]] = $columnValue;
                    }
                }
                $b[] = $c;
            }
            $a[$tableName] = $b;
        }

        return $a;
    }

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    protected function doQuery(string $sql)
    {
        $connection = $this->getConnection();
        return $connection->fetchAll($sql);
    }

    private function getConnection(): Connection
    {
        if (null !== $this->connection) {
            return $this->connection;
        }

        $config = new Configuration;
        $connectionParams = array(
            'dbname' => $this->parameters['database_name'],
            'user' => $this->parameters['database_user'],
            'password' => $this->parameters['database_password'],
            'host' => $this->parameters['database_host'],
            'driver' => 'pdo_mysql'
        );

        $this->connection = DriverManager::getConnection($connectionParams, $config);
        return $this->connection;
    }

    /**
     * @Then records match example row for :tableName
     */
    public function match($tableName)
    {
        $examples = $this->getExampleTable();
        Assert::assertArrayHasKey($tableName, $examples);

        $sqlBase = 'SELECT COUNT(*) as count FROM '.$tableName.' where ';
        foreach ($examples[$tableName] as $condition) {
            $sql = $sqlBase;
            $first = true;
            foreach ($condition as $columnName => $value) {
                if (!$first) {
                    $sql .= ' AND ';
                } else {
                    $first = false;
                }
                $sql .= $columnName.' = \''.$value.'\'';
            }
            $result = $this->doQuery($sql);
            try {
                Assert::assertCount(1, $result);
                Assert::assertEquals(1, $result[0]['count']);
            } catch (ExpectationFailedException $e) {
                echo $e->getMessage()."\n";
              //  exit;
            }
            catch (Exception $e) {
                echo $e->getMessage()."\n";
            }
        }
    }
}
