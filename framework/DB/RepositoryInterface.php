<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 23:49
 */

namespace Framework\DB;


interface RepositoryInterface
{
    public function findAll($options = []): array;

    public function findById($id): object;

    public function find(object $entity): object;

    public function save(object $entity): bool;

    public function delete(object $entity): bool;

    public function create(): object;
}