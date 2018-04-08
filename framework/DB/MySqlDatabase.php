<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 24.03.18
 * Time: 20:00
 */

namespace Framework\DB;


use PDO;

class MySqlDatabase extends PdoDatabase
{
    protected $db;

    public function __construct(array $options)
    {
        $pdoConfig = 'mysql:';

        $pdoConfig .= 'host=' . ($options['host'] ?: 'localhost') . ';';

        $pdoConfig .= 'dbname=' . ($options['dbname'] ?: 'test') . ';';

        $user = (string) $options['user'] ?? 'root';
        $pass = (string) $options['pass'] ?? '';

        parent::__construct($pdoConfig, $user, $pass);
    }
}