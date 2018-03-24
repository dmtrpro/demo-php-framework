<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 20:05
 */

namespace Framework\DB;


use Framework\DB\Type\Type;

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

    public function find($id): object
    {
        $fields = $this->db->find($id, $this->getTableName());

        return $this->createFromDbArray($fields);
    }

    public function save(object $entity)
    {
        return $this->db->save($this->map($entity), $this->getTableName());
    }

    public function remove(object $entity)
    {
        return $this->db->remove($this->map($entity), $this->getTableName());
    }

    /**
     * @param object $entity
     * @return array
     */
    protected static function map(object $entity): array
    {
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