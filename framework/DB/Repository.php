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
     * todo: Сделать через аннотации к классу с помощью ReflectionClass::getDocComment
     *
     * @return string
     */
    abstract public static function getTableName(): string;

    /**
     * Returns associative array of entity properties as keys and DB\Type instances as values
     * todo: Сделать через аннотации к параметрам с помощью ReflectionProperty::getDocComment ?
     *
     * @return Type[]
     */
    abstract public static function getDbMap(): array;

    protected static function getMappedObject($dbResult)
    {
        if (!is_array($dbResult)) {
            throw new \InvalidArgumentException();
        }

        return static::create();
        /// todo: Сделать через аннотации к параметрам с помощью ReflectionProperty::getDocComment
    }

    /**
     * @param $object
     * @return array
     */
    protected static function objectToArray($object): array
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException();
        }

        $dbArray = [];

        foreach ((new \ReflectionObject($object))->getProperties() as $property) {
            $property->setAccessible(true);
            if($value = $property->getValue()) {
                //$this->parseDbAnnotations($property->getDocComment());
                $dbArray[static::getDbMap()[$property->getName()]->getName()] = $value;
            }
        }

        return $dbArray;
    }

//    public function findAll($options = []): array
//    {
//        $rows = $this->db->findAll($this->getTableName(), $options);
//
//        $result = [];
//
//        foreach ($rows as $row) {
//            $result[] = $this->createFromDbArray($row);
//        }
//
//        return $result;
//    }

    /**
     * @param array $options
     * @return array
     */
    public function findAll($options = []): array
    {
        return array_map([static::class, 'getMappedObject'],
            $this->db->findAll(static::getTableName(), $options)
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return static::getMappedObject(
            $this->db->find(static::getTableName(), ['id' => $id])
        );
    }


    public function find($entity)
    {
        $fields = $this->db->find($this->getTableName(), $this->map($entity));

        return $this->createFromDbArray($fields);
    }

    /**
     * @param $entity
     * @return bool
     */
    public function save($entity): bool
    {
        return $this->db->save(static::getTableName(), static::objectToArray($entity));
    }

    /**
     * @param $entity
     * @return bool
     */
    public function delete($entity): bool
    {
        return $this->db->save(static::getTableName(), static::objectToArray($entity));
    }

//    /**
//     * @param object|int $entity
//     * @return mixed
//     */
//    protected function map($entity)
//    {
//        if(!is_object($entity)) {
//            return $entity;
//        }
//
//        $result = [];
//
//        foreach (self::getMap() as $key => $value) {
//            if (isset($entity->$key)) {
//                $result[] = [$value->getName() => $entity->$key];
//            }
//        }
//
//        return $result;
//    }

//    protected function createFromDbArray(array $fields): object
//    {
//        $object = new (static::CLASS_NAME)();
//
//        foreach (self::getMap() as $key => $value) {
//            if (isset($fields[$value->getName()])) {
//                $setter = 'set' . ucfirst($key);
//
//                if (\method_exists($object, $setter)) {
//                    $object->$setter = $fields[$value->getName()];
//                } elseif (\property_exists($object, $key)) {
//                    $object->$key = $fields[$value->getName()];
//                }
//            }
//        }
//
//        return $object;
//    }
//
//    public function createFromArray(array $fields): object
//    {
//        $object = new (static::CLASS_NAME)();
//
//        foreach ($fields as $key => $value) {
//            $setter = 'set' . ucfirst($key);
//
//            if (\method_exists($object, $setter)) {
//                $object->$setter = $value;
//            } elseif (\property_exists($object, $key)) {
//                $object->$key = $value;
//            }
//        }
//
//        return $object;
//    }

    abstract public static function create();

    /**
     * @return bool
     */
    public function createTable(): bool
    {
        return $this->db->createTable(static::getTableName(), static::getDbMap());
    }
}