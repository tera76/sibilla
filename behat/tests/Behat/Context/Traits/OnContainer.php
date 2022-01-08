<?php


namespace Traits;


use Utils\Container;

trait OnContainer
{

    /**
     * @BeforeScenario
     */
    public function setOnContainer()
    {
        Container::getInstance()->set($this);
    }
}
