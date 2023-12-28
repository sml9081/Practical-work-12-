<?php

$persons = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester'
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer'
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst'
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer'
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst'
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer'
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager'
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager'
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst'
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer'
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter'
    ]
];

//$summaryOfSexF = 0;
//$summaryOfSexM = 0;

// Определение пола по ФИО
function getGenderFromName ($fullname){
    $parts = getPartsFromFullname($fullname);
    $summaryOfSexF = 0;
    $summaryOfSexM = 0;

    if (mb_substr($parts['surname'], -2) === 'ва'){
        $summaryOfSexF++;
    }
    if (mb_substr($parts['name'], -1) === 'а'){
        $summaryOfSexF++;
    }
    if (mb_substr($parts['patronymic'], -3) === 'вна'){
        $summaryOfSexF++;
    }
    if (mb_substr($parts['surname'], -1) === 'в'){
        $summaryOfSexM++;
    }
    if (mb_substr($parts['name'], -1) === 'н'){
        $summaryOfSexM++;
    }
    if (mb_substr($parts['patronymic'], -2) === 'ич'){
        $summaryOfSexM++;
    }

    $result = $summaryOfSexM <=> $summaryOfSexF;
    return ($result > 0) ? 'MAN' : (($result < 0) ? 'WOMAN' : 'UNDEFINED');
}

// Возвращает полное ФИО из частей имен
function getFullnameFromParts($surname, $name, $patronymic){
    return "$surname $name $patronymic";
}

// Получение частей ФИО из полного имени
function getPartsFromFullname($fullname){
    $parts = explode(' ', $fullname);
    return [
        'surname'=> $parts[0],
        'name'=> $parts[1],
        'patronymic'=> $parts[2]
    ];
}

// Возвращает короткое имя. Например, "Иван И."
function getShortName($fullname){
    $parts = getPartsFromFullname($fullname);
    return $parts['name'].' '.mb_substr($parts['surname'], 0, 1).'.';
}

// Определям пол по имени
function getGenderDescription($persons){
    if (count($persons) === 0){
        return 'Нет списка для обработки';
    }
    $men = 0;
    $women = 0;
    $undefined = 0;
    $total = count($persons);
    $gender = '';

    foreach ($persons as $i=>$person){
        $gender = getGenderFromName($person['fullname']);
        if ($gender === 'MAN'){
            $men++;
        }
        else if ($gender === 'WOMAN'){
            $women++;
        }
        else{
            $undefined++;
        }
    }

    $men_result = round($men/$total, 2);
    $women_result = round($women/$total, 2);
    $undefined_result = round($undefined/$total, 2);

    return 'Мужчины - '.$men_result.'%<br/>Женщины - '.$women_result.'%<br/>Не удалось определить - '.$undefined_result.'%<br/>';
}

// Приводим в верхний регистр первую букву, остальные строчные
function textToFirstUpperCase($txt){
    $t = mb_strtolower($txt);
    return mb_strtoupper(mb_substr($t, 0, 1)).mb_substr($t, 1);
}

// Генерация произвольного процента сходства между 50% и 100%
function randomPct(){
    return mt_rand(50, 100).'.'.mt_rand(0, 99).'%';
}

// Определение "идеальной" пары
function getPerfectPartner($surname, $name, $patronymic, $persons){
    // Приводим имя ко внутреннему формату
    $surname = textToFirstUpperCase($surname);
    $name = textToFirstUpperCase($name);
    $patronymic = textToFirstUpperCase($patronymic);

    // Собираем ФИО
    $full_name = getFullnameFromParts($surname, $name, $patronymic);

    // Опредеяем пол
    $gender = getGenderFromName($full_name);
    if ($gender === 'UNDEFINED'){
        return 'Невозможно определить пол для '.getShortName($full_name).'<br/>';
        
    }

    // Ищем идеального партнера
    $partner_index = null;
    $persons_amount = count($persons);
    $attempt = 0;
    $found_partner = false;
    while (true){
        if ($attempt > $persons_amount){
            break;
        }

        $partner_index = rand(0, $persons_amount - 1);
        $second_gender = getGenderFromName($persons[$partner_index]['fullname']);

        if ($second_gender !== 'UNDEFINED' && $second_gender !== $gender){
            $found_partner = true;
            break;
        }

        $attempt++;
    }

    if ($found_partner){
        return getShortName($full_name).' + '.getShortName($persons[$partner_index]['fullname']).' = <br/><span style="color: red;">&hearts;</span> Идеально на '.randomPct().' <span style="color: red;">&hearts;</span>';
    }
    else{
        return 'Для '.getShortName($full_name).' Не найдено пары...';
    }
}


// Выполнение заданий

// Просмотр исходного массива
echo 'Изначальный список:<br/>';
foreach ($persons as $i=>$person){
    echo 'Имя: <b>'.$person['fullname'].'</b>; Профессия: <b>'.$person['job'].'</b><br/>';
}

// Гендерный состав аудитории
echo '<br/><br/>Гендерный состав аудитории:<br/>';
echo getGenderDescription($persons);

// Поиск идеальной пары
echo '<br/><br/>Поиск идеальной пары для: АНТОНИНА ФЕДОРОВНА СИМОШКИНА:<br/>';
echo getPerfectPartner('СИМОШКИНА', 'АНТОНИНА', 'ФЕДОРОВНА', $persons);
echo '<br/><br/>Поиск идеальной пары для: ПетР Джельсоминович БУБА:<br/>';
echo getPerfectPartner('БУБА', 'ПетР', 'Джельсоминович', $persons);


   