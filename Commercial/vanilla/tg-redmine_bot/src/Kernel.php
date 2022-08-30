<?php

namespace TgRedmine;

use TgRedmine\helpers\Cfg;
use TgRedmine\helpers\Telegram;
use TgRedmine\models\Task;
use TgRedmine\models\User;
use TgRedmine\models\Events;
use TgRedmine\services\AdminService;
use TgRedmine\services\GifService;
use TgRedmine\services\GlobalWatcherService;
use TgRedmine\services\GoogleService;
use TgRedmine\services\QueueService;
use TgRedmine\services\TaskService;
use TgRedmine\services\TimerService;
use TgRedmine\services\ReportService;
use TgRedmine\services\UserService;
use TgRedmine\services\ObserverService;
use TgRedmine\services\WebhookService;
use TgRedmine\services\ProjectService;
use TgRedmine\services\FoodService;
use TgRedmine\services\CertService;
use TgRedmine\services\DomainService;
use TgRedmine\services\ViolationService;
use TgRedmine\services\SiteService;
use TgRedmine\services\BegetService;
use TgRedmine\services\NotifyService;

class Kernel
{
    public function __construct()
    {
    }

    public function run()
    {
        $config = Cfg::getInstance();
        $currentDateTime = date('Y-m-d H:i');
        $currentTime = date('H:i');
        $currentHour = intval(date('H'));
        $currentMinute = intval(date('i'));
        $disabledUsers = UserService::getDisableNotifyUsers();

        if (!$config->get('work')) {
            return;
        }

        \TgRedmine\helpers\Logger::getInstance()->log('run on ' . ' ' . $currentDateTime);

        foreach ($config->get('chats') as $chat) {
            \TgRedmine\helpers\Logger::getInstance()->log('gif check ' . ' ' . $currentHour . ' ' . $currentMinute);
//            if ($currentHour >= 10 && $currentHour <= 17 && $currentMinute == 0) {
//                $randomGifs = GifService::getRandomGifs('smoke');
//                \TgRedmine\helpers\Logger::getInstance()->log('gif send ' . ' ' . $randomGifs);
//                if ($randomGifs) {
//                    Telegram::sendAnimation($chat['tg'], $randomGifs);
//                } else {
//                    Telegram::sendAnimation($chat['tg'], "https://c.tenor.com/GGsZ7_cG2bAAAAAS/smoke-cigarettes.gif");
//                }
//            }

//            if ($currentTime == '08:55') {
//                $text = "<b>Хей, парни</b>\nВы сейчас в пути на твою любимую работу, вот вам инструкция че делать по такому поводу\n" .
//                    "1. Приди на работу\n" .
//                    "2. Если бот прислал уведомление, что вчера отмечено меньше 8 часов, то добавь время в задачи, над которыми вчера работал\n" .
//                    "3. Открой в <a href='http://red.mega-dev.ru/agile/board?utf8=%E2%9C%93&set_filter=1&f%5B%5D=assigned_to_id&op%5Bassigned_to_id%5D=%3D&v%5Bassigned_to_id%5D%5B%5D=me&f%5B%5D=status_id&op%5Bstatus_id%5D=%3D&f_status%5B%5D=1&f_status%5B%5D=2&f_status%5B%5D=8&c%5B%5D=project&c%5B%5D=estimated_hours&c%5B%5D=spent_hours&c%5B%5D=description&group_by=&color_base=priority'>редмайне</a> доску с приоритетами задач\n" .
//                    "4. В работу нужно взять самую верхнюю – включи там таймер и поменяй задаче статус на 'в работе'\n" .
//                    "5. Посмотри новые комментарии к задачам, на почту приходят уведомления об обновлениях\n" .
//                    "6. Если есть комментарии с вопросами - ответь на них\n" .
//                    "7. Пили задачку из пункта 4, на которую запустил таймер";
//                Telegram::send($chat['tg'], $text);
//            }

//            if ($currentTime == '17:58') {
//                $text = "<b>Хей, парни</b>\nПора заканчивать работу, вот вам инструкция как это сделать\n1. Останови таймер\n2. Оставь комментарий в задаче, которую пилил, с описание проделанной работы\n3. Поменяй статус задачи на 'новая'\n4. Если бот прислал уведомлялку, что отмечено меньше 8 часов, то добавь время в задачи, над которыми работал сегодня\n5. Иди домой";
//                Telegram::send($chat['tg'], $text);
//            }

            if ($currentHour == 13 && $currentMinute == 30) {
                $randomGifs = GifService::getRandomGifs('lunch');
                if ($randomGifs) {
                    Telegram::sendAnimation($chat['tg'], $randomGifs);
                } else {
                    Telegram::sendAnimation($chat['tg'], "https://c.tenor.com/EpN9VMa0h0MAAAAM/so-hungry-hangry.gif");
                }
            }

            if ($currentTime == '18:05') {
                $reportText = ViolationService::report();
                Telegram::send($chat['tg'], $reportText);
            }

            if ($currentTime == '09:00') {
                $now = date_create(date("Y-m-d H:i:s"));
                $finish = date_create(SiteService::lastFall()["last_fall"]);
                $interval = date_diff($now, $finish);
                $diffDay = $interval->format('%a');
                $diffHour = $interval->format('%h');
                Telegram::send($chat['tg'],
                    "<b>Хей, парни</b>\nЧасов без падения сайтов <code>" . ($diffDay * 24 + $diffHour) . "</code>");

                /**
                 * Запись срока оплаты домены и срока SSL
                 */
                SiteService::SSLnHosting();
            }

            if ($currentDateTime == date('Y-m-d 09:30', strtotime('this monday'))) {
                $startWeek = date('Y-m-d', strtotime('-7 day'));
                $endWeek = date('Y-m-d', strtotime('-1 day'));;

                $tableResults = GoogleService::checkFromPeriod($startWeek, $endWeek);
                if (count($tableResults) > 0) {
                    $text = "<b>Хей, парни</b> За прошлую неделю отметил в базу:\n";
                    foreach ($tableResults as $name => $count) {
                        $text .= "<b>$name</b> - $count\n";
                    }
                } else {
                    $text = "<b>Хей, парни</b> За прошлую неделю никто ничего не отметил в базу\n";
                }
                Telegram::send($chat['tg'], $text);
            }

            if ($currentDateTime == date('Y-m-d 09:30', strtotime('last day of this month'))) {
                $startWeek = date('Y-m-d', strtotime('first day of this month'));
                $endWeek = date('Y-m-d', strtotime('last day of this month'));;

                $tableResults = GoogleService::checkFromPeriod($startWeek, $endWeek);
                if (count($tableResults) > 0) {
                    $text = "<b>Хей, парни</b> За этот месяц отметили в базу:\n";
                    foreach ($tableResults as $name => $count) {
                        $text .= "<b>$name</b> - $count\n";
                    }
                } else {
                    $text = "<b>Хей, парни</b> За этот месяц никто ничего не отметил в базу\n";
                }
                Telegram::send($chat['tg'], $text);
            }

            if ($currentDateTime == date('Y-m-d 10:00', strtotime('this monday'))) {
                $tasks = TaskService::getBacklogsFreeTasks();
                if (count($tasks) > 0) {
                    $text = "<b>Хей, парени</b>\nВ <code>беклоге</code> есть задачки, которые <code>никто не пилит</code>\n";
                    foreach ($tasks as $task) {
                        $text .= "<a href='http://red.mega-dev.ru/issues/" . $task['id'] . "'>#" . $task['id'] . ", " . $task['subject'] . "</a>\n";
                    }
                } else {
                    $text = "<b>Хей, парени</b>\nВы красавичики, все задачки из беклога разобрали";
                }
                Telegram::send($chat['tg'], $text);
            }
        }

        foreach ((new User())->all() as $member) {

            if ($currentHour >= 9 && $currentHour <= 18 && $currentMinute % 10 == 0) {
                $errorTask = TaskService::checkEstimatedHours($member['redmine']);
                $user = null;
                if ($errorTask) {
                    $name = explode(' ', $member['name'])[0];
                    $text = "<b>Хей, $name</b>\n";
                    foreach ($errorTask as $task) {
                        $text .= ("\nЗапланированное время на задачу <a href='http://red.mega-dev.ru/issues/" . $task['id'] . "'>#" . $task['id'] . " " . $task['name'] . "</a> закончилось. Постановщик задачи скоро придет с инструкциями");
                        //ViolationService::addViolation($member['redmine']);
                        $user = UserService::getUserByRedmineId($task['author']);
                        Telegram::send($user['telegram'],
                            "\nЗапланированное время на задачу <a href='http://red.mega-dev.ru/issues/" . $task['id'] . "'>#" . $task['id'] . " " . $task['name'] . "</a> закончилось. Сходи проверь что там случилось");
                    }
                    if ($user['telegram'] != $member['telegram']) {
                        Telegram::send($member['telegram'], $text);
                    }


                    if (!$member['admin']) {
                        $adminText = "<b>Хей, парень</b>\nУ <u>" . $member['name'] . "</u> слишком долго пилит задачи";
                        foreach ($errorTask as $task) {
                            $adminText .= ("\nЗадачу <a href='http://red.mega-dev.ru/issues/" . $task['id'] . "'>#" . $task['id'] . " " . $task['name'] . "</a> оценили в " . round($task['estimated_hours'],
                                    2) . ", а он уже потратил " . round($task['spent_hours'], 2));
                        }
                        AdminService::notify($adminText);
                    }
                }
            }

            $checkOnWorkCount = TaskService::checkCountOnWorkTaskByUserId($member['redmine']);
            if ($checkOnWorkCount && $member['notify_on_work_count']) {
                $name = explode(' ', $member['name'])[0];
                $text = "<b>Хей, $name</b>\nУ тебя больше <code>одной</code> задачи со статусом <code>В работе</code>";
                Telegram::send($member['telegram'], $text);
                ViolationService::addViolation($member['redmine']);
            }

            $startTasks = TaskService::getStartTaskByUserId($member['redmine'], $currentDateTime);
            if (count($startTasks) > 0 && $member['notify_start_task']) {
                $name = explode(' ', $member['name'])[0];
                $text = "<b>Хей, $name</b>\nНастало время запилить ";
                $adminText = "<b>Хей, парень</b>\nУ " . $member['name'] . " настало время запилить ";
                foreach ($startTasks as $task) {
                    $text .= "<a href='http://red.mega-dev.ru/issues/" . $task['id'] . "'>задачу #" . $task['id'] . "</a> ";
                    $adminText .= "<a href='http://red.mega-dev.ru/issues/" . $task['id'] . "'>задачу #" . $task['id'] . "</a> ";
                }
                Telegram::send($member['telegram'], $text);
                if (!$member['admin']) {
                    AdminService::notify($adminText);
                }
            }

            if ($currentTime == '09:00') {
                $prevDate = date('N') == 1 ? date('Y-m-d', strtotime('-3 day')) : date('Y-m-d', strtotime('-1 day'));
                $tasks = TaskService::getNotCommentedTask($member['redmine'], $prevDate);
                if (count($tasks) > 0) {
                    $name = explode(' ', $member['name'])[0];
                    $text = "<b>Хей, $name</b>\nУ тебя есть <code>задачи, в которые ты " . (date('N') == 1 ? 'пятницу' : 'вчера') . " не отписал что сделал</code>, не забудь оставить коммент\n";
                    foreach ($tasks as $task) {
                        $text .= "<a href='http://red.mega-dev.ru/issues/$task'>$task</a> ";
                        ViolationService::addViolation($member['redmine']);
                    }
                    Telegram::send($member['telegram'], $text);

                    if (!$member['admin']) {
                        $adminText = "<b>Хей, парень</b>\nУ <u>" . $member['name'] . "</u> есть задачи без комментариев за " . (date('N') == 1 ? 'пятницу' : 'вчера') . ": ";
                        foreach ($tasks as $task) {
                            $adminText .= "<a href='http://red.mega-dev.ru/issues/$task'>$task</a> ";
                        }
                        AdminService::notify($adminText);
                    }
                }

                $timeCount = TimerService::sumTimerPerDayByUserId($member['redmine'], $prevDate);
                if ($timeCount['sum'] < 8 && $member['notify_sum_timer_day']) {
                    $name = explode(' ', $member['name'])[0];
                    $text = "<b>Хей, $name</b>\nУ тебя за <u>" . (date('N') == 1 ? 'пятницу' : 'вчера') . "</u> отмечено меньше <code>8</code> часов, проверь задачи, которые пилил. Ты отметил - <i>" . $timeCount['sum'] . "</i>";
                    foreach ($timeCount as $id => $name) {
                        if ($id != 'sum') {
                            $text .= "\n<a href='http://red.mega-dev.ru/issues/$id'>$name</a> ";
                        }
                    }
                    Telegram::send($member['telegram'], $text);
                    ViolationService::addViolation($member['redmine']);

                    if (!$member['admin']) {
                        $adminText = "<b>Хей, парень</b>\nУ <u>" . $member['name'] . "</u> за " . (date('N') == 1 ? 'пятницу' : 'вчера') . " отмечено меньше <code>8</code> часов. Он отметил - <i>" . $timeCount['sum'] . "</i>";
                        AdminService::notify($adminText);
                    }
                }

                $activeTimer = TimerService::getActiveTimerByUserId($member['redmine']);
                $userNotStartTimer = [];
                if ($member['morningStartWork'] && !$activeTimer) {
                    $name = explode(' ', $member['name'])[0];
                    $text = "<b>Хей, $name</b>\nВключи <code>таймер</code>, если сегодня работаешь";
                    Telegram::send($member['telegram'], $text);
                    ViolationService::addViolation($member['redmine']);
                    $userNotStartTimer[] = $member['name'];
                }

                if (count($userNotStartTimer) > 0) {
                    $adminText = "<b>Хей, парень</b>\nУ <code>" . implode(', ',
                            $userNotStartTimer) . "</code> не запущены таймеры. Пни их, если они работаю";
                    AdminService::notify($adminText);
                }
            }

            if ($currentTime == '17:30') {
                $prevDate = date('Y-m-d');
                $timeCount = TimerService::sumTimerPerDayByUserId($member['redmine'], $prevDate);
                if ($timeCount['sum'] < 7.5 && $member['notify_sum_timer_day']) {
                    $name = explode(' ', $member['name'])[0];
                    $text = "<b>Хей, $name</b>\nУ тебя за <u>сегодня</u> отмечено меньше <code>8</code> часов, проверь задачи, которые пилил. Ты отметил - <i>" . $timeCount['sum'] . "</i>";
                    $editLink = "http://red.mega-dev.ru/time_entries?utf8=%E2%9C%93&f%5B%5D=spent_on&op%5Bspent_on%5D=t&f%5B%5D=user_id&op%5Buser_id%5D=%3D&v%5Buser_id%5D%5B%5D=" . $member['redmine'] . "&f%5B%5D=&c%5B%5D=project&c%5B%5D=spent_on&c%5B%5D=user&c%5B%5D=activity&c%5B%5D=issue&c%5B%5D=comments&c%5B%5D=hours";
                    $text .= "\nИсправить можно  <a href='$editLink'>здесь</a>";
                    foreach ($timeCount as $id => $name) {
                        if ($id != 'sum') {
                            $text .= "\n<a href='http://red.mega-dev.ru/issues/$id'>$name</a> ";
                        }
                    }
                    Telegram::send($member['telegram'], $text);

                    if (!$member['admin']) {
                        $adminText = "<b>Хей, парень</b>\nУ <u>" . $member['name'] . "</u> за сегодня отмечено меньше <code>8</code> часов. Он отметил - <i>" . $timeCount['sum'] . "</i>";
                        AdminService::notify($adminText);
                    }
                }

                $tasks = TaskService::getNotCommentedTask($member['redmine'], date('Y-m-d'));
                if (count($tasks) > 0) {
                    $name = explode(' ', $member['name'])[0];
                    $text = "<b>Хей, $name</b>\nУ тебя есть <code>задачи, в которые ты не отписал что сделал</code>, не забудь оставить коммент\n";
                    foreach ($tasks as $task) {
                        $text .= "<a href='http://red.mega-dev.ru/issues/$task'>$task</a> ";
                    }
                    Telegram::send($member['telegram'], $text);
                    //ViolationService::addViolation($member['redmine']);
                }
            }

            if ($currentTime == '18:30') {
                $checkActiveTimer = TimerService::checkActiveTimerByUserId($member['redmine']);
                if ($checkActiveTimer && $member['notify_active_timer']) {
                    $name = explode(' ', $member['name'])[0];
                    $text = "<b>Хей, $name</b>\nУ тебя есть <code>активный таймер</code>, не забудь остановить его\nЕсли еще работаешь, то мои <s>соболезнования</s>";
                    Telegram::send($member['telegram'], $text);
                }
            }

            if ($currentTime == '18:00') {
//                $timeCount = TimerService::sumTimerPerDayByUserId($member['redmine']);
//                if ($timeCount < 7 && $member['notify']['sumTimerDay']) {
//                    $text = "<b>Хей, парень</b>\nУ тебя за <u>сегодня</u> отмечено меньше <code>7</code> часов, проверь задачи, которые пилил. Ты отметил - <i>$timeCount</i>";
//                    Telegram::send($member['telegram'], $text);
//                    if (!$member['admin']) {
//                        $adminText = "<b>Хей, парень</b>\nУ <u>" . $member['name'] . "</u> отмечено меньше <code>7</code> часов. Он отметил - <i>$timeCount</i>";
//                        AdminService::notify($adminText);
//                    }
//                }
            }


            // Отметь в базу знаний что-то интересное за день
            if ($currentTime == '17:00') {
                if ($member['notify_is_knowledge']) {
                    $name = explode(' ', $member['name'])[0];
                    $text = "<b>Хей, $name</b>\nОтметь в базу знаний, что интересного попалось за <u>сегодня</u>.\n<a href='https://docs.google.com/spreadsheets/d/12xua5wFt0y-8-Sjj5b05k-wOWv_M1rTO4UqBZZfx4_8/edit#gid=1096229420'>Ссылка на таблицу</a>.";
                    Telegram::send($member['telegram'], $text);
                }
            }

            if ($currentHour >= 9 && $currentHour < 18) {
                if ($currentMinute == 30 || $currentMinute == 0) {
                    if ($member['notify_last_timer'] && !isset($disabledUsers[$member['redmine']])) {
                        $lastActiveTimer = TimerService::checkLastActiveTimer($member['redmine']);
                        if ($lastActiveTimer && $lastActiveTimer >= 10) {
                            $name = explode(' ', $member['name'])[0];
                            $text = "<b>Хей, $name</b>\nУ тебя <u>не запущен</u> таймер";
                            Telegram::send($member['telegram'], $text);
                            ViolationService::addViolation($member['redmine']);

                            if (!$member['admin']) {
                                $adminText = "<b>Хей, парень</b>\nУ <u>" . $member['name'] . "</u> не запущен таймер. Пни-ка его";
                                AdminService::notify($adminText);
                            }
                        }
                    }
                }
            }
        }

        if ($currentTime == '09:00') {
            $tasks = TaskService::getNonActiveTask();
            if (count($tasks) > 0) {
                $text = "<b>Хей, парень</b>\nУ тебя есть <code>задачи, в которых давненько не было активности</code>\n";
                foreach ($tasks as $task) {
                    $text .= "<a href='http://red.mega-dev.ru/issues/" . $task['id'] . "'>#" . $task['id'] . ", " . $task['name'] . " - " . $task['status'] . " - " . $task['days'] . " дня(ей)" . "</a>\n";
                    // ViolationService::addViolation(1);
                }
                AdminService::notify($text);
            }

            $expiresSite = CertService::check();
            if (count($expiresSite) > 0) {
                $text = "<b>Хей, парень</b>\nСкоро истекают сертификаты у сайтов:\n";
                foreach ($expiresSite as $site) {
                    $text .= "<a href='" . $site['url'] . "'>" . $site['url'] . "</a> - " . $site['date'] . "\n";
                }
                AdminService::notify($text);
            }

            $expiresDomain = DomainService::check();
            if (count($expiresDomain) > 0) {
                $text = "<b>Хей, парень</b>\nСкоро заканчиваются домены у сайтов:\n";
                foreach ($expiresDomain as $site) {
                    $text .= "<a href='" . $site['url'] . "'>" . $site['url'] . "</a> - " . $site['date'] . "\n";
                }
                AdminService::notify($text);
            }
        }

        if ($currentTime == '09:10') {
            $tasks = TaskService::getStartTasks();
            if (count($tasks) == 0) {
                AdminService::notify('Нет запланированных задач');
            } else {
                $text = "Так, запланированные задачи:\n";
                foreach ($tasks as $id => $task) {
                    $text .= "<a href='http://red.mega-dev.ru/issues/" . $id . "'>" . $task['name'] . "</a>\n" . $task['assigned_to'] . "\n" . $task['date'] . "\n\n";
                }
                AdminService::notify($text);
            }
        }

        if ($currentTime == '17:00') {
            $adminText = "<b>Хей, парень</b>\nОтметь в базу знаний, что интересного попалось за <u>сегодня</u>.\n<a href='https://docs.google.com/spreadsheets/d/12xua5wFt0y-8-Sjj5b05k-wOWv_M1rTO4UqBZZfx4_8/edit#gid=1096229420'>Ссылка на таблицу</a>.";
            AdminService::notify($adminText);
        }

        if ($currentTime == '18:30') {
            $report = ReportService::hoursByTaskReport();
            $message = ReportService::renderDayReport($report);
            AdminService::notify($message);
            ObserverService::notify($message);
        }

        if ($currentTime == '00:00') {
            ViolationService::clearViolation();
        }

        if ($currentDateTime == date('Y-m-d 19:00', strtotime('this friday'))) {
            $report = ReportService::weekHoursReport();
            $message = ReportService::renderWeekReport($report);
            AdminService::notify($message);
            ObserverService::notify($message);
        }

        //оповещение о прошедшем дедлайне
        if ($currentTime == '08:40') {
            ReportService::afterDeadlineAlert();
        }

        //оповещение о предстоящем дедлайне
        if ($currentTime == '08:45') {
            ReportService::beforeDeadlineAlert();
        }

    }

