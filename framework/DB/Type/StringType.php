<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 21:29
 */

namespace Framework\DB\Type;


class StringType extends Type
{
    public function __construct(string $columnName, array $options = [])
    {
        parent::__construct($columnName, $options);

        $types = [
            'CHARACTER',
            'VARCHAR',
            'VARYING CHARACTER',
            'TEXT',
        ];

        $this->options['type'] = ($options['type'] && in_array($options['type'], $types)) ? $options['type'] : 'VARCHAR';
    }

    public function isValid($field)
    {
        return is_string($field) && ($this->maxLength == 0 || mb_strlen($field) < $this->maxLength);
    }

    public function filter($field)
    {
        return (string) $field;
    }
}