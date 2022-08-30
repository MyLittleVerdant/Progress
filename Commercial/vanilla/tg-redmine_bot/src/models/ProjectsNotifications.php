<?php

namespace TgRedmine\models;

use TgRedmine\helpers\Connection;

class ProjectsNotifications
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * Полный список проектов и прикрепленных к ним для оповещения пользователей
     * @return array
     */
    public function all()
    {
        $uniqueProj = [];
        $query = "SELECT projectID,projects.name AS projectName,bot_users.redmine as userID FROM `projects_notifications` INNER JOIN `projects` ON `projectID`=projects.id INNER JOIN `bot_users` ON memberID=bot_users.id ORDER BY projectID; ";
        $data = $this->connection->run($query)->fetchAll();
        foreach ($data as $row) {
            if (array_key_exists($row['projectID'], $uniqueProj)) {
                $uniqueProj[$row['projectID']]['members'][] = $row['userID'];
            } else {
                $uniqueProj[$row['projectID']] = [
                    'name' => $row['projectName'],
                    'members' => [$row['userID']],
                ];
            }
        }
        return $uniqueProj;
    }

    /**
     * Выбор проекта по redmineID и прикрепленных к нему для оповещения пользователей
     * @param $projectID int redmineID
     * @return array
     */
    public function getByProjectID($projectID)
    {
        $uniqueProj = [];
        $query = "SELECT projectID,projects.name AS projectName,bot_users.redmine as userID FROM `projects_notifications` INNER JOIN `bot_users` ON memberID=bot_users.id INNER JOIN `projects` ON `projectID`=projects.id AND `projectID`=" . $projectID;
        $data = $this->connection->run($query)->fetchAll();
        foreach ($data as $row) {
            $uniqueProj[$row['projectID']]['members'][] = $row['userID'];
        }
        $uniqueProj[$row['projectID']]['name'] = $data[0]['projectName'];
        return $uniqueProj;
    }

    /**
     * Выбор пользователя по redmineID и проектов, к которым он прикреплен для оповещения
     * @param $userID int redmineID
     * @return array
     */
    public function getByUserID($userID)
    {
        $uniqueProj = [];
        $query = "SELECT projectID,projects.name AS projectName,bot_users.redmine as userID FROM `projects_notifications` INNER JOIN `projects` ON `projectID`=projects.id INNER JOIN `bot_users` ON memberID=bot_users.id AND bot_users.redmine=" . $userID;
        $data = $this->connection->run($query)->fetchAll();
        foreach ($data as $row) {
            $uniqueProj[$row['projectID']]['members'][] = $row['userID'];
        }
        $uniqueProj[$row['projectID']]['name'] = $data[0]['projectName'];
        return $uniqueProj;
    }
}