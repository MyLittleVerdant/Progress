<?php

namespace TgRedmine\services;

use TgRedmine\helpers\Telegram;
use TgRedmine\models\Timer;
use TgRedmine\models\Issue;
use TgRedmine\models\Project;
use TgRedmine\models\User;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportService
{
    public static function hoursByTaskReport()
    {
        $users = UserService::getAllUser();
        $timer = new Timer();
        $report = [];

        foreach ($users as $user) {
            if ($user['admin'] || $user['observer']) {
                continue;
            }
            $dayTimer = $timer->getTimerPerDayByUserId($user['redmine']);
            $userReport = [];
            $activeIssue = null;
            foreach ($dayTimer['time_entries'] as $time) {
                if (!isset($userReport[$time['issue']['id']])) {
                    $userReport[$time['issue']['id']] = $time['hours'];
                } else {
                    $userReport[$time['issue']['id']] += $time['hours'];
                }
            }
            $activeTimer = $timer->getActiveTimerByUserId($user['redmine']);
            if ($activeTimer) {
                $currentTime = new \DateTime();
                $startActiveTimer = new \DateTime($activeTimer['started_on']);
                $hoursActiveTimer = $startActiveTimer->diff($currentTime);
                $parseHoursActiveTimer = round(floatval($hoursActiveTimer->h . '.' . intval($hoursActiveTimer->i / 60 * 100)) + $activeTimer['time_spent'],
                    2);
                if (!isset($userReport[$activeTimer['issue_id']])) {
                    $userReport[$activeTimer['issue_id']] = $parseHoursActiveTimer;
                } else {
                    $userReport[$activeTimer['issue_id']] += $parseHoursActiveTimer;
                }

                $activeIssue = $activeTimer['issue_id'];
            }
            $report[$user['redmine']] = [
                'user' => $user,
                'report' => $userReport,
                'activeIssue' => $activeIssue
            ];
        }

        return $report;
    }

    public function weekHoursReport()
    {
        $timer = new Timer();
        $report = [];
        $startDate = strtotime('last monday');
        $projects = (new Project())->all();
        foreach ($projects as $projectId => $projectName) {
            if (!empty($projectName['parent'])) {
                continue;
            }
            $date = $startDate;
            while ($date <= time()) {
                $dayTimer = $timer->getTimerByProjectIdAndDate($projectId, date('Y-m-d', $date));
                foreach ($dayTimer['time_entries'] as $time) {
                    if (!isset($report[$time["project"]['id']])) {
                        $report[$time["project"]['id']] = $time['hours'];
                    } else {
                        $report[$time["project"]['id']] += $time['hours'];
                    }
                }
                $date += 86400;
            }
        }
        arsort($report);
        return $report;
    }

    public function renderWeekReport($report)
    {
        $projects = (new Project())->all();
        $message = "<b>Хей, парень</b>\nПосмотрим что за неделю ребята напилили:\n";
        $sum = 0;
        $url = 'utf8=%E2%9C%93&f%5B%5D=spent_on&op%5Bspent_on%5D=%3E%3C&v%5Bspent_on%5D%5B%5D=' . date('Y-m-d',
                strtotime('last monday')) . '&v%5Bspent_on%5D%5B%5D=' . date('Y-m-d') . '&f%5B%5D=project_id&op%5Bproject_id%5D=%3D&v%5Bproject_id%5D%5B%5D=';
        foreach ($report as $projectId => $hour) {
            $message .= '<a href="https://red.mega-dev.ru/time_entries?' . $url . $projectId . '">' . $projects[$projectId]['name'] . '</a> - ' . $hour . " ч\n";
            $sum += $hour;
        }
        $message .= "<u><a href='https://red.mega-dev.ru/time_entries?utf8=%E2%9C%93&f%5B%5D=spent_on&op%5Bspent_on%5D=%3E%3C&v%5Bspent_on%5D%5B%5D=" . date('Y-m-d',
                strtotime('last monday')) . "&v%5Bspent_on%5D%5B%5D=" . date('Y-m-d') . "'>Всего:</a> $sum ч</u>\n\n";
        return $message;
    }

    public static function renderDayReport($report)
    {
        $issue = new Issue();
        $issues = $issue->issues();
        $message = "<b>Хей, парень</b>\nПосмотрим что за сегодня ребята напилили:\n";
        foreach ($report as $r) {
            $message .= '<b>' . $r['user']['name'] . "</b>\n";
            $sum = 0;
            foreach ($r['report'] as $issue_id => $time) {
                $issue = $issues[$issue_id];
                if ($r['activeIssue'] == $issue_id) {
                    $message .= '<b><a href="http://red.mega-dev.ru/issues/' . $issue_id . '">№' . $issue_id . '</a> ' . $issue['name'] . '. ' . $issue['project'] . ' - ' . $time . " ч (В РАБОТЕ)\n</b>";
                } else {
                $message .= '<a href="http://red.mega-dev.ru/issues/' . $issue_id . '">№' . $issue_id . '</a> ' . $issue['name'] . '. ' . $issue['project'] . ' - ' . $time . " ч\n";
                }

                $sum += $time;
            }
            $message .= "<u>Всего: $sum ч</u>\n\n";
        }

        return $message;
    }

    public static function periodReport(
        $from,
        $to,
        $fusion = false,
        $selectedProjects = [],
        $selectedSpecs = [],
        $selectedUsers = []
    ) {
        $timer = new Timer();
        $report = [];
        $uniqueIDs = [];
        $projects = (new Project())->all();
        $issues = (new Issue())->issues();
        $timeEntryFact = 0;
        $timeEntryUseful = 0;
        $dontAdd = false;
        krsort($projects);
        $usersWithSelectedSpecList = [];
        $users = UserService::getAllUser();
        $users = array_combine(array_column($users, 'redmine'), $users);

        if (count($selectedSpecs) > 0) {
            foreach ($users as $user) {
                if (in_array($user['specialty'], $selectedSpecs)) {
                    $usersWithSelectedSpecList[] = $user['redmine'];
                }
            }

        }

        foreach ($projects as $projectId => $project) {

            $projectTimeEntryFact = 0;
            $projectTimeEntryUseful = 0;
            $projectRows = [];
            $addedEstimatedHours = [];

            if (count($selectedProjects) == 0 || $selectedProjects[0] == 'all' || in_array($projects[$projectId]['identifier'],
                    $selectedProjects)) {
                $timers = $timer->getTimerByProjectBetweenDates($projectId, $from, $to);
                foreach ($timers['time_entries'] as $timeEntry) {
                    $dontAdd = false;
                    if (count($selectedUsers) > 0 && !in_array($timeEntry['user']['id'], $selectedUsers)) {
                        continue;
                    }
                    if (!empty($usersWithSelectedSpecList) && !in_array($timeEntry['user']['id'],
                            $usersWithSelectedSpecList)) {
                        continue;
                    }
                    $cof = $issues[$timeEntry['issue']['id']]['cof'] ?: 1;
                    $issueUserId = $projectId . '_' . $timeEntry['issue']['id'] . '_' . $timeEntry['user']['id'];
                    $estimatedHours = $issues[$timeEntry['issue']['id']]['estimated_hours'];
                    $useful_hours = 0;

                    if (!empty($uniqueIDs[$timeEntry['issue']['id']]) && $uniqueIDs[$timeEntry['issue']['id']] != $projectId) {
                        $dontAdd = true;
                    } else {
                        $dontAdd = false;
                    }

                    if ($estimatedHours !== false && !in_array($timeEntry['issue']['id'], $addedEstimatedHours)) {
                        $useful_hours = $estimatedHours;
                    } elseif ($estimatedHours === false) {
                        $useful_hours = $timeEntry['hours'] * $cof;
                    }

                    if (!$dontAdd) {
                        $uniqueIDs[$timeEntry['issue']['id']] = $projectId;

                        if ($timeEntry['comments'] == '') {
                            if ($fusion) {
                                if (isset($projectRows[$issueUserId])) {
                                    $projectRows[$issueUserId][5] += $timeEntry['hours'];
                                    if ($estimatedHours !== false && !in_array($timeEntry['issue']['id'],
                                            $addedEstimatedHours)) {
                                        $projectRows[$issueUserId][8] = 'Фикс';
                                        $projectRows[$issueUserId][6] = $useful_hours;
                                    } elseif ($estimatedHours === false) {
                                        $projectRows[$issueUserId][8] = $cof;
                                        $projectRows[$issueUserId][6] += $useful_hours;
                                    }
                                } else {
                                    $projectRows[$issueUserId] = [
                                        $projects[$projectId]['name'],
                                        $issues[$timeEntry['issue']['id']]['name'],
                                        'http://red.mega-dev.ru/issues/' . $timeEntry['issue']['id'],
                                        $timeEntry['user']['name'],
                                        $users[$timeEntry['user']['id']]['specialty'],
                                        $timeEntry['hours'],
                                        $useful_hours,
                                        $timeEntry['comments'],
                                        $estimatedHours !== false ? 'Фикс' : $cof,
                                    ];
                                }
                            } else {
                                $projectRows[$issueUserId . '_' . uniqid()] = [
                                    $projects[$projectId]['name'],
                                    $issues[$timeEntry['issue']['id']]['name'],
                                    'http://red.mega-dev.ru/issues/' . $timeEntry['issue']['id'],
                                    $timeEntry['user']['name'],
                                    $users[$timeEntry['user']['id']]['specialty'],
                                    $timeEntry['hours'],
                                    $useful_hours,
                                    $timeEntry['comments'],
                                    $estimatedHours !== false ? 'Фикс' : $cof,
                                ];
                            }

                        } else {
                            $projectRows[$issueUserId . '_' . uniqid()] = [
                                $projects[$projectId]['name'],
                                $issues[$timeEntry['issue']['id']]['name'],
                                'http://red.mega-dev.ru/issues/' . $timeEntry['issue']['id'],
                                $timeEntry['user']['name'],
                                $users[$timeEntry['user']['id']]['specialty'],
                                $timeEntry['hours'],
                                $useful_hours,
                                $timeEntry['comments'],
                                $estimatedHours !== false ? 'Фикс' : $cof,
                            ];
                        }

                        $timeEntryFact += $timeEntry['hours'];
                        $projectTimeEntryFact += $timeEntry['hours'];

                        if ($estimatedHours !== false && !in_array($timeEntry['issue']['id'], $addedEstimatedHours)) {
                            $timeEntryUseful += $estimatedHours;
                            $projectTimeEntryUseful += $estimatedHours;
                            $addedEstimatedHours[] = $timeEntry['issue']['id'];
                        } else {
                            if ($estimatedHours === false) {
                                //$timeEntryUseful += ($timeEntry['hours'] * $cof);
                                //$projectTimeEntryUseful += ($timeEntry['hours'] * $cof);
                            }
                        }
                    }
                }
            }
            if (count($projectRows) > 0) {
                ksort($projectRows);
                foreach ($projectRows as &$row) {
                    $issueId = str_replace('http://red.mega-dev.ru/issues/', '', $row[2]);

                    if ($row[8] != 'Фикс') {
                        $row[6] = static::roundHalf($row[6]);
                        $timeEntryUseful += $row[6];
                        $projectTimeEntryUseful += $row[6];
                    } else {
                        $prevHours = $issues[$issueId]['prev_hours'];
                        $row[6] -= $prevHours;
                        $timeEntryUseful -= $prevHours;
                        $projectTimeEntryUseful -= $prevHours;
                    }

                    if (count($issues[$issueId]['checklist']) > 0) {
                        $checklistStr = '';
                        foreach ($issues[$issueId]['checklist'] as $item) {
                            $checklistStr .= ($item['subject'] . ' - ' . ($item['is_done'] ? 'Выполнен' : 'Не выполнен') . "\n");
                        }
                        $row[7] .= "\n" . $checklistStr;
                    }
                }

                $projectRows['y9_' . uniqid()] = [
                    '',
                    '',
                    '',
                    '',
                    'Всего',
                    $projectTimeEntryFact,
                    $projectTimeEntryUseful,
                    '',
                    '',
                ];

                $projectRows['z9_' . uniqid()] = [
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                ];

                $report = array_merge($report, $projectRows);
            }
        }
        $report[uniqid()] = [
            '',
            '',
            '',
            '',
            'Всего',
            $timeEntryFact,
            $timeEntryUseful,
            '',
            '',
        ];

        return $report;
    }

    public static function renderMonthReport($report, $from, $to)
    {
        $titles = [
            'Проект',
            'Задача',
            'Redmine',
            'Исполнитель',
            'Специализация',
            'Часы факт',
            'Часы полезные',
            'Комментарий',
            'КПД',
        ];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Отчет');
        $sheet->setCellValue('B1', $from);
        $sheet->setCellValue('C1', $to);
        $sheet->fromArray($titles, null, 'A2');
        $sheet->fromArray($report, null, 'A3');

        $file = '/assets/xls/' . uniqid() . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save(dirname(dirname(__DIR__)) . $file);
        return dirname(dirname(__DIR__)) . $file;
    }

    public static function eveningReport($from, $to)
    {
        $timer = new Timer();
        $timers = $timer->getEvningsTimes($from, $to);
        $reportData = [];
        $issues = (new Issue())->issues();
        $users = (new User())->getAllUsersFromRedmine();
        $projects = (new Project())->all();
        $users_id = array_column($users, 'id');
        $users = array_combine($users_id, $users);

        $total_by_users = [];
        $total_by_projects = [];

        foreach ($timers as $timerItem) {
            $issue = $issues[$timerItem['issue_id']];
            $type = 'Вечерние';
            $report_item = [
                $timerItem['updated_on'],
                $projects[$issue['project_id']]['name'],
                $issue['name'],
                'http://red.mega-dev.ru/issues/' . $timerItem['issue_id'],
                $users[$timerItem['user_id']]['firstname'] . ' ' . $users[$timerItem['user_id']]['lastname'],
            ];

            $timer_date = date_create_from_format('Y-m-d H:i:s', $timerItem['updated_on']);
            if ($timer_date->format('D') == 'Sat' || $timer_date->format('D') == 'Sun') {
                $check_date = date_modify(clone $timer_date, '00:00:00');
                $diff = (array)date_diff($timer_date, $check_date);
                $hour = $diff['h'] + round($diff['i'] / 60, 2);
                if ($timerItem['hours'] > $hour) {
                    $check_date = $check_date = date_modify(date_modify(clone $timer_date, '-1 day'), '18:30');
                    $diff = (array)date_diff($timer_date, $check_date);
                    $hour = $diff['h'] + round($diff['i'] / 60, 2);
                    if ($timerItem['hours'] > $hour) {
                        $report_item[] = $hour;
                        $type = 'Вечерние';
                    } else {
                        $report_item[] = $timerItem['hours'];
                        $type = 'Выходные';
                    }
                } else {
                    $report_item[] = $timerItem['hours'];
                    $type = 'Выходные';
                }
            } else {
                if ($timerItem['DIFF'] < '00:00:00') {
                    $check_date = date_modify(date_modify(clone $timer_date, '-1 day'), '18:30');
                } else {
                    $check_date = date_modify(clone $timer_date, '18:30');
                }
                $diff = (array)date_diff($timer_date, $check_date);

                $hour = $diff['h'] + round($diff['i'] / 60, 2);
                if ($timerItem['hours'] > $hour) {
                    $report_item[] = $hour;
                } else {
                    $report_item[] = $timerItem['hours'];
                }
                $type = 'Вечерние';
            }

            if (isset($total_by_users[$timerItem['user_id']])) {
                $total_by_users[$timerItem['user_id']] += $report_item[5];
            } else {
                $total_by_users[$timerItem['user_id']] = $report_item[5];
            }

            if (isset($total_by_projects[$issue['project_id']])) {
                $total_by_projects[$issue['project_id']] += $report_item[5];
            } else {
                $total_by_projects[$issue['project_id']] = $report_item[5];
            }

            $report_item[] = $timerItem['hours'];
            $report_item[] = $type;
            $reportData[] = $report_item;
        }

        $reportData[] = [];
        $reportData[] = ['Итог по пользователям'];
        foreach ($total_by_users as $user_id => $hour) {
            $reportData[] = [
                $users[$user_id]['firstname'] . ' ' . $users[$user_id]['lastname'],
                $hour
            ];
        }

        $reportData[] = [];
        $reportData[] = ['Итог по проектам'];
        foreach ($total_by_projects as $project_id => $hour) {
            $reportData[] = [
                $projects[$project_id]['name'],
                $hour
            ];
        }

        return $reportData;
    }

    public static function renderEveningReport($report, $from, $to)
    {
        $titles = [
            'Дата',
            'Проект',
            'Задача',
            'Redmine',
            'Исполнитель',
            'Время переработок',
            'Время в задаче по фатку',
            'Тип переработок'
        ];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Отчет');
        $sheet->setCellValue('B1', $from);
        $sheet->setCellValue('C1', $to);
        $sheet->fromArray($titles, null, 'A2');
        $sheet->fromArray($report, null, 'A3');

        $file = '/assets/xls/' . uniqid() . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save(dirname(dirname(__DIR__)) . $file);
        return dirname(dirname(__DIR__)) . $file;
    }

    public static function afterDeadlineAlert()
    {
        $users = UserService::getAllUser();

        foreach ($users as $user) {
            $tasks = null;
            $tasks = IssueService::getTasksDeadlinesByAuthor($user['redmine'], 0);
            if (!empty($tasks)) {
                $message = "Хай, у этих задач наступил дедлайн!\n\n";
                foreach ($tasks as $issue_id => $task) {
                    $message .= $task["project"] . " - #" . $issue_id . " - <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>" . $task["name"] . "</a>" . "\n";
                }
                Telegram::send($user['telegram'], $message);
            }
        }

    }

    public static function beforeDeadlineAlert()
    {
        $users = UserService::getAllUser();

        foreach ($users as $user) {
            $tasks = null;
            $tasks = IssueService::getTasksDeadlinesByAuthor($user['redmine'], 1);
            if (!empty($tasks)) {
                $message = "Хай, у этих задач завтра наступит дедлайн!\n\n";
                foreach ($tasks as $issue_id => $task) {
                    $message .= $task["project"] . " - #" . $issue_id . " - <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>" . $task["name"] . "</a>" . "\n";
                }
                Telegram::send($user['telegram'], $message);
            }
        }

    }

    public static function showAllDeadlines()
    {
        $allDeadlines = [];
        $users = UserService::getAllUser();
        foreach ($users as $user) {
            $allDeadlinesByAuthor = IssueService::getTasksDeadlinesByAuthor($user['redmine']);
            $allDeadlines = $allDeadlines + $allDeadlinesByAuthor;
        }
        $message = '';
        if (!empty($allDeadlines)) {
            $message = "Вот все незакрытые задачи и их дедлайны:\n\n";
            foreach ($allDeadlines as $issue_id => $task) {
                $message .= $task["project"] . " - #" . $issue_id . " - <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>" . $task["name"] . "</a>" . " - " . $task["due_date"] . "\n";
            }
        } else {
            $message .= 'Нет ни одной заадчи с установленным дедлайном';
        }
        return $message;
    }

    private static function roundHalf($val)
    {
        return round(ceil($val * 4) / 4, 2);
    }
}