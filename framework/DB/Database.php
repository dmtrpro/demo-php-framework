<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 20:00
 */

namespace Framework\DB;


use PDO;

class Database
{
    protected $db;

    public function __construct(string $options)
    {
        $this->db = new PDO($options);

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function find($entity, string $table)
    {
        if (is_int($entity)) {
            $sql = "SELECT * FROM :tablename WHERE id=:id";
            $stmt = $this->db->prepare($sql);

            $entity = ['id' => $entity];
            $entity['tablename'] = $table;

            return $stmt->execute($entity);
        }

        $prepFields = implode(', ', array_map(function ($val) {
            return $val . '=:' . $val;
        }, array_keys($entity)));

        $sql = "SELECT * FROM :tablename WHERE $prepFields";
        $stmt = $this->db->prepare($sql);

        $entity['tablename'] = $table;

        return $stmt->execute($entity);
    }

    public function save($entity, string $table)
    {
        $keys = array_keys($entity);
        $values = [];
        $update = [];

        foreach ($keys as $key) {
            $values[] = ':' . $key;
            $update[] = $key . '=:' . $key;
        }

        $prepKeys = implode(', ', $keys);
        $prepValues = implode(', ', $values);
        $prepUpdate = implode(', ', $update);

        $sql = "INSERT INTO :tablename ($prepKeys) VALUES ($prepValues) ON DUPLICATE KEY UPDATE $prepUpdate;";
        $stmt = $this->db->prepare($sql);

        $entity['tablename'] = $table;

        return $stmt->execute($entity);
    }

    public function remove($entity, string $table)
    {
        if (is_int($entity)) {
            $sql = "DELETE FROM :tablename WHERE id=:id";
            $stmt = $this->db->prepare($sql);

            $entity = ['id' => $entity];
            $entity['tablename'] = $table;

            return $stmt->execute($entity);
        }

        $prepFields = implode(', ', array_map(function ($val) {
            return $val . '=:' . $val;
        }, array_keys($entity)));

        $sql = "DELETE FROM :tablename WHERE $prepFields";
        $stmt = $this->db->prepare($sql);

        $entity['tablename'] = $table;

        return $stmt->execute($entity);
    }
}