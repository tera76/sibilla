<?php
declare(strict_types=1);


namespace Services;

use Psr\Container\ContainerInterface;
use Utils\Container;

abstract class Service
{
    /**
     * @var Container
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
