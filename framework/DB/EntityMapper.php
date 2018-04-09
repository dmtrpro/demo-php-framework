<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 09.04.18
 * Time: 2:51
 */

namespace Framework\DB;


use Framework\DB\Type\Type;

class EntityMapper
{
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
            if ($value = $property->getValue()) {
                $dbArray[] = static::createDbTypeFromProperty($property);;
            }
        }

        return $dbArray;
    }

    /**
     * todo: move logic to DbTypeBuilder class
     * @param \ReflectionProperty $property
     * @return Type
     */
    public static function createDbTypeFromProperty(\ReflectionProperty $property): Type
    {
        $property->setAccessible(true);

        $annotations = static::parseAnnotations($property->getDocComment());

        $columnName = $annotations['DB\ColumnName'] ?: $property->getName();

        $dbType = new Type($columnName);

        if ($type = $annotations['DB\ColumnName'] ?: $annotations['var']) {
            //$dbType->setType($type);
        }

        if ($options = $annotations['DB\ColumnOptions']) {
            //$options = explode("/[\s,]+/", $options);
            $options = explode(' ', $options);
            //$dbType->setOptions($options);
        }

        if ($value = $property->getValue()) {
            //$dbType->setValue($value);
        }

        return $dbType;
    }

    public static function parseAnnotations(string $docBlock): array
    {
        preg_match_all("/@([\w\\]+)\s+([\w\s\\]*)/", $docBlock, $pregResult, PREG_SET_ORDER);

        $result = [];

        //todo: Нужно ли объединять в массив однотипные значения?
        foreach ($pregResult as $annotation) {
            $result[$annotation[1]] = $annotation[2];
        }

        return $result;
    }
}