    public function notify($data)
    {
        $event = $data['event'];
        $checklistEvents = ['checklistAdd', 'checklistRemove', 'checklistUpdate', 'checklistDone', 'checklistsDetails'];
        if (in_array($event, $checklistEvents)) {
            $assignedUserId = $data['assigned_id'];
            $authorUserId = $data['author_id'];
            $issue_id = $data['issue_id'];
            $assignedUser = UserService::getUserByRedmineId($assignedUserId);
            $authorUser = UserService::getUserByRedmineId($authorUserId);
        } else {
            if ($event == 'newCommit') {
                $author = $data['user_name'];
                $project = $data['project']['name'];
                $commit_title = '';
                $commit_link = '';
                if (count($data['commits']) > 0) {
                    $commit = $data['commits'][count($data['commits']) - 1];
                    $commit_title = $commit['title'];
                    $commit_link = $commit['url'];
                }
            } else {
                if ($event == 'newCommentGit') {
                    $comment_author = $data['user']['name'];
                    $project = $data['project']['name'];
                    $commit_name = $data['commit']['title'];
                    $comment_url = $data['object_attributes']['url'];
                    $commit_author = $data['commit']['author'];
                } else {
                    $user_id = $data['user_id'];
                    $issue_id = $data['issue_id'];
                    $user = UserService::getUserByRedmineId($user_id);
                }
            }
        }

        if (!empty($user)) {
            $name = explode(' ', $user['name'])[0];
            $text = "<b>Хей, $name</b>\n";
        } else {
            $name = null;
            $text = "<b>Хей, парень</b>\n";
        }
        $globalText = "<b>Хей, парень</b>\n";
        switch ($event) {
            case 'agileChange':
                $text .= "У тебя изменились задачи на <u>доске Agile</u>. Чекни что там прозошло <a href='https://red.mega-dev.ru/agile/board?utf8=%E2%9C%93&set_filter=1&f%5B%5D=assigned_to_id&op%5Bassigned_to_id%5D=%3D&v%5Bassigned_to_id%5D%5B%5D=" . $user_id . "&f%5B%5D=status_id&op%5Bstatus_id%5D=%3D&f_status%5B%5D=1&f_status%5B%5D=2&f_status%5B%5D=9&f_status%5B%5D=11&f_status%5B%5D=8&c%5B%5D=project&c%5B%5D=estimated_hours&c%5B%5D=spent_hours&c%5B%5D=description&group_by=&color_base=priority'>задачи</a>";
                break;
//            case 'statusChange':
//                $text .= "Ты чё-то попутал. Убедись, что правильно назначил задачу и поставил статус <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задача #" . $issue_id . "</a>";
//                ViolationService::addViolation($user_id);
//            break;
            case 'assignedStatusChange':
                $text .= "У тебя изменился <u>статус</u> у <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задачи #" . $issue_id . "</a>";
                $globalText .= "В <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задаче #" . $issue_id . "</a> изменился <u>статус</u>";
                break;
            case 'checklistAdd':
                $text .= "В <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задачу #" . $issue_id . "</a> добавился пункт \n" . $data['subject'];
                $globalText .= "В < a href = 'http://red.mega-dev.ru/issues/" . $issue_id . "' > задачу #" . $issue_id . "</a> добавился пункт \n" . $data['subject'];
                break;
            case 'checklistRemove':
                $text .= "В <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задаче #" . $issue_id . "</a> удалился пункт \n" . $data['subject'];
                $globalText .= "В <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задаче #" . $issue_id . "</a> удалился пункт \n" . $data['subject'];
                break;
            case 'checklistUpdate':
            case 'checklistDone':
                $text .= "В <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задаче #" . $issue_id . "</a> обновился пункт \n" . $data['subject'] . " - " . ($data['is_done'] ? ' выполнен' : ' не выполнен');
                $globalText .= "В <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задаче #" . $issue_id . "</a> обновился пункт \n" . $data['subject'] . " - " . ($data['is_done'] ? ' выполнен' : ' не выполнен');
                break;
            case 'checklistsDetails':
                $text .= "В <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задаче #" . $issue_id . "</a> обновился чеклист";
                $globalText .= "В <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задаче #" . $issue_id . "</a> обновился чеклист";
                break;
            case 'assignedStatusChangeWithComment':
                $text .= "У тебя изменился <u>статус</u> и добавился <u>коммент</u> у <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задачи #" . $issue_id . "</a>";
                $globalText .= "В <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задаче #" . $issue_id . "</a> изменился <u>статус</u> и добавился <u>коммент</u> ";
                break;
            case 'newTask':
                $text .= "У тебя появилась <u>новая</u> <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задача #" . $issue_id . "</a>";
                $globalText .= "Появилась <u>новая</u> <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задача #" . $issue_id . "</a>";
                break;
            case 'newCommentOnTask':
                $text .= "У тебя появился <u>новый</u> коммент у <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задачи #" . $issue_id . "</a>";
                $globalText .= "В <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>задаче #" . $issue_id . "</a> появился <u>новый</u> коммент ";
                break;
            case 'newBacklogTask':
                $text .= "В беклоге появилась новая задачка. Посмотри, может заинтересует тебя. <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'>" . $data['issue_name'] . "</a>";
                break;
            case 'newCommit':
                if ($commit_title != '' && $commit_link != '') {
                    $text .= "В проекте $project $author сделал новый коммит <a href='$commit_link'>$commit_title</a>";
                }
                break;
            case 'newCommentGit':
                $text .= 'Тебе ' . $comment_author . '  добавил новый коммент в твоем коммите <code>' . $commit_name . '</code> проекта ' . $project . '. <a href="' . $comment_url . '">Тыкай сюда</a>, чтоб посмотреть его';
                break;
            case 'editComment':
                $text .= "В задаче <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'> #" . $issue_id . "</a>" . " появился новый " . "<a href='http://red.mega-dev.ru/issues/" . $issue_id . "#note-" . $data['indice'] . "'>коммент" . "</a>";
                $globalText .= "В задаче <a href='http://red.mega-dev.ru/issues/" . $issue_id . "'> #" . $issue_id . "</a>" . " появился новый " . "<a href='http://red.mega-dev.ru/issues/" . $issue_id . "#note-" . $data['indice'] . "'>коммент" . "</a>";
                break;
        }
        if ($event == 'newBacklogTask') {
            foreach ((new User())->all() as $member) {
                if (!$member['observer']) {
                    $name = explode(' ', $member['name'])[0];
                    $text = str_replace('Хей, парень', "Хей, $name", $text);
                    Telegram::send($member['telegram'], $text);
                }
            }
        } else {
            if ($event == 'newCommit') {
                if ($text != "<b>Хей, парень</b>\n") {
                    AdminService::notify($text);
                    UserService::notify($text, $data['project_id']);
                }
            } else {
                if ($event == 'newCommentGit') {
                    $user = UserService::getUserByEmail($commit_author['email']);
                    if ($user) {
                        $name = explode(' ', $user['name'])[0];
                        $text = "<b>Хей, $name</b>\n";
                        Telegram::send($user['telegram'], $text);
                    }
                } else {
                    if ($text != "<b>Хей, парень</b>\n" && $text != "<b>Хей, $name</b>\n") {
                        if (isset($user)) {
                            Telegram::send($user['telegram'], $text);
                        }
                        if (isset($assignedUser)) {
                            $name = explode(' ', $assignedUser['name'])[0];
                            $textForAssigned = str_replace('Хей, парень', "Хей, $name", $text);
                            Telegram::send($assignedUser['telegram'], $textForAssigned);
                        }
                        if (isset($authorUser)) {
                            $name = explode(' ', $authorUser['name'])[0];
                            $textForAuthor = str_replace('Хей, парень', "Хей, $name", $text);
                            if (isset($assignedUser['telegram'])) {
                                if ($authorUser['telegram'] != $assignedUser['telegram']) {
                                    Telegram::send($authorUser['telegram'], $textForAuthor);
                                }
                            } else {
                                Telegram::send($authorUser['telegram'], $textForAuthor);
                            }
                        }
                        if ($globalText != "<b>Хей, парень</b>\n") {
                            $globalNotify = GlobalWatcherService::isWatcher([
                                $user["redmine"],
                                $assignedUser["redmine"],
                                $authorUser["redmine"]
                            ]);
                            if (!empty($globalNotify)) {
                                GlobalWatcherService::notifyCertain($globalNotify, $globalText);
                            }
                        }

                    }
                }
            }
        }

    }

