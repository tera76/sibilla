<?php
declare(strict_types=1);


namespace Traits;


use Utils\Container;

trait ContainerAware
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @BeforeScenario
     */
    public function getContainer()
    {
        $this->container = Container::getInstance();
    }
}
