<?php

namespace TgRedmine\models;

use TgRedmine\helpers\Connection;

class SiteFall
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function all()
    {
        $query = "SELECT * FROM `bot_site_work_stats`";
        return $this->connection->run($query)->fetchAll();
    }

    public function falls()
    {
        $query = "SELECT * FROM `bot_site_work_stats` WHERE `current_status`=0";
        return $this->connection->run($query)->fetchAll();
    }

    public function getLastFall()
    {
        $query = "SELECT * FROM `bot_site_work_stats` ORDER BY `last_fall` DESC LIMIT 1 ";
        return $this->connection->run($query)->fetchAll();
    }

    public function update($data)
    {
        $url = $data['url'];
        $current_status = $data['status'];
        if ($current_status) {
            $query = "UPDATE `bot_site_work_stats` SET `current_status`='$current_status' WHERE `url`='$url'";
        } else {
            $last_fall = date('Y-m-d H:i:s');
            $query = "UPDATE `bot_site_work_stats` SET `last_fall`='$last_fall', `current_status`='$current_status' WHERE `url`='$url'";
        }

        $rows = $this->connection->run($query)->fetchAll();
        return $rows;
    }

    /**
     * Устанавливает даты оплаты домена и SSL
     * @param $data
     * @return array|false
     */
    public function setSSLnHosting($data)
    {
        $url = $data['url'];
        $query = "UPDATE `bot_site_work_stats` SET `hosting_date`='" . $data['hosting'] . "', `ssl_date`='" . $data['ssl'] . "' WHERE `url`='$url'";
        $rows = $this->connection->run($query)->fetchAll();
        return $rows;
    }


}