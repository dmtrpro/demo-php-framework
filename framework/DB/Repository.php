<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 20:05
 */

namespace Framework\DB;


use Framework\DB\Type\Type;

/**
 * Class Repository
 * todo: Work at Progress. Not ready for use.
 *
 * @package Framework\DB
 */
abstract class Repository
{
    /**
     * @var Database
     */
    protected $db;

    const CLASS_NAME = '\stdClass';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Returns table name as a string
     *
     * @return string
     */
    abstract public static function getTableName(): string;

    /**
     * Returns associative array of entity properties as keys and DB\Type instances as values
     *
     * @return Type[]
     */
    abstract public static function getMap(): array;

    public function findAll($options = []): array
    {
        $rows = $this->db->findAll($this->getTableName(), $options);

        $result = [];

        foreach ($rows as $row) {
            $result[] = $this->createFromDbArray($row);
        }

        return $result;
    }

    public function find($entity): object
    {
        $fields = $this->db->find($this->getTableName(), $this->map($entity));

        return $this->createFromDbArray($fields);
    }

    public function save(object $entity)
    {
        return $this->db->save($this->getTableName(), $this->map($entity));
    }

    public function remove($entity)
    {
        return $this->db->remove($this->getTableName(), $this->map($entity));
    }

    /**
     * @param object|int $entity
     * @return mixed
     */
    protected function map($entity)
    {
        if(!is_object($entity)) {
            return $entity;
        }

        $result = [];

        foreach (self::getMap() as $key => $value) {
            if (isset($entity->$key)) {
                $result[] = [$value->getName() => $entity->$key];
            }
        }

        return $result;
    }

    protected function createFromDbArray(array $fields): object
    {
        $object = new (static::CLASS_NAME)();

        foreach (self::getMap() as $key => $value) {
            if (isset($fields[$value->getName()])) {
                $setter = 'set' . ucfirst($key);

                if (\method_exists($object, $setter)) {
                    $object->$setter = $fields[$value->getName()];
                } elseif (\property_exists($object, $key)) {
                    $object->$key = $fields[$value->getName()];
                }
            }
        }

        return $object;
    }

    public function createFromArray(array $fields): object
    {
        $object = new (static::CLASS_NAME)();

        foreach ($fields as $key => $value) {
            $setter = 'set' . ucfirst($key);

            if (\method_exists($object, $setter)) {
                $object->$setter = $value;
            } elseif (\property_exists($object, $key)) {
                $object->$key = $value;
            }
        }

        return $object;
    }
}