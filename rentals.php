<?php

require_once('./common/bootstrap.php');

if (isset($_POST['DELETE_ROW'])) {
    $rowId = $_POST['DELETE_ROW_ID'];
    $sqlToPrepare = 'DELETE FROM rentals WHERE id=?';
    $stmt = $dbConnection->prepare($sqlToPrepare);
    $stmt->bind_param('i', $rowId);
    $stmt->execute();
    $_SESSION['flashMessage'] = 'Wypożyczenie zostało usunięte pomyślnie';
    header("Location: rentals.php");
    exit();
}

require_once('templates/header.php');

printHeader([
    'title' => 'Wypożyczenia',
    'action' => [
        'link' => 'add-rental.php',
        'label' => 'Dodaj wypożyczenie +',
    ],
    'breadcrumbs' => [
        [
            'label' => 'Wypożyczalnia samochodów',
            'link' => '.'
        ],
        [
            'label' => 'Wypożyczenia',
        ],
    ],
]);

$sql = "SELECT r.id, r.fromDate, r.toDate, CONCAT(c.firstName, ' ', c.lastName, ' (', c.email, ')') as customer, CONCAT(v.manufacturer, ' ', v.model) AS vehicle"
    ." FROM rentals AS r"
    ." INNER JOIN customers AS c ON c.id=r.customerId"
    ." INNER JOIN vehicles AS v ON v.id=r.vehicleId";
$result = $dbConnection->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

$columnDefs = [
    [
        'columnKey' => 'fromDate',
        'columnDisplayName' => 'Od',
    ],
    [
        'columnKey' => 'toDate',
        'columnDisplayName' => 'Do',
    ],
    [
        'columnKey' => 'customer',
        'columnDisplayName' => 'Klient',
    ],
    [
        'columnKey' => 'vehicle',
        'columnDisplayName' => 'Pojazd',
    ],
];

printFlashMessage();
printTable(null, true,  $columnDefs, $rows);
require_once('templates/footer.php');
