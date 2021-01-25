<?php

require_once('./common/bootstrap.php');

if (isset($_POST['DELETE_ROW'])) {
    $rowId = $_POST['DELETE_ROW_ID'];
    $sqlToPrepare = 'DELETE FROM vehicles WHERE id=?';
    $stmt = $dbConnection->prepare($sqlToPrepare);
    $stmt->bind_param('i', $rowId);
    $stmt->execute();
    $_SESSION['flashMessage'] = 'Pojazd został usunięty pomyślnie';
    header("Location: vehicles.php");
    exit();
}

require_once('templates/header.php');

printHeader([
    'title' => 'Pojazdy',
    'action' => [
        'link' => 'add-edit-vehicle.php',
        'label' => 'Dodaj pojazd +',
    ],
    'breadcrumbs' => [
        [
            'label' => 'Wypożyczalnia samochodów',
            'link' => '.'
        ],
        [
            'label' => 'Pojazdy',
        ],
    ],
]);

$sql = "SELECT * FROM vehicles";
$result = $dbConnection->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

$columnDefs = [
    [
        'columnKey' => 'manufacturer',
        'columnDisplayName' => 'Producent',
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

printFlashMessage();
printTable('add-edit-vehicle.php', true,  $columnDefs, $rows);
require_once('templates/footer.php');
