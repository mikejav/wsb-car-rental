<?php

require_once('./common/bootstrap.php');

guardPage();

if (isset($_POST['DELETE_ROW'])) {
    $rowId = $_POST['DELETE_ROW_ID'];
    $sqlToPrepare = 'DELETE FROM customers WHERE id=?';
    $stmt = $dbConnection->prepare($sqlToPrepare);
    $stmt->bind_param('i', $rowId);
    $stmt->execute();
    $_SESSION['flashMessage'] = 'Klient został usunięty pomyślnie';
    header("Location: customers.php");
    exit();
}

require_once('templates/header.php');

printHeader([
    'title' => 'Klienci',
    'action' => [
        'link' => 'add-edit-customer.php',
        'label' => 'Dodaj klienta +',
    ],
    'breadcrumbs' => [
        [
            'label' => 'Wypożyczalnia samochodów',
            'link' => '.'
        ],
        [
            'label' => 'Klienci',
        ],
    ],
]);

$sql = "SELECT * FROM customers";
$result = $dbConnection->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

$columnDefs = [
    [
        'columnKey' => 'email',
        'columnDisplayName' => 'Email',
    ],
    [
        'columnKey' => 'firstName',
        'columnDisplayName' => 'Imie',
    ],
    [
        'columnKey' => 'lastName',
        'columnDisplayName' => 'Nazwisko',
    ],
    [
        'columnKey' => 'type',
        'columnDisplayName' => 'Typ',
        'valueFormatter' => function($value) { return CLIENT_TYPE[$value]; },
    ],
    [
        'columnKey' => 'address1',
        'columnDisplayName' => 'Adres',
    ],
    [
        'columnKey' => 'address2',
        'columnDisplayName' => 'Adres c.d.',
    ],
    [
        'columnKey' => 'city',
        'columnDisplayName' => 'Miasto',
    ],
    [
        'columnKey' => 'postcode',
        'columnDisplayName' => 'Kod pocztowy',
    ],
    [
        'columnKey' => 'createdAt',
        'columnDisplayName' => 'Data utworzenia',
    ],
];

printFlashMessage();
printTable('add-edit-customer.php', true,  $columnDefs, $rows);
require_once('templates/footer.php');
