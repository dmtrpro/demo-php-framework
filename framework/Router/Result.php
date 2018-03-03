<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 03.03.18
 * Time: 23:59
 */

namespace Framework\Router;


class Result
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $handler;

    /**
     * @var string[]
     */
    private $attributes;

    /**
     * Result constructor.
     *
     * @param string $name
     * @param $handler
     * @param array $attributes
     */
    public function __construct(string $name, $handler, array $attributes)
    {
        $this->name = $name;
        $this->handler = $handler;
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|callable
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return string[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}