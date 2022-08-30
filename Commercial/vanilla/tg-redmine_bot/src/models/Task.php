<?php
namespace TgRedmine\models;

use TgRedmine\helpers\Connection;
use TgRedmine\helpers\Redmine;

class Task
{
    const STATUS_ONWORK = 2;

    private $redmine;
    private $connection;

    public function __construct()
    {
        $this->redmine = Redmine::getInstance();
        $this->connection = Connection::getInstance();
    }

    private function getTasks($params)
    {
        if (!isset($params['status_id'])) {
            $params['status_id'] = '*';
        }
        $params['limit'] = '1000';
        $result = $this->redmine->getClient()->getApi('issue')->all($params);

        $ids_issues = [];
        $issues = [];
        foreach($result["issues"] as $issue){
            $ids_issues[] = $issue['id'];
            $issues[$issue['id']] = $issue;
        }
        $order_ids = $this->sortByAgile($ids_issues);

        $perfict_issues = [];
        foreach($order_ids as $one_id){
            $perfict_issues[] = $issues[$one_id];
        }

        return $perfict_issues;
    }

    private function getAllTasks($params) {
        $result = $this->redmine->getClient()->getApi('issue')->all($params);
        if ($result['total_count'] > $result['limit']) {
            $params['limit'] = $result['total_count'];
            $result = $this->redmine->getClient()->getApi('issue')->all($params);
        }

        $ids_issues = [];
        $issues = [];
        foreach($result["issues"] as $issue){
            $ids_issues[] = $issue['id'];
            $issues[$issue['id']] = $issue;
        }

        return $issues;
    }

    private function getTask($params)
    {
        $result = $this->redmine->getClient()->getApi('issue')->show($params['issue_id'], $params);
        return $result['issue'];
    }


    private function sortByAgile($taskIds)
    {
        $in_str = implode(", ", $taskIds);
        $query = "SELECT * FROM `agile_data` WHERE `issue_id` IN($in_str) ORDER BY `position`";
        $rows = $this->connection->run($query)->fetchAll();
        $order_ids = [];
        foreach($rows as $row){
            $order_ids[] = $row['issue_id'];
        }
        return $order_ids;
    }

    public function getTasksByStatus($statusId)
    {
        $params = [
            'status_id' => is_array($statusId) ? implode(',', $statusId) : $statusId
        ];

        return $this->getTasks($params);
    }

    public function getTasksByUserId($userId)
    {
        $params = [
            'assigned_to_id' => $userId,
        ];

        return $this->getTasks($params);
    }

    public function getTasksByUserAndStatusId($userId, $statusId)
    {
        $params = [
            'assigned_to_id' => $userId,
            'status_id' => $statusId,
        ];

        return $this->getTasks($params);
    }

    public function getTasksByUserIdAndStartTime($userId, $time)
    {
        $params = [
            'assigned_to_id' => $userId,
            'cf_1' => date('H:i', strtotime($time)), //custom field передаются как cf_x, где x - ID поля
            'start_date' => date('Y-m-d', strtotime($time))
        ];

        return $this->getTasks($params);
    }

    public function getStartTasks()
    {
        $params = [
            'start_date' => '>=' . date('Y-m-d'),
        ];
        var_dump($params);
        return $this->getTasks($params);
    }

    public function getTaskById($taskId)
    {
        $params = [
            'issue_id' => is_array($taskId) ? implode(',',  $taskId) :  $taskId,
        ];

        return $this->getTasks($params);
    }

    public function getTaskWithJournals($taskId)
    {
        $issues = [];
        if (is_array($taskId)) {
            foreach($taskId as $id) {
                $params = [
                    'issue_id' => $id,
                    'include' => 'journals'
                ];
                $issues[] = $this->getTask($params);
            }
        } else {
            $params = [
                'issue_id' => $taskId,
                'include' => 'journals'
            ];
            $issues[] = $this->getTask($params);
        }

        return $issues;
    }

    public function getExpiredTasks($user_id)
    {
        $query = "SELECT * FROM `issues` INNER JOIN `custom_values` ON `custom_values`.customized_id = `issues`.id AND `custom_values`.custom_field_id = 5 AND `custom_values`.value = 0 WHERE `status_id` != 5 AND `estimated_hours` IS NOT NULL AND `assigned_to_id` = {$user_id} ORDER BY `created_on`";
        $rows = $this->connection->run($query)->fetchAll();
        $task_id = [];
        foreach($rows as $row) {
            $task_id[] = $row[0];
        }
        $tasks = [];
        foreach($task_id as $id) {
            $params = [
                'issue_id' => $id,
            ];
            $tasks[] = $this->getTask($params);
        }
        return $tasks;
    }

    public function setTimeLimitNotify($id, $notify = 1)
    {
        $query = "UPDATE `custom_values` SET `value`='$notify' WHERE `customized_id`='$id' AND `customized_type`='Issue' AND `custom_field_id`='5'";
        $rows = $this->connection->run($query)->fetchAll();
        return $rows[0];
    }

    public function getBacklogsTasks()
    {
        $params = [
            'project_id' => 101
        ];

        return $this->getAllTasks($params);
    }
}