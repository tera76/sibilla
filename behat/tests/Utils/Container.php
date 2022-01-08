<?php
declare(strict_types=1);


namespace Utils;

use Psr\Container\ContainerInterface;

/**
 * Class Container
 * @package Utils
 */
class Container implements ContainerInterface
{
    /**
     * @var Container
     */
    private static $instance;
    /**
     * @var array
     */
    protected $services = [];
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if(null === self::$instance)
        {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

    /**
     * @param string $id
     * @return mixed|null
     */
    public function get($id)
    {
        if (isset($this->services[$id])) {
            return $this->services[$id];
        }

        return null;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id): bool
    {
        return isset($this->services[$id]);
    }

    /**
     * @param $service
     */
    public function set($service): void
    {
        $this->services[get_class($service)] = $service;
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function getParameter($id)
    {
        if (isset($this->parameters[$id])) {
            return $this->parameters[$id];
        }

        return $this->traverseParameter($id, $this->parameters);
    }

    private function traverseParameter($id, array $parameters = [])
    {
        $parts = explode('.', $id, 2);
        if (!isset($parameters[$parts[0]])) {
            return null;
        }

        if (count($parts) > 1) {
            return $this->traverseParameter($parts[1], $parameters[$parts[0]]);
        }

        return $parameters[$parts[0]];
    }

    /**
     * @param string $id
     * @return bool
     */
    public function hasParameter($id): bool
    {
        return isset($this->parameters[$id]);
    }

    /**
     * @param $id
     * @param $parameter
     */
    public function setParameter($id, $parameter): void
    {
        $this->parameters[$id] = $parameter;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters = []): void
    {
        $this->parameters = $parameters;
    }
}
