<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 21:29
 */

namespace Framework\DB\Type;


class FloatType extends Type
{
    public function __construct(string $columnName, array $options = [])
    {
        parent::__construct($columnName, $options);

        $types = [
            'REAL',
            'DOUBLE',
            'FLOAT'
        ];

        $this->options['type'] = ($options['type'] && in_array($options['type'], $types)) ? $options['type'] : 'FLOAT';
    }

    public function isValid($field)
    {
        return is_float($field) && ($this->maxLength == 0 || $field < $this->maxLength);
    }

    public function filter($field)
    {
        return (float) $field;
    }
}