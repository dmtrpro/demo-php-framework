<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 21:29
 */

namespace Framework\DB\Type;


class DateType extends Type
{
    public function __construct(string $columnName, array $options = [])
    {
        parent::__construct($columnName, $options);

        $types = [
            'DATE',
            'DATETIME',
        ];

        $this->options['type'] = ($options['type'] && in_array($options['type'], $types)) ? $options['type'] : 'DATETIME';
    }
}