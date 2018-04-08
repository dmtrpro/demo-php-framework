<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 20:00
 */

namespace Framework\DB;


use PDO;

class SqLiteDatabase extends PdoDatabase
{
    protected $db;

    public function __construct(array $options)
    {
        $pdoConfig = 'sqlite:';

        $pdoConfig .= DATA_DIR.DIRECTORY_SEPARATOR.($options['file'] ?: 'db.sqlite');

        parent::__construct($pdoConfig);
    }
}