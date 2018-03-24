<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 21:29
 */

namespace Framework\DB\Type;


class Type
{
    /**
     * @var string
     */
    protected $columnName;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var integer
     */
    protected $maxLength = 0;

    public function __construct(string $columnName, array $options = [])
    {
        $this->columnName = $columnName;

        $this->options['primary'] = (bool)$options['primary'];
        $this->options['autoincrement'] = (bool)$options['autoincrement'];
        $this->options['required'] = (bool)$options['required'];
        $this->options['nullable'] = (bool)$options['nullable'];
        $this->options['unsigned'] = (bool)$options['unsigned'];
        $this->options['default'] = isset($options['default']) ? $options['default'] : null;

        if ($options['max']) {
            $this->maxLength = (int)$options['max'];
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->columnName;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        $result = $this->options['type'] ?: 'VARCHAR';

        if ($this->maxLength) {
            $result .= ' (' . $this->maxLength . ')';
        }

        if ($this->options['unsigned']) {
            $result .= ' UNSIGNED';
        }

        if ($this->options['primary']) {
            $result .= ' PRIMARY KEY AUTO_INCREMENT';
        } elseif ($this->options['autoincrement']) {
            $result .= ' AUTO_INCREMENT';
        }

        if ($this->options['required']) {
            $result .= ' NOT NULL';
        } elseif ($this->options['nullable']) {
            $result .= ' NULL';
        }

        if ($this->options['default'] !== null) {
            $result .= ' DEFAULT ' . $this->options['default'];
        }

        return $result;
    }

    public function isValid($field)
    {
        return true;
    }

    public function filter($field)
    {
        return $field;
    }
}