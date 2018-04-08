<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 21:45
 */

namespace App\Repository;


use Framework\DB\Repository;
use Framework\DB\Type\IntegerType;
use Framework\DB\Type\StringType;
use Framework\DB\Type\Type;

class ProductRepository
{
    /**
     * Returns table name as a string
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'demo_shop_products';
    }

    /**
     * Returns associative array of entity properties as keys and DB\Type instances as values
     *
     * @return Type[]
     */
    public static function getMap(): array
    {
        return [
            'id' => new IntegerType('id', [
                'primary' => true
            ]),
            'productId' => new StringType('product_id'),
            'title' => new StringType('title'),
            'slug' => new StringType('slug'),
            'price' => new IntegerType('price'),
            'excerpt' => new StringType('excerpt'),
            'content' => new StringType('content'),
            'thumb' => new StringType('thumb'),
            'image' => new StringType('image'),
            //'chars' => new OneToManyType('product_id'),
        ];
    }
}