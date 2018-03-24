<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 21:29
 */

namespace Framework\DB\Type;


class TextType extends Type
{
    public function __construct(string $columnName, array $options = [])
    {
        parent::__construct($columnName, $options);

        $this->options['type'] = 'TEXT';
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