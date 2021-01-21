<?php

require_once('./common/bootstrap.php');

require_once('templates/header.php');

$sql = "SELECT * FROM vehicles";

$result = $dbConnection->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

function fuelTypeFormatter($value) {
    return value;
}

$columnDefs = [
    [
        'columnKey' => 'name',
        'columnDisplayName' => 'Nazwa',
    ],
    [
        'columnKey' => 'model',
        'columnDisplayName' => 'Model',
    ],
    [
        'columnKey' => 'describtion',
        'columnDisplayName' => 'Opis',
    ],
    [
        'columnKey' => 'production_date',
        'columnDisplayName' => 'Data produkcji',
    ],
    [
        'columnKey' => 'first_registration_date',
        'columnDisplayName' => 'Data pierwszej rejestracji',
    ],
    [
        'columnKey' => 'color',
        'columnDisplayName' => 'Kolor',
        'valueFormatter' => function($value) { return COLORS[$value]; },
    ],
    [
        'columnKey' => 'doors_count',
        'columnDisplayName' => 'Ilość drzwi',
    ],
    [
        'columnKey' => 'engine_displacement',
        'columnDisplayName' => 'Pojemność skokowa',
    ],
    [
        'columnKey' => 'fuel_type',
        'columnDisplayName' => 'Rodzaj paliwa',
        'valueFormatter' => function($value) { return PETROL_TYPES[$value]; },
    ],
];

printTable('add-vehicle.php', true,  $columnDefs, $rows);

require_once('templates/footer.php');
