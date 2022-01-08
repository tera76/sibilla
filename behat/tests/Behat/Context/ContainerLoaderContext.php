<?php
declare(strict_types=1);


use Behat\Behat\Context\Context;
use Services\DatabaseConnection;
use Services\Utility;
use Utils\Container;

/**
 * Class ContainerLoaderContext
 */
class ContainerLoaderContext implements Context
{
    /**
     * ContainerLoaderContext constructor.
     * @param array $parameters
     */
    public function __construct($parameters = [])
    {
        $container = Container::getInstance();
        $container->setParameters($parameters);
        $container->set(new DatabaseConnection($container));
        $container->set(new Utility($container));
    }
}
