<?php

namespace TgRedmine\models;

use TgRedmine\helpers\Connection;
use TgRedmine\helpers\Redmine;

class User
{
    private $connection;

    public function getAllUsersFromRedmine()
    {

        $redmine = Redmine::getInstance()->getClient();
        $response = $redmine->getApi('user')->all();
        $users = $response['users'];
        uasort($users, function ($a, $b) {
            if ($a['id'] == $b['id']) {
                return 0;
            }
            return $a['id'] > $b['id'] ? 1 : -1;
        });

        return $users;
    }

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function all()
    {
        $query = "SELECT * FROM `bot_users`";
        return $this->connection->run($query)->fetchAll();
    }

    public function getObservers()
    {
        $query = "SELECT * FROM `bot_users` WHERE `observer`=1";
        return $this->connection->run($query)->fetchAll();
    }

    public function getGlobalWatchers()
    {
        $query = "SELECT * FROM `bot_users` WHERE `global_watcher`=1";
        return $this->connection->run($query)->fetchAll();
    }

    public function getByRedID($redmineID)
    {
        $query = "SELECT * FROM `bot_users` WHERE `redmine`=" . $redmineID;
        return $this->connection->run($query)->fetchAll();
    }

    public function getByTelegramID($telegramID)
    {
        $query = "SELECT * FROM `bot_users` WHERE `telegram`=" . $telegramID;
        return $this->connection->run($query)->fetchAll();
    }

    public function getByName($name)
    {
        $query = "SELECT * FROM `bot_users` WHERE `name`='" . $name."'";
        return $this->connection->run($query)->fetchAll();
    }

    public function getByEmail($email)
    {
        $query = "SELECT * FROM `bot_users` WHERE `email`=" . $email;
        return $this->connection->run($query)->fetchAll();
    }

    public function getAdmins()
    {
        $query = "SELECT * FROM `bot_users` WHERE `admin`=1";
        return $this->connection->run($query)->fetchAll();
    }

    public function getSpecialtis()
    {
        $query = "SELECT DISTINCT `specialty` FROM `bot_users` ";
        return $this->connection->run($query)->fetchAll();
    }

}