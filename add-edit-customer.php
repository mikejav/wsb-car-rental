<?php

require_once('./common/bootstrap.php');

guardPage();

$fieldDefs = [
    [
        'name' => 'firstName',
        'type' => 'TEXT',
        'label' => 'Imie',
        'required' => true,
    ],
    [
        'name' => 'lastName',
        'type' => 'TEXT',
        'label' => 'Nazwisko',
        'required' => true,
    ],
    [
        'name' => 'email',
        'type' => 'TEXT',
        'label' => 'Email',
        'required' => true,
    ],
    [
        'name' => 'type',
        'type' => 'SELECT',
        'label' => 'Typ',
        'options' => CLIENT_TYPE,
        'required' => true,
    ],
    [
        'name' => 'address1',
        'type' => 'TEXT',
        'label' => 'Adres',
        'required' => true,
    ],
    [
        'name' => 'address2',
        'type' => 'TEXT',
        'label' => 'Adres c.d.',
    ],
    [
        'name' => 'city',
        'type' => 'TEXT',
        'label' => 'Miasto',
        'required' => true,
    ],
    [
        'name' => 'postcode',
        'type' => 'TEXT',
        'label' => 'Kod pocztowy',
        'required' => true,
    ],
];

$formValues = null;
$editMode = isset($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validationErrors = validateFormValues($fieldDefs, $_POST['entityValues']);
    if (empty($validationErrors)) {
        if ($editMode) {
            updatEentityInTable('customers', $fieldDefs, $_POST['entityValues'], $_GET['id']);
            $_SESSION['flashMessage'] = 'Zmiany zostały zapisane pomyślnie';
        } else {
            $valuesToInsert = array_merge($_POST['entityValues'], [
                'createdAt' => date('Y-m-d H:i:s'),
            ]);
            var_export($valuesToInsert);
            $fieldDefsToInseert = array_merge($fieldDefs, [
                [
                    'name' => 'createdAt',
                    'type' => 'TEXT',
                ]
            ]);
            insertFormToTable('customers', $fieldDefsToInseert, $valuesToInsert);
            $_SESSION['flashMessage'] = 'Klient został dodany pomyślnie';
        }
        header("Location: customers.php");
        exit();
    }
    $formValues = $_POST['entityValues'];
} elseif ($editMode) {
    $escapedId = $dbConnection->real_escape_string($_GET['id']);
    $sql="SELECT * FROM customers WHERE id='$escapedId'";
    if($result = $dbConnection->query($sql)) {
        if ($result->num_rows) {
            $formValues = $result->fetch_assoc();
        }
    }
}

require_once('templates/header.php');
printHeader([
    'title' => $editMode ? 'Edycja klienta' : 'Dodaj klienta',
    'breadcrumbs' => [
        [
            'label' => 'Wypożyczalnia samochodów',
            'link' => '.'
        ],
        [
            'label' => 'Klienci',
            'link' => 'customers.php'
        ],
        [
            'label' => $editMode ? 'Edycja klienta' : 'Dodaj klienta',
        ],
    ],
    'includeHr' => true,
]);

if (isset($validationErrors) && !empty($validationErrors)) {
    printFormErrors($validationErrors);
}

printForm('customers.php', $fieldDefs, $formValues);

require_once('templates/footer.php');