    private function checkUser($userId)
    {
        $config = Cfg::getInstance();
        $users = new User();
        foreach ($users->all() as $member) {
            if ($member['telegram'] == $userId) {
                return true;
            }
        }

        foreach ($users->getObservers() as $observer) {
            if ($observer['telegram'] == $userId) {
                return true;
            }
        }

        foreach ($config->get('chats') as $chat) {
            if ($chat['tg'] == $userId) {
                return true;
            }
        }

        return false;
    }

    public function processMessage($update)
    {
        if (isset($update['callback_query']['data'])) {
            $user_id = $update['callback_query']['message']['chat']['id'];
        } else {
            $user_id = $update['message']['chat']['id'];
        }
        $find_user = self::checkUser($user_id);

        if (!$find_user) {
            Telegram::send($user_id, 'Пшл нх!');
            return;
        }

        // колбеки от кнопок бота
        if (isset($update['callback_query']['data'])) {
            switch ($update['callback_query']['data']) {
                case 'food_status':
                    $list = FoodService::list();
                    $response = "Ну смари:\n\n";
                    foreach ($list as $item) {
                        $response .= ("- <b>" . $item['name'] . "</b> <u>" . $item['rating'] . "</u>\n");
                    }
                    Telegram::send($update['callback_query']['message']['chat']['id'], $response);
                    break;

                case 'no_click':
                    Telegram::send($update['callback_query']['message']['chat']['id'], "Не тыкай, ебана рот!");
                    break;

                case 'check_domain':
                    $sites = DomainService::timeList();
                    $response = "<b>Ну смари:</b>\n";
                    uasort($sites, function ($s, $ss) {
                        $f_date = strtotime($s['date']);
                        $t_date = strtotime($ss['date']);

                        if ($f_date == $t_date) {
                            return 0;
                        }
                        return $f_date > $t_date ? 1 : -1;
                    });

                    foreach ($sites as $site) {
                        $response .= ("<b>" . $site['url'] . "</b> " . $site['date'] . "\n");
                    }
                    Telegram::send($update['callback_query']['message']['chat']['id'], $response);
                    break;

                case 'check_ssl':
                    $sites = CertService::timeList();
                    $response = "<b>Ну смари:</b>\n";
                    uasort($sites, function ($s, $ss) {
                        $f_date = strtotime($s['date']);
                        $t_date = strtotime($ss['date']);

                        if ($f_date == $t_date) {
                            return 0;
                        }
                        return $f_date > $t_date ? 1 : -1;
                    });

                    foreach ($sites as $site) {
                        $response .= ("<b>" . $site['url'] . "</b> " . $site['date'] . "\n");
                    }
                    Telegram::send($update['callback_query']['message']['chat']['id'], $response);
                    break;

            }

            if (strpos($update['callback_query']['data'], 'disable_') !== false) {
                $userRedmineId = str_replace('disable_', '', $update['callback_query']['data']);
                $user = UserService::getUserByRedmineId($userRedmineId);
                $disabledUsers = UserService::getDisableNotifyUsers();
                if (isset($disabledUsers[$userRedmineId])) {
                    unset($disabledUsers[$userRedmineId]);
                } else {
                    $disabledUsers[$userRedmineId] = $user['name'];
                }
                UserService::setDisableNotifyUsers($disabledUsers);
                Telegram::send($update['callback_query']['message']['chat']['id'], 'Окей, сохранил');
            }
        }

        // отлов сообщений
        if ($update['message']) {
            $message = $update['message'];
            $text = mb_strtolower($message['text']);
            $command = WebhookService::getCommand($text);
            $params = WebhookService::parseParams($command, $text);

            switch ($command) {
                // поиск по базе знаний
                case '/know':
                    $query_text = str_replace($command, "", $text);
                    $query_text = trim($query_text);
                    $query_text = str_replace(" ", "+", $query_text);
                    $search_jsn = @file_get_contents('https://baza.mega-dev.ru/api-bot.php?q=' . $query_text);
                    if ($search_jsn) {
                        $answer = json_decode($search_jsn);
                        if ($answer->count_result > 0) {
                            $txt_answer = "Найдено {$answer->count_result} результатов: \n\n";
                            foreach ($answer->result as $num => $one_row) {
                                $txt_answer .= ($num + 1) . ". <a href='{$one_row->url}'>{$one_row->title}</a> \n";
                            }
                            Telegram::send($message['chat']['id'], $txt_answer);
                        } else {
                            Telegram::send($message['chat']['id'],
                                "Ничего не найдено в базе знаний. Допиши в <a href='https://docs.google.com/spreadsheets/d/12xua5wFt0y-8-Sjj5b05k-wOWv_M1rTO4UqBZZfx4_8/edit#gid=0'>неё</a>, как разберешься.");
                        }
                    } else {
                        Telegram::send($message['chat']['id'], "База знаний не отвечает :( ");
                    }
                    break;
                case '/inactive':
                    $statuses = TaskService::getNonActiveTaskByStatus();
                    if (count($statuses) > 0) {
                        $text = "Вот тебе список задач с последней активностью:\n";
                        foreach ($statuses as $statusData) {
                            $text .= ("<u>" . $statusData['name'] . "</u>\n");
                            foreach ($statusData['tasks'] as $task) {
                                $text .= ("<a href='http://red.mega-dev.ru/issues/" . $task['task_id'] . "'>#" . $task['task_id'] . ", " . $task['name'] . "</a> - " . $task['diff'] . " д.\n");
                            }
                            $text .= "\n";
                        }
                        Telegram::send($message['chat']['id'], $text);
                    } else {
                        Telegram::send($message['chat']['id'], "Все норм, задач с такими статусами нет");
                    }
                    break;
                case '/dice':
                    Telegram::sendDice($message['chat']['id']);
                    break;
                case '/stars':
                    $reportText = ViolationService::status();
                    Telegram::send($message['chat']['id'], $reportText);
                    break;
                case '/report':
                    if (empty($params['from']) || empty($params['to'])) {
                        Telegram::send($message['chat']['id'],
                            "Ты это, че-то попутал видимо. Покажу, для тупых, как надо:");
                        Telegram::send($message['chat']['id'],
                            "/report " . date('Y-m-d', strtotime('first day of this month')) . " " . date('Y-m-d'));
                        Telegram::send($message['chat']['id'],
                            "Далее, 1 - для слияния записей времени, 0 - без слияния. По дефолту стоит 0.");
                        Telegram::send($message['chat']['id'],
                            "Можешь еще потом проекты дописать через запятую <u>baron32,gratar</u>, либо оставить отправить так или написать <u>all</u>, чтоб я все посмотрел. Вот тебе ключи проектов всех:");
                        Telegram::send($message['chat']['id'], implode("\n", ProjectService::indetifierProjects()));

                        Telegram::send($message['chat']['id'],
                            "Или перечислить специализации: " . implode(",", UserService::getSpecialtis()));

                        $usersList = '';
                        $users = UserService::getAllFromRedmine();
                        foreach ($users as $user) {
                            $usersList .= ($user['id'] . ' - ' . $user['firstname'] . ' ' . $user['lastname'] . "\n");
                        }

                        Telegram::send($message['chat']['id'],
                            "А вот еще список чуваков твоих, для фильтрации отчета по ним. Их тоже можешь через запятую указать \n$usersList");
                    } else {
                        Telegram::send($message['chat']['id'], 'Погоди, ща соберу тебе чё там ребята напилили');
                        $report = ReportService::periodReport($params['from'], $params['to'],$params['fusion'], $params['projects'],
                            $params['spec'], $params['users']);
                        $file = ReportService::renderMonthReport($report, $params['from'], $params['to']);
                        Telegram::sendDocument($message['chat']['id'], $file);
                    }
                    break;
                case '/deadlines':
                    Telegram::send($message['chat']['id'], 'Сейчас соберу.');
                    Telegram::send($message['chat']['id'], ReportService::showAllDeadlines());
                    break;
                case '/day_report':
                    Telegram::send($message['chat']['id'], 'Собираю отчет по задачам за день');
                    $report = ReportService::hoursByTaskReport();
                    $text = ReportService::renderDayReport($report);
                    Telegram::send($message['chat']['id'],
                        $text);
                    break;
                case '/overtime':
                    if (count($params) < 2) {
                        Telegram::send($message['chat']['id'],
                            "Ты это, че-то попутал видимо. Покажу, для тупых, как надо:");
                        Telegram::send($message['chat']['id'],
                            "/overtime " . date('Y-m-d', strtotime('first day of this month')) . " " . date('Y-m-d'));
                    } else {
                        Telegram::send($message['chat']['id'], 'Погоди, ща соберу тебе чё там ребята напилили');
                        $report = ReportService::eveningReport($params['from'], $params['to']);
                        $file = ReportService::renderEveningReport($report, $params['from'], $params['to']);
                        Telegram::sendDocument($message['chat']['id'], $file);
                    }
                    break;
                case '/food':
                    if ($params['name'] == 'оценки') {
                        $list = FoodService::list();
                        $response = "Ну смари\n";
                        foreach ($list as $item) {
                            $response .= ("<b>" . $item['name'] . "</b> <u>" . $item['rating'] . "</u>\n");
                        }
                        Telegram::send($message['chat']['id'], $response);
                    } else {
                        if (isset($params['rating']) && (is_numeric($params['rating']))) {
                            FoodService::add($params['name'], $params['rating'], $message['from']['id']);
                            Telegram::send($message['chat']['id'], 'Окей, учтём');
                        } else {
                            // Telegram::sendVideo($message['chat']['id'], '/home/z/zhenik/tgredmine-bot/public_html/assets/videos/stupid.mp4');
                            // кнопки
                            $keyboard = [
                                [
                                    [
                                        'text' => 'Оценки',
                                        'callback_data' => "food_status"
                                    ],
                                    [
                                        'text' => 'Не тыкай',
                                        'callback_data' => "no_click"
                                    ],
                                ]
                            ];
                            Telegram::send($message['chat']['id'],
                                "Опять что-то жрёте? \nНе понимаю, что ты хочешь! Доступно две команды: \n\n<b>/food оценки</b> - посмотреть список оценок \n<b>/food еда 3</b> - задать оценку. Где 'еда' - название, '3' - оценка  \n\nНу или на кнопки ниже потыкай, если совсем невменяемый",
                                $keyboard);
                        }
                    }

                    break;
                case '/coffee':
                    $text = "Кто будет варить кофе?\n";
                    $users = [
                        'Витя',
                        'Антон',
                        'Женя'
                    ];
                    shuffle($users);
                    $users = array_values($users);
                    for ($i = 1; $i <= 6; $i += 2) {
                        $text .= ($i) . ":" . ($i + 1) . " - " . $users[$i / 2] . "\n";
                    }
                    $text .= "Кубик решит";
                    Telegram::send($message['chat']['id'], $text);
                    Telegram::sendDice($message['chat']['id']);
                    break;

                case '/plan':
                    $tasks = TaskService::getStartTasks();
                    if (count($tasks) == 0) {
                        Telegram::send($message['chat']['id'], 'Нет запланированных задач');
                    } else {
                        $text = "Так, запланированные задачи:\n";
                        foreach ($tasks as $id => $task) {
                            $text .= "<a href='http://red.mega-dev.ru/issues/" . $id . "'>" . $task['name'] . "</a>\n" . $task['assigned_to'] . "\n" . $task['date'] . "\n\n";
                        }
                        Telegram::send($message['chat']['id'], $text);
                    }
                    break;
                case '/disable':
                    $keyboard = [];

                    $members = (new User())->all();
                    $disabledUsers = UserService::getDisableNotifyUsers();
                    foreach (array_chunk($members, 2) as $row) {
                        $k_row = [];
                        foreach ($row as $member) {
                            $userDisable = isset($disabledUsers[$member['redmine']]);
                            $k_row[] =
                                [
                                    'text' => $member['name'] . ($userDisable ? ' (Выключен)' : ''),
                                    'callback_data' => "disable_" . $member['redmine']
                                ];
                        }
                        $keyboard[] = $k_row;
                    }
                    Telegram::send($message['chat']['id'],
                        'Выбери, кому надо выключить уведомлялки об активном таймере до конца рабочего дня', $keyboard);
                    break;
                case '/whoiam':
                    $sender = $message['from'];
                    $text = "Так, ты у нас:\n";
                    if (isset($sender['username'])) {
                        $text .= ("Username: " . $sender['username'] . "\n");
                    }
                    $text .= ("Name: " . $sender['first_name'] . "\nID: " . $sender['id'] . "\n");
                    Telegram::send($message['chat']['id'], $text);
                    break;
                case '/check':
                    $keyboard = [
                        [
                            [
                                'text' => 'Домены',
                                'callback_data' => "check_domain"
                            ],
                            [
                                'text' => 'Сертификаты',
                                'callback_data' => "check_ssl"
                            ],
                        ]
                    ];
                    Telegram::send($message['chat']['id'], "Выбирай, что хочешь проверить", $keyboard);
                    break;
                case '/create':
                    if (count($params) < 1) {
                        Telegram::send($message['chat']['id'], "Введи домен вначале");
                        return;
                    }
                    Telegram::send($message['chat']['id'], "Погоди, ща создам все");

                    $domain = $params['domain'];
                    if (mb_strpos($domain, '.testers-site.ru') === false) {
                        Telegram::send($message['chat']['id'], "Домент должен быть вида <b>чекаго.testers-site.ru</b>");
                        return;
                    }
                    $createResponse = BegetService::createSite($domain);
                    if ($createResponse['status'] == 'error' || $createResponse['answer']['status'] == 'error') {
                        Telegram::send($message['chat']['id'],
                            "Не удалось создать сайт, проверь возможно домен или сайт занят");
                    } else {
                        Telegram::send($message['chat']['id'],
                            "Сайт создан. Он станет доступен через несколько минут.");
                    }
                    break;
                default:
                    $randomGifs = GifService::getRandomGifs('непонял');
                    if ($randomGifs) {
                        Telegram::sendAnimation($message['chat']['id'], $randomGifs);
                    } else {
                        Telegram::sendPhoto($message['chat']['id'],
                            'AgACAgIAAxkBAAICymF5r9BHDqrBNqNMzWA5u4G6oE_pAAIRuDEbCC7QS9pFWFOYT-gwAQADAgADeQADIQQ');
                    }
                    break;
            }
        }
    }

