<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 20:00
 */

namespace Framework\DB;


use PDO;

class SqLiteDatabase extends MySqlDatabase
{
    protected $db;

    public function __construct(array $options)
    {
        $pdoConfig = 'sqlite:';

        $pdoConfig .= DATA_DIR.($options['file'] ?: 'db.sqlite');

        $this->db = new PDO($pdoConfig);

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}