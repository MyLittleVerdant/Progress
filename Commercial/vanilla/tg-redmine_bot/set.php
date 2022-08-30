<?php
require 'vendor/autoload.php';

$kernel = new \TgRedmine\Kernel();
$kernel->setCommand([
    ['command' => 'report', 'description' => 'Отчет по проектам'],
    ['command' => 'day_report', 'description' => 'Отчет по задачам за день'],
    ['command' => 'food', 'description' => 'Рейтинг еды'],
    ['command' => 'stars', 'description' => 'Игра в шерифа'],
    ['command' => 'dice', 'description' => 'кубик рубик'],
    ['command' => 'inactive', 'description' => 'неактивные задачи'],
    ['command' => 'know', 'description' => 'если че-то не знаешь'],
    ['command' => 'coffee', 'description' => 'кубик рубик решит кто варит кофе'],
    ['command' => 'disable', 'description' => 'отключить таймеры'],
    ['command' => 'whoiam', 'description' => 'выводит инфу по тебе'],
    ['command' => 'plan', 'description' => 'запланированные задачи'],
    ['command' => 'check', 'description' => 'проверка сертификатов и доменов'],
    ['command' => 'create', 'description' => 'создание сайта на бегете. Пример: /create test-bot.testers-site.ru'],
    ['command' => 'overtime', 'description' => 'Отчет по переработкам'],
    ['command' => 'deadlines', 'description' => 'Выводит список дедлайнов незакрытх задач'],

]);