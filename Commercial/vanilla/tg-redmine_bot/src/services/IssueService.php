<?php

namespace TgRedmine\services;

use TgRedmine\models\Issue;


class IssueService
{
    private static $closedStatusIDs = [5, 6];

    /**
     * @param $authorID int redmineID автора
     * @param $daysBeforeDeadline  int кол-во дней до дедлайна, false для всех задач
     * @return array
     */
    public static function getTasksDeadlinesByAuthor($authorID, $daysBeforeDeadline = false)
    {
        $issue = new Issue();
        $issues = $issue->getIssuesByAuthor($authorID);
        $expiredTasks = [];
        foreach ($issues as $key => $issueItem) {
            if (!empty($issueItem["due_date"]) && !in_array($issueItem["status"]['id'], self::$closedStatusIDs)) {

                //Задано кол-во дней до дедлайна
                if ($daysBeforeDeadline !== false) {
                    $deadline = strtotime($issueItem["due_date"]);
                    $compareWith = strtotime('+' . $daysBeforeDeadline . " day");
                    $diff = $compareWith - $deadline;
                    $daysInSeconds = $daysBeforeDeadline * 86400;
                    //Дедлайн сегодня
                    if ($daysInSeconds === 0) {
                        if ($compareWith >= $deadline) {
                            $expiredTasks[$key] = $issueItem;
                        }
                    } else {
                        if ($compareWith >= $deadline && $diff <= $daysInSeconds) {
                            $expiredTasks[$key] = $issueItem;
                        }
                    }
                // Все дедлайны
                } else {
                    $expiredTasks[$key] = $issueItem;
                }

            }
        }
        return $expiredTasks;
    }

}