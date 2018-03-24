<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 21:29
 */

namespace Framework\DB\Type;


class BooleanType extends Type
{
    public function __construct(string $columnName, array $options = [])
    {
        parent::__construct($columnName, $options);

        if($options['type'] === 'TINYINT') {
            $this->options['type'] = 'TINYINT';
            $this->maxLength = 1;
            $this->options['unsigned'] = true;
        } else {
            $this->options['type'] = 'BOOLEAN';
        }
    }

    public function isValid($field)
    {
        return is_bool($field);
    }

    public function filter($field)
    {
        return (bool) $field;
    }
}