<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

// Получение полного имени из ФИО

function getFullnameFromParts($surname, $name, $patronymic){
    return "$surname $name $patronymic";
};

// Получение частей ФИО из полного имени

function getPartsFromFullname($fullname){
    $parts = explode(' ', $fullname);
    return [
        'surname'=> $parts[0],
        'name'=> $parts[1],
        'patronymic'=> $parts[2],
    ];
};

foreach ($example_persons_array as $person){
    $parts = getPartsFromFullname($person['fullname']);
    $fullname = getFullnameFromParts($parts['surname'], $parts['name'], $parts['patronymic']);
};

// Сокращение до фамилии и инициала имени

function getShortName($fullname){
    $short = explode(' ', $fullname);
    $shortSurname = $short[0];
    $shortName = mb_substr($short[1], 0, 1) . '.' ;
    return $shortSurname . ' ' . $shortName;
};

foreach ($example_persons_array as $person){
    $shortName = getShortName($person['fullname']);
};

// Определение пола по ФИО

$summaryOfSexF = 0;
$summaryOfSexM = 0;

function getGenderFromName ($fullname){

    $parts =  getPartsFromFullname($fullname);

    if (mb_substr($parts['surname'], -2) === 'ва'
        || mb_substr($parts['name'], -1) === 'а'
        || mb_substr($parts['patronomyc'], -3) === 'вна')
    {
        $summaryOfSexF--;
    }
    if (mb_substr($parts['surname'], -1) === 'в'
        || mb_substr($parts['name'], -1) === 'й'
        || mb_substr($parts['name'], -1) === 'н'
        || mb_substr($parts['patronomyc'], -2) === 'ич')
    {
         $summaryOfSexM++;
    }
    
    //Функция, которая выводит суммарный индекс пола
    function showSumGenderIndex(){
        echo 'суммарный индекс пола: '.($summaryOfSexF <=> $summaryOfSexM);
    }
};
   