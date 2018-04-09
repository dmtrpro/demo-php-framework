<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 18:46
 */

namespace Framework\DB;

/**
 * Class QueryBuilder
 * todo: Work at Progress. Not ready for use.
 *
 * @package Framework\DB
 */
class QueryBuilder
{
    public const SELECT = 0;
    public const DELETE = 1;
    public const UPDATE = 2;

    /**
     * @var int
     */
    private $type = self::SELECT;

    /**
     * @var Entity\Entity
     */
    private $entity;

    /**
     * @var array
     */
    private $parts =  [
        'distinct' => false,
        'fields'  => [],
        'aliases' => [],
        'from'    => [],
        'join'    => [],
        'set'     => [],
        'where'   => null,
        'groupBy' => [],
        'having'  => null,
        'orderBy' => [],
    ];

    public function setAlias(string $table, string $alias): QueryBuilder
    {

        $this->parts['aliases'][$table] = $alias;

        return $this;
    }

    public function select($fields): QueryBuilder
    {
        $this->type = self::SELECT;

        $this->parts['fields'] = is_array($fields) ? $fields : func_get_args();

        return $this;
    }

    public function update($table, string $alias = null): QueryBuilder
    {
        $this->type = self::UPDATE;

        if ($table instanceof Entity\Entity) {
            $table = $table->getTableName();
        }

        if (is_string($table)) {
            $this->parts['from'] = $table;
        } else {
            throw new \InvalidArgumentException();
        }

        if ($alias) {
            $this->parts['aliases'][$table] = $alias;
        }

        return $this;
    }

    public function delete($table, string $alias = null): QueryBuilder
    {
        $this->type = self::DELETE;

        if ($table instanceof Entity\Entity) {
            $table = $table->getTableName();
        }

        if (is_string($table)) {
            $this->parts['from'] = $table;
        } else {
            throw new \InvalidArgumentException();
        }

        if ($alias) {
            $this->parts['aliases'][$table] = $alias;
        }

        return $this;
    }

    /**
     * @param $table
     * @param string|null $alias
     * @return QueryBuilder
     */
    public function from($table, string $alias = null): QueryBuilder
    {
        if ($table instanceof Entity\Entity) {
            $table = $table->getTableName();
        }

        if (is_string($table)) {
            $this->parts['from'] = $table;
        } else {
            throw new \InvalidArgumentException();
        }

        if ($alias) {
            $this->parts['aliases'][$table] = $alias;
        }

        return $this;
    }

    public function where($conditions): QueryBuilder
    {
        $this->parts['where'] = is_array($conditions) ? $conditions : func_get_args();

        return $this;
    }

    public function getSql()
    {

    }
}