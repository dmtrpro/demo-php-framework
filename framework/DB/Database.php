<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 20:00
 */

namespace Framework\DB;


use PDO;

interface Database
{
    public function save(string $table, $entity): bool;

    public function remove(string $table, $entity): bool;

    public function find(string $table, $entity);

    public function findAll(string $table, array $options);
}