    public function webhook()
    {
        Telegram::setWebhook();
    }

    public function getWebhookInfo()
    {
        Telegram::getWebhookInfo();
    }

    public function send($msg)
    {
        var_dump(Telegram::sendDice(241973158));

        $config = Cfg::getInstance();
        foreach ($config->get('chats') as $chat) {
        }
    }

    public function report($type = 'day', $observer = false)
    {
        if ($type == 'day') {
            $report = ReportService::hoursByTaskReport();
            $message = ReportService::renderDayReport($report);
        } else {
            $report = ReportService::weekHoursReport();
            $message = ReportService::renderWeekReport($report);
        }

        AdminService::notify($message);
        if ($observer) {
            ObserverService::notify($message);
        }
    }

    public function siteFallCheck()
    {
        $config = Cfg::getInstance();
        $sites = SiteService::check();
        $notWorkSite = $sites['notify'];
        $uppedSites = $sites['upped'];
        $text = "<b>Хей</b>\nКакой-то непорядок со следующими сайтами:";
        if (count($notWorkSite) > 0) {
            foreach ($notWorkSite as $site) {
                $text .= ("\n<a href='" . $site['url'] . "'>" . $site['url'] . "</a>  Код ответа: " . $site['code'] . " Дата: " . $site['date']);
            }
            foreach ($config->get('chats') as $chat) {
                Telegram::send($chat['tg'], $text);
            }
            AdminService::notify($text);
        }

        if (count($uppedSites) > 0) {
            $text = "<b>Хей</b>\nПоднялись сайты:";
            foreach ($uppedSites as $site) {
                $text .= ("\n<a href='" . $site['url'] . "'>" . $site['url'] . "</a>  Код ответа: " . $site['code'] . " Дата: " . $site['date']);
            }
            foreach ($config->get('chats') as $chat) {
                Telegram::send($chat['tg'], $text);
            }
            AdminService::notify($text);
        }

    }

    public function inform($data)
    {
        if (!isset($data['user'])) {
            return ['status' => 'error', 'error' => 'Не указан пользователь'];
        }

        if (!isset($data['message'])) {
            return ['status' => 'error', 'error' => 'Не указан текст уведомления'];
        }

        $source = '';
        if (isset($data['source'])) {
            $source = $data['source'];
        }
        $users = [];
        if (is_array($data['user'])) {
            foreach ($data['user'] as $userId) {
                $user = UserService::getUserByRedmineId($userId);
                if ($user) {
                    $users[] = $user;
                }
            }
        } else {
            $user = UserService::getUserByRedmineId($data['user']);
            if ($user) {
                $users[] = $user;
            }
        }

        if (count($users) == 0) {
            return ['status' => 'error', 'error' => 'Не удалось найти таких пользователей'];
        }

        if (isset($data['title'])) {
            $title = $data['title'];
        } else {
            $title = '';
        }

        $messageText = NotifyService::prepareNotifyMessage($title, $source, $data['message']);
        foreach ($users as $user) {
            $result = Telegram::send($user['telegram'], $messageText);
            if (!empty($data['file'])) {
                Telegram::sendDocument($user['telegram'], $data['file']["tmp_name"],
                    "notification." . pathinfo($data['file']['name'])['extension']);
            }
            if (!empty($data['json'])) {
                file_put_contents("assets/notification.json", $data['json']);
                Telegram::sendDocument($user['telegram'], 'assets/notification.json', "notification.json");
                unlink('assets/notification.json');
            }
        }

        if (!$result['ok']) {
            return ['status' => 'error', 'error' => $result['description']];
        }

        return ['status' => 'success', 'error' => ''];

    }

    public function setCommand($commands)
    {
        Telegram::setCommand($commands);
    }

    public function tasksLifetime()
    {
        return SiteService::sitesStatics();
    }

    public function closestEvent()
    {
        $Event = new Events();
        return $Event->getClosest();

    }

    public function runTasks()
    {
        return TimerService::getAllActiveTimers();
    }

    public function test()
    {
        ini_set('default_charset', 'UTF-8');
        ini_set('display_errors', E_ALL);
        echo '<pre>';

        echo '</pre>';
    }
}