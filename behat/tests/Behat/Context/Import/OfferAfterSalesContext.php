<?php
declare(strict_types=1);

namespace Import;

use Base\BaseContext;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Services\DatabaseConnection;
use Services\Utility;
use Traits\TokenTrait;
use Utils\Container;
use Utils\DatabaseTableMapping;

class OfferAfterSalesContext implements Context
{
    use TokenTrait;

    /**
     * @var DatabaseConnection
     */
    private $databaseConnection;

    /**
     * @var Utility
     */
    private $utility;

    /**
     * DatabaseConnectionTrait constructor.
     * @param array $parameters
     */
    public function __construct($parameters = [])
    {
        $this->parameters = $parameters;
        $container = Container::getInstance();
        $this->databaseConnection = $container->get(DatabaseConnection::class);
        $this->utility = $container->get(Utility::class);
    }

    /**
     * @Then Opportunity created with leadSparkCrmId :leadSparkCrmId, externalId :externalId, status :status, type :type
     */
    public function opportunityCreatedWith($leadSparkCrmId, $externalId, $status, $type)
    {
        $name = DatabaseTableMapping::getName(DatabaseTableMapping::OPPORTUNITY);
        $opportunities = $this->databaseConnection->doQuery("SELECT * FROM " . $name . " where lead_spark_crm_id = $leadSparkCrmId;");

        Assert::assertCount(1, $opportunities);
        $opportunity = $opportunities[0];
        Assert::assertEquals($externalId, $opportunity['external_id']);
        Assert::assertEquals($status, $opportunity['status_id']);
        Assert::assertEquals($type, $opportunity['type_id']);
    }

    /**
     * @Then there is/are exactly :count :name
     * @Then there is/are exactly :count :name with :conditions
     */
    public function thereIs($count, $name, $conditions = null)
    {
        $sql = 'SELECT COUNT(*) as count FROM ' . $name;
        if (null !== $conditions) {
            $conditions = $this->databaseConnection->parseConditions($conditions);
            $sql .= " WHERE " . $conditions;
        }

        $dbCount = $this->databaseConnection->doQuery($sql);
        Assert::assertEquals($count, $dbCount[0]['count']);
    }

    /**
     * @Given clear rule engine configuration
     */
    public function clearRuleEngineConfig()
    {
        try {
            $connection = $this->databaseConnection->getConnection();
            $connection->exec(<<<SQL
                SET FOREIGN_KEY_CHECKS=0;
                truncate rule_engine_condition_group_condition;
                truncate process_configuration_step;
                truncate process_configuration;
                truncate rule_engine_rule;
                truncate rule_engine_condition_group;
                truncate rule_engine_fallback_rule;
                truncate rule_engine_action;
                SET FOREIGN_KEY_CHECKS=1;
SQL
            );
        } catch (\Exception $e) {
            $this->utility->printError($e->getMessage());
            throw $e;
        }
    }

    /**
     * @Then there is a(n) :queueName message for :identifier
     */
    public function checkMessageInQueue($queueName, $identifier)
    {
        $identifier = $this->replaceToken($identifier);
        $connection = $this->databaseConnection->getQueueConnection();
        $result = $connection->fetchAll("SELECT COUNT(*) as count FROM ".$queueName." WHERE body like '%$identifier%';");
        Assert::assertGreaterThanOrEqual(1, $result[0]['count']);
    }
}
