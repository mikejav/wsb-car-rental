<?php

require_once('./common/bootstrap.php');

$fieldDefs = [
    [
        'name' => 'manufacturer',
        'type' => 'TEXT',
        'label' => 'Producent',
        'required' => true,
    ],
    [
        'name' => 'model',
        'type' => 'TEXT',
        'label' => 'Model',
        'required' => true,
    ],
    [
        'name' => 'describtion',
        'type' => 'TEXTAREA',
        'label' => 'Opis',
    ],
    [
        'name' => 'production_date',
        'type' => 'DATE',
        'label' => 'Data produkcji',
        'required' => true,
    ],
    [
        'name' => 'first_registration_date',
        'type' => 'DATE',
        'label' => 'Data pierwszej rejestracji',
        'required' => true,
    ],
    [
        'name' => 'color',
        'type' => 'SELECT',
        'label' => 'Kolor',
        'options' => COLORS,
        'required' => true,
    ],
    [
        'name' => 'doors_count',
        'type' => 'NUMBER',
        'label' => 'Ilość drzwi',
        'required' => true,
    ],
    [
        'name' => 'engine_displacement',
        'type' => 'DOUBLE',
        'label' => 'Pojemność skokowa',
        'required' => true,
    ],
    [
        'name' => 'fuel_type',
        'type' => 'SELECT',
        'label' => 'Rodzaj paliwa',
        'options' => PETROL_TYPES,
        'required' => true,
    ],
];

$formValues = null;
$editMode = isset($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validationErrors = validateFormValues($fieldDefs, $_POST['entityValues']);
    if (empty($validationErrors)) {
        if ($editMode) {
            updatEentityInTable('vehicles', $fieldDefs, $_POST['entityValues'], $_GET['id']);
            $_SESSION['flashMessage'] = 'Zmiany zostały zapisane pomyślnie';
        } else {
            insertFormToTable('vehicles', $fieldDefs, $_POST['entityValues']);
            $_SESSION['flashMessage'] = 'Pojazd został dodany pomyślnie';
        }
        header("Location: vehicles.php");
        exit();
    }
    $formValues = $_POST['entityValues'];
} elseif ($editMode) {
    $escapedId = $dbConnection->real_escape_string($_GET['id']);
    $sql="SELECT * FROM vehicles WHERE id='$escapedId'";
    if($result = $dbConnection->query($sql)) {
        if ($result->num_rows) {
            $formValues = $result->fetch_assoc();
        }
    }
}

require_once('templates/header.php');
printHeader([
    'title' => $editMode ? 'Edycja pojazdu' : 'Dodaj pojazd',
    'breadcrumbs' => [
        [
            'label' => 'Wypożyczalnia samochodów',
            'link' => '.'
        ],
        [
            'label' => 'Pojazdy',
            'link' => 'vehicles.php'
        ],
        [
            'label' => $editMode ? 'Edycja pojazdu' : 'Dodaj pojazd',
        ],
    ],
    'includeHr' => true,
]);

if (isset($validationErrors) && !empty($validationErrors)) {
    printFormErrors($validationErrors);
}

printForm('vehicles.php', $fieldDefs, $formValues);

require_once('templates/footer.php');
