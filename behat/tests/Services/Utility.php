<?php
declare(strict_types=1);


namespace Services;


use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\OutlineNode;

class Utility extends Service
{
    /**
     * @var
     */
    private $examples;

    /**
     * @param BeforeScenarioScope $scope
     * @return array|null
     */
    public function getExampleTable(BeforeScenarioScope $scope): ?array
    {
        if (null !== $this->examples) {
            return $this->examples;
        }

        foreach ($scope->getFeature()->getScenarios() as $scenario) {
            if ($scenario instanceof OutlineNode) {
                $this->examples = $this->buildExamples($scenario->getExampleTable()->getTable());
                return $this->examples;
            }
        }
        return null;
    }

    /**
     * @param array $examples
     * @return array
     */
    public function buildExamples(array $examples)
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

    /**
     * @param string $error
     */
    public function printError(string $error)
    {
        echo "\033[31m$error\e[0m\n";
    }
}
