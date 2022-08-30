<?php
namespace TgRedmine\services;

use TgRedmine\models\Timer;
use TgRedmine\models\Issue;
use TgRedmine\models\User;

class TimerService
{
    public static function sumTimerPerDayByUserId($userId, $date = '')
    {
        if ($date == '') {
            $date = date('Y-m-d');
        }

        $issues = (new Issue())->issues();
        $timer = new Timer();
        $timers = $timer->getTimerPerDayByUserId($userId, $date);
        $sum = 0;
        $result = [];
        foreach($timers['time_entries'] as $time_entry) {
            $sum += $time_entry['hours'];
            if (isset($issues[$time_entry['issue']['id']])) {
                $result[$time_entry['issue']['id']] = $issues[$time_entry['issue']['id']]['project'] . ' - ' . $issues[$time_entry['issue']['id']]['name'];
            }
        }

        $activeTimer = $timer->getActiveTimerByUserId($userId);
        if ($activeTimer) {
            $currentTime = new \DateTime();
            $startActiveTimer = new \DateTime($activeTimer['started_on']);
            $hoursActiveTimer = $startActiveTimer->diff($currentTime);
            $parseHoursActiveTimer = floatval($hoursActiveTimer->h . '.' . intval($hoursActiveTimer->i / 60 * 100)) + $activeTimer['time_spent'];
            $sum += $parseHoursActiveTimer;
        }
        $result['sum'] = $sum;
        return $result;
    }

    public static function taskTimerPerDay($userId, $date)
    {
        $tasks = [];
        $timer = new Timer();
        $timers = $timer->getTimerPerDayByUserId($userId, $date);
        foreach($timers['time_entries'] as $t) {
            if (!in_array($t['issue']['id'], $tasks)) {
                $tasks[] = $t['issue']['id'];
            }
        }
        if (date('Y-m-d') == $date) {
            $activeTimer = $timer->getActiveTimerByUserId($userId);
            if ($activeTimer) {
                if (!in_array($activeTimer['issue_id'], $tasks)) {
                    $tasks[] = $activeTimer['issue_id'];
                }
            }
        }
        
        
        return $tasks;
    }

    public static function checkActiveTimerByUserId($userId)
    {
        $timer = new Timer();
        return !!$timer->getActiveTimerByUserId($userId);
    }

    public static function checkLastActiveTimer($userId)
    {
        $timer = new Timer();

        $activeTimer = $timer->getActiveTimerByUserId($userId);
        if ($activeTimer) {
            return false;
        }

        $lastTimer = $timer->getLastTimerByUserId($userId);
        if (!$lastTimer) {
            return false;
        }

        $lastTimerCreated = new \DateTime($lastTimer['created_on']);
        $currentTime = new \DateTIme();
        $diffTime = $currentTime->diff($lastTimerCreated);
        return $diffTime->h * 60 + $diffTime->i + $activeTimer['time_spent'];
    }

    public static function getActiveTimerByUserId($userId)
    {
        return (new Timer())->getActiveTimerByUserId($userId);
    }

    public static function getAllActiveTimers()
    {
        $users = (new User())->getAllUsersFromRedmine();
        $users = array_combine(array_column($users, 'id'), $users);
        $timer = new Timer();
        $timers = $timer->getActiveTimers();
        $issues_id = array_column($timers, 'issue_id');
        $issues = (new Issue())->issuesById($issues_id);

        $result = [];
        foreach($timers as $time_entry) {
            if (isset($issues[$time_entry['issue_id']])) {
                $currentTime = new \DateTime();
                $startActiveTimer = new \DateTime($time_entry['started_on']);
                $hoursActiveTimer = $startActiveTimer->diff($currentTime);
                $parseHoursActiveTimer = floatval($hoursActiveTimer->h + round($hoursActiveTimer->i / 60,
                            2)) + $time_entry['time_spent'];
                $result[] = [
                    'task_name' => $issues[$time_entry['issue_id']]['project'] . ' - ' . $issues[$time_entry['issue_id']]['name'],
                    'user' => [
                        'id' => $users[$time_entry['user_id']]['id'],
                        'name' => $users[$time_entry['user_id']]['firstname'] . ' '  . $users[$time_entry['user_id']]['lastname'],
                    ],
                    'time' => $parseHoursActiveTimer
                ];
            }
        }

        return $result;
    }


}