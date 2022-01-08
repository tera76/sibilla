<?php
declare(strict_types=1);

namespace Services;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DatabaseConnection extends Service
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var Connection
     */
    private $queueConnection;

    /**
     * @param string $sql
     * @return mixed[]
     */
    public function doQuery(string $sql)
    {
        var_dump("conneeeeection:" . $sql);
        die();
        $connection = $this->getConnection();
        var_dump("conneeeeection:" . $connection);
        return $connection->fetchAll($sql);
    }

    /**
     * @param string $sql
     * @return int
     */
    public function exec(string $sql)
    {
        $connection = $this->getConnection();
        return $connection->exec($sql);
    }

    /**
     * @return Connection
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getConnection(): Connection
    {
        if (null !== $this->connection) {
            return $this->connection;
        }

        $connectionParameters = $this->container->getParameter('connections.default');

        var_dump("connectionParameters" .  $connectionParameters);
        $config = new Configuration;
        $connectionParams = array(
            'dbname' => $connectionParameters['name'],
            'user' => $connectionParameters['user'],
            'password' => $connectionParameters['password'],
            'host' => $connectionParameters['host'],
            'driver' => 'pdo_mysql'
        );



        $this->connection = DriverManager::getConnection($connectionParams, $config);
        return $this->connection;
    }

    /**
     * @return Connection
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getQueueConnection(): Connection
    {
        if (null !== $this->queueConnection) {
            return $this->queueConnection;
        }

        $connectionParameters = $this->container->getParameter('connections.messenger');
        $config = new Configuration;
        $connectionParams = array(
            'dbname' => $connectionParameters['name'],
            'user' => $connectionParameters['user'],
            'password' => $connectionParameters['password'],
            'host' => $connectionParameters['host'],
            'driver' => 'pdo_mysql'
        );

        $this->connection = DriverManager::getConnection($connectionParams, $config);
        return $this->connection;
    }

    /**
     * @param $conditions
     * @return string
     */
    public function parseConditions($conditions)
    {
        return str_replace([',', '= '], ['\' AND ', '= \''], $conditions) . '\'';
    }
}
