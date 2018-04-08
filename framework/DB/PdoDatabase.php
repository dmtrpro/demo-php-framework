<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 20:00
 */

namespace Framework\DB;


use PDO;

class PdoDatabase implements Database
{
    protected $db;

    public function __construct(string $dsn, ?string $username = null, ?string $password = null, ?array $options = null)
    {
        try {
            $this->db = new PDO($dsn, $username, $password, $options);

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function save(string $table, $entity): bool
    {
        $keys = array_keys($entity);
        //$values = [];
        $update = [];

        foreach ($keys as $key) {
            //$values[] = ':' . $key;
            $update[] = $key . '=:' . $key;
        }

        //$prepKeys = implode(', ', $keys);
        //$prepValues = implode(', ', $values);
        $prepUpdate = implode(', ', $update);

        //$sql = "INSERT INTO :tablename ($prepKeys) VALUES ($prepValues) ON DUPLICATE KEY UPDATE $prepUpdate;";
        //$sql = "REPLACE INTO :tablename SET $prepUpdate;";
        $sql = "INSERT INTO :tablename SET $prepUpdate ON DUPLICATE KEY UPDATE $prepUpdate;";
        $stmt = $this->db->prepare($sql);

        $entity['tablename'] = $table;

        return $stmt->execute($entity);
    }

    public function remove(string $table, $entity): bool
    {
        if (!is_array($entity)) {
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

    public function find(string $table, $entity)
    {
        if (!is_array($entity)) {
            $sql = "SELECT * FROM :tablename WHERE id=:id";
            $stmt = $this->db->prepare($sql);

            $entity = ['id' => $entity];
            $entity['tablename'] = $table;

            $stmt->execute($entity);

            return $stmt->fetch();
        }

        $prepFields = implode(', ', array_map(function ($val) {
            return $val . '=:' . $val;
        }, array_keys($entity)));

        $sql = "SELECT * FROM :tablename WHERE $prepFields";
        $stmt = $this->db->prepare($sql);

        $entity['tablename'] = $table;

        $stmt->execute($entity);

        return $stmt->fetch();
    }

    public function findAll(string $table, array $options)
    {
        $sql = "SELECT * FROM :tablename";

        if ($options['limit']) {
            $sql .= ' LIMIT = :limit';
            $entity['limit'] = (int) $options['limit'];
        }

        if ($options['offset']) {
            $sql .= ' OFFSET = :offset';
            $entity['offset'] = (int) $options['offset'];
        }

        $stmt = $this->db->prepare($sql);

        $entity['tablename'] = $table;

        $stmt->execute($entity);

        return $stmt->fetch();
    }

    public function createTable(string $table, array $fields): bool
    {
        // TODO: Implement createTable() method.
        return false;
    }
}