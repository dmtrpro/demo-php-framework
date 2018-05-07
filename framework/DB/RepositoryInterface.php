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
    public function findAll($options = []);

    public function findById($id);

    public function find($entity);

    public function save($entity): bool;

    public function delete($entity): bool;

    public function create();
}