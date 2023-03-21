<?php
//Задание 1
$data = [
    'question' => ['почему', 'как', 'зачем', 'столько'],
    'animals' => [
        'birds' => [
            [
                'name' => 'грачи',
            ],
            [
                'name' => 'воробьи',
            ],
        ],
        'others' => [
            [
                ['name' => 'кошки'],
                ['name' => 'рыбы'],
                ['name' => 'собаки'],
            ],
        ],
    ],
    'parts' => [
        'hands' => 'рук',
        'feathers' => 'перьев',
        'eyes' => 'глаз',
    ],
];

/* ===== Ваш код ниже ===== */

echo $data['question'][0] . " " . $data['animals']['birds'][0]['name'] . " не " . $data['animals']['others'][0][0]['name'] .
    " и " . $data['question'][2] . " им " . $data['question'][3] . " " . $data['parts']['feathers'];

//Задание 2

// гаражи
$garages = [
    1 => ['id' => 1, 'name' => 'Гараж на улице 1', 'size' => 1],
    7 => ['id' => 7, 'name' => 'Подземная парковка', 'size' => 100],
    23 => ['id' => 23, 'name' => 'У домика в деревне', 'size' => 2],
];

// машины
$cars = [
    ['name' => 'Белый Ford', 'garageId' => 7],
    ['name' => 'Черный Уаз', 'garageId' => 1],
    ['name' => 'Синий Таз', 'garageId' => 7],
];

/* ===== Ваш код ниже ===== */

foreach ($cars as $index => $car) {
    echo 'Машина "' . $car['name'] . '" стоит в "' . $garages[$car['garageId']]['name'] . '"' . PHP_EOL;
}

//Задание 3
$cars = [
    ['name' => 'Такси 1', 'position' => rand(0, 1000), 'isFree' => (bool)rand(0, 1)],
    ['name' => 'Такси 2', 'position' => rand(0, 1000), 'isFree' => (bool)rand(0, 1)],
    ['name' => 'Такси 3', 'position' => rand(0, 1000), 'isFree' => (bool)rand(0, 1)],
    ['name' => 'Такси 4', 'position' => rand(0, 1000), 'isFree' => (bool)rand(0, 1)],
    ['name' => 'Такси 5', 'position' => rand(0, 1000), 'isFree' => (bool)rand(0, 1)],
];

$passenger = rand(0, 1000);

/* ===== Ваш код ниже ===== */
$minDist = 1000;
$closestCar = -1;
$dist = 0;
$result = [];
foreach ($cars as $key => $car) {
    $dist = abs($car['position'] - $passenger);
    $result[$key] = $car['name'] . ', стоит на ' . $car['position'] . ' км, до пассажира ' . $dist . ' км ' . ($car['isFree'] ? '(свободен)' : '(занят)');
    if ($car['isFree'] && $minDist > $dist) {
        $closestCar = $key;
        $minDist = $dist;
    }
}
if ($closestCar !== -1) {
    $result[$closestCar] .= ' - едет это такси';
}
foreach ($result as $line) {
    echo $line . PHP_EOL;
}



