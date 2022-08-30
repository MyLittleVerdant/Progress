<?php
namespace TgRedmine\helpers;

use PDO;

class Connection extends Singleton
{
    private $pdo;

    public function __construct($db="redmine")
    {
        $config = Cfg::getInstance();
        $host = $config->get('database.'.$db.'.host');
        $db_name = $config->get('database.'.$db.'.db');
        $db_user = $config->get('database.'.$db.'.user');
        $db_pass = $config->get('database.'.$db.'.pass');
        $this->pdo = new PDO("mysql:host={$host};dbname={$db_name}", $db_user, $db_pass);
    }

    public function run($query, $params = null)
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function groupBy($query, $column, $params = null)
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP);
    }
}