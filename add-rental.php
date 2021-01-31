<?php

require_once('./common/bootstrap.php');

guardPage();

require_once('templates/header.php');

$segment = $_GET['segment'] ?? $_POST['segment'] ?? null;
$vehicleId = $_GET['vehicleId'] ?? $_POST['vehicleId'] ?? null;
$customerId = $_GET['customerId'] ?? $_POST['customerId'] ?? null;
$fromDate = $_GET['fromDate'] ?? $_POST['fromDate'] ?? null;
$toDate = $_GET['toDate'] ?? $_POST['toDate'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sqlToPrepare = "INSERT INTO rentals (fromDate, toDate, customerId, vehicleId) VALUES (?, ?, ?, ?)";
    $stmt = $dbConnection->prepare($sqlToPrepare);
    $stmt->bind_param('ssii', $fromDate, $toDate, $customerId, $vehicleId);
    $stmt->execute();
    header("Location: rentals.php");
    $_SESSION['flashMessage'] = 'Wypożyczenie zostało dodane pomyśłnie';
    exit($dbConnection->error);
}

printHeader([
    'title' => 'Wypożycz pojazd',
    'breadcrumbs' => [
        [
            'label' => 'Wypożyczalnia samochodów',
            'link' => '.'
        ],
        [
            'label' => 'Wypożyczenia',
            'link' => 'rentals.php'
        ],
        [
            'label' => 'Wypożycz pojazd',
        ],
    ],
    'includeHr' => true,
]);

function segmentStep() { ?>
    <h2 class="mb-4">Wybierz segment</h2>
    <div class="list-group">
        <?php foreach(VEHICLE_SEGMENT as $key => $value): ?>
            <a href="add-rental.php?segment=<?=$key?>" class="list-group-item list-group-item-action"><b><?=$value?></b> - <?=VEHICLE_SEGMENT_TO_DESCRIBTION_MAP[$value]?></a>
        <?php endforeach ?>
    </div>
<?php }

function vehicleStep() {
    global $dbConnection, $segment;

    $segmentEscaped = $dbConnection->real_escape_string($segment);
    $sql = "SELECT * FROM vehicles WHERE segment = '$segmentEscaped'";
    $vehicles = $dbConnection->query($sql)->fetch_all(MYSQLI_ASSOC);
    
    ?>
    <h2 class="mb-4">Wybierz pojazd</h2>
    <div class="list-group">
        <?php foreach($vehicles as $vehicle): ?>
            <a href="add-rental.php?vehicleId=<?=$vehicle['id']?>" class="list-group-item list-group-item-action">
                <div class="row">
                    <div class="col-3">
                        <?=$vehicle['manufacturer'].' '.$vehicle['model']?>
                    </div>
                    <div class="col-3">
                        Data produkcji: <?=$vehicle['production_date']?>
                    </div>
                    <div class="col-3">
                        Typ paliwa: <?=PETROL_TYPE[$vehicle['fuel_type']]?>
                    </div>
                </div>
            </a>
        <?php endforeach ?>
    </div>
    <?php
}

function customerStep() {
    global $dbConnection, $vehicleId;

    $sql = "SELECT * FROM customers";
    $customers = $dbConnection->query($sql)->fetch_all(MYSQLI_ASSOC);
    
    ?>
    <h2 class="mb-4">Wybierz klienta</h2>
    <div class="list-group">
        <?php foreach($customers as $customer): ?>
            <a href="add-rental.php?vehicleId=<?=$vehicleId?>&customerId=<?=$customer['id']?>" class="list-group-item list-group-item-action">
                <div class="row">
                    <div class="col-7"><?=$customer['firstName']?> <?=$customer['lastName']?></div>
                    <div class="col-5">(<?=$customer['email']?>)</div>
                </div>
            </a>
        <?php endforeach ?>
    </div>
    <?php
}

function dateRangeStep() {
    global $vehicleId, $customerId;
    ?>
    <h2 class="mb-4">Wybierz przedział czasu wypożyczenia</h2>
    <form action="add-rental.php" method="GET">
        <input type="hidden" name="vehicleId" value="<?=$vehicleId?>">
        <input type="hidden" name="customerId" value="<?=$customerId?>">
        <div class="form-group row mb-3">
            <label for="fromDate" class="col-sm-1 col-form-label">Od<span class="text-danger ml-1 noselect">*</span></label>
            <div class="col-sm-4"><input type="date" class="form-control" id="fromDate" name="fromDate" required></div>
        </div>
        <div class="form-group row mb-3">
            <label for="toDate" class="col-sm-1 col-form-label">Do<span class="text-danger ml-1 noselect">*</span></label>
            <div class="col-sm-4"><input type="date" class="form-control" id="toDate" name="toDate" required></div>
        </div>
        <button type="submit" class="btn btn-primary ml-auto">Dalej</button>
    </form>
    <?php
}

function summaryStep() {
    global $dbConnection, $vehicleId, $customerId, $fromDate, $toDate;

    $vehicleIdEscaped = $dbConnection->real_escape_string($vehicleId);
    $sql = "SELECT * FROM vehicles WHERE id='$vehicleIdEscaped'";
    $vehicle = $dbConnection->query($sql)->fetch_all(MYSQLI_ASSOC)[0];
    
    $customerIdEscaped = $dbConnection->real_escape_string($customerId);
    $sql = "SELECT * FROM customers WHERE id='$customerIdEscaped'";
    $customer = $dbConnection->query($sql)->fetch_all(MYSQLI_ASSOC)[0];

    ?>
    <h2 class="mb-4">Podsumowanie</h2>


    <form action="add-rental.php" method="POST">

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Pojazd</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="<?=$vehicle['manufacturer'].' '.$vehicle['model'].', '.PETROL_TYPE[$vehicle['fuel_type']].', Rok produkcji: '.$vehicle['production_date']?>">
                <input type="hidden" name="vehicleId" value="<?=$vehicleId?>">
            </div>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Klient</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="<?=$customer['firstName']?> <?=$customer['lastName']?> (<?=$customer['email']?>)">
                <input type="hidden" name="customerId" value="<?=$customerId?>">
            </div>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Od</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="<?=$fromDate?>">
                <input type="hidden" name="fromDate" value="<?=$fromDate?>">
            </div>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Do</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="<?=$toDate?>">
                <input type="hidden" name="toDate" value="<?=$toDate?>">
            </div>
        </div>
  
        <div class="d-flex">
            <div class="ml-auto">
                <a href="rentals.php" class="btn btn-secondary ml-auto mr-1">Anuluj</a>
                <button type="submit" class="btn btn-primary ml-auto">Zapisz</button>
            </div>
        </div>
</form>
    <?php
}

if (!$segment && !$vehicleId) {
    segmentStep();
} elseif (!$vehicleId) {
    vehicleStep();
} elseif (!$customerId) {
    customerStep();
} elseif (!$fromDate || !$toDate) {
    dateRangeStep();
} else {
    summaryStep();
}

require_once('templates/footer.php');
