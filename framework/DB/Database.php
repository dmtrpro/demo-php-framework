<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 20:00
 */

namespace Framework\DB;


use Framework\DB\Type\Type;
use PDO;

interface Database
{
    /**
     * @param string $table
     * @param Type[] $fields
     * @return bool
     */
    public function createTable(string $table, array $fields): bool;

    /**
     * @param string $table
     * @param array $entity
     * @return bool
     */
    public function save(string $table, array $entity): bool;

    /**
     * @param string $table
     * @param array $entity
     * @return bool
     */
    public function remove(string $table, array $entity): bool;

    /**
     * @param string $table
     * @param array $entity
     * @return mixed
     */
    public function find(string $table, array $entity);

    /**
     * @param string $table
     * @param array $options
     * @return mixed
     */
    public function findAll(string $table, array $options);
}