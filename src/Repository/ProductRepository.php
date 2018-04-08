<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 21:45
 */

namespace App\Repository;


use App\Entity\Product;
use Framework\DB\Database;
use Framework\DB\Type\IntegerType;
use Framework\DB\Type\StringType;
use Framework\DB\Type\Type;

class ProductRepository
{
    /**
     * @var Database
     */
    protected $db;

    /**
     * ProductRepository constructor.
     * @param Database $db
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Returns table name as a string
     * todo: Сделать через аннотации к классу с помощью ReflectionClass::getDocComment ?
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'demo_shop_products';
    }

    /**
     * Returns associative array of entity properties as keys and DB\Type instances as values
     * todo: Сделать через аннотации к параметрам с помощью ReflectionProperty::getDocComment ?
     *
     * @return Type[]
     */
    public static function getDbMap(): array
    {
        return [
            'id' => new IntegerType('id', [
                'primary' => true
            ]),
            'productUid' => new StringType('product_uid'),
            'title' => new StringType('title'),
            'slug' => new StringType('slug'),
            'price' => new IntegerType('price'),
            'excerpt' => new StringType('excerpt'),
            'content' => new StringType('content'),
            'thumb' => new StringType('thumb'),
            'image' => new StringType('image'),
            'quantity' => new StringType('quantity'),
            //'chars' => new OneToManyType('product_id'),
        ];
    }

    /**
     * @param $dbResult
     * @return Product
     */
    protected static function getMappedObject($dbResult): Product
    {
        if (!is_array($dbResult)) {
            throw new \InvalidArgumentException();
        }

        return (new Product())
            ->setId($dbResult['id'])
            ->setProductUid($dbResult['product_uid'])
            ->setTitle($dbResult['title'])
            ->setSlug($dbResult['slug'])
            ->setPrice($dbResult['price'])
            ->setExcerpt($dbResult['excerpt'])
            ->setContent($dbResult['content'])
            ->setThumb($dbResult['thumb'])
            ->setImage($dbResult['image'])
            ->setQuantity($dbResult['quantity']);
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
     * @return Product
     */
    public function findById($id): Product
    {
        return static::getMappedObject(
            $this->db->find(static::getTableName(), ['id' => $id])
        );
    }

    /**
     * @param Product $entity
     * @return Product
     */
    public function find(Product $entity): Product
    {
        if ($id = $entity->getId()) {
            return static::getMappedObject(
                $this->db->find(static::getTableName(), ['id' => $id])
            );
        }

        return static::getMappedObject(
            $this->db->find(static::getTableName(), static::objectToArray($entity))
        );
    }

    /**
     * @param Product $entity
     * @return bool
     */
    public function save(Product $entity): bool
    {
        return $this->db->save(static::getTableName(), static::objectToArray($entity));
    }

    /**
     * @param Product $entity
     * @return bool
     */
    public function delete(Product $entity): bool
    {
        return $this->db->save(static::getTableName(), static::objectToArray($entity));
    }

    /**
     * @return Product
     */
    public function create(): Product
    {
        return new Product();
    }

    /**
     * @return bool
     */
    public function createTable(): bool
    {
        return $this->db->createTable(static::getTableName(), static::getDbMap());
    }
}