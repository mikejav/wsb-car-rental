<?php

/**
 * DataGrid related stuff:
 */

function printTable($addEditLink, $selectable, $columnDefs, $rows) { ?>
    <div class="card h-100 d-flex flex-grow-1">
        <div class="card-header d-flex align-items-baseline justify-content-between">
            <div>Liczba rekordów: <b><?=count($rows)?></b></div>
            <a href="<?=$addEditLink?>" class="btn btn-primary ml-auto">Dodaj</a>
        </div>
        <div class="table-responsive h-100">
            <table class="table m-0">
                <thead>
                    <tr>
                        <?php if($selectable): ?>
                            <th class="w-01 align-top">
                                [x] Akcje
                            </th>
                        <?php endif ?>
                        <?php foreach($columnDefs as $column): ?>
                            <th><?=$column['columnDisplayName']?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($rows as $row): ?>
                        <tr>
                            <?php if($selectable): ?>
                                <td class="align-middle p-0 m-0">
                                    <div class="d-flex p-2">
                                        <a href="<?=$addEditLink?>?id=<?=$row['id']?>" class="btn btn-sm btn-outline-warning">Edytuj</a>
                                        &nbsp;
                                        <form action="" method="POST" class="d-inline">
                                            <input type="hidden" name="DELETE_ROW_ID" value="<?=$row['id']?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" name="DELETE_ROW" value="DELETE_ROW">Usun</button>
                                        </form>
                                    </div>
                                </td>
                            <?php endif ?>
                            <?php foreach($columnDefs as $column): ?>
                                <td>
                                    <?php
                                        if (isset($column['valueFormatter'])) {
                                            $value = $row[$column['columnKey']];
                                            echo $column['valueFormatter']($value);
                                        } else {
                                            echo $row[$column['columnKey']];
                                        }
                                    ?>
                                </td>
                            <?php endforeach ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
<?php }

/**
 * Flash message related stuff:
 */

function printFlashMessage() {
    if (!isset($_SESSION['flashMessage'])) {
        return;
    }

    echo '<div class="alert alert-success mb-4">'.$_SESSION['flashMessage']
            .'<button type="button" class="close" onclick="location.reload(true); return false;">'
                .'<span aria-hidden="true">&times;</span>'
            .'</button>'
        .'</div>';
    $_SESSION['flashMessage'] = null;
}

/**
 * Form related stuff:
 */

function getTextField($name, $label, $value) {
    return "<input type=\"text\" class=\"form-control\" id=\"$name\" name=\"entityValues[$name]\" value=\"$value\">";
}

function getNumberField($name, $label, $value) {
    return "<input type=\"number\" class=\"form-control\" id=\"$name\" name=\"entityValues[$name]\" value=\"$value\">";
}

function getDateField($name, $label, $value) {
    return "<input type=\"date\" class=\"form-control\" id=\"$name\" name=\"entityValues[$name]\" value=\"$value\">";
}

function getSelectField($name, $label, $options, $value) {
    $result = "<select class=\"custom-select\" id=\"$name\" name=\"entityValues[$name]\">";

    foreach($options as $key => $label) {
        $isSelected = $key == $value;
        $result .= "<option value=\"$key\"".($isSelected ? ' selected' : '').">$label</option>";
    }

    $result .= "</select>";

    return $result;
}

function getTextareaField($name, $label, $value) {
    return "<textarea class=\"form-control\" id=\"$name\" name=\"entityValues[$name]\" rows=\"3\"></textarea>";
}

function printForm($cancelLink, $fieldDefs, $formValues) {
    echo '<form action="" method="POST">';
    foreach($fieldDefs as $fieldDef) {
        $fieldName = $fieldDef['name'];
        $fieldLabel = $fieldDef['label'];
        $fieldValue = $formValues[$fieldName] ?? null;
        $isRequiredAsterisk = isset($fieldDef['required']) ? '<span class="text-danger ml-1 noselect">*</span>' : '';
        echo '<div class="form-group row mb-3">';
        echo '<label for="'.$fieldName.'" class="col-sm-3 col-form-label">'.$fieldLabel.$isRequiredAsterisk.'</label>';
        echo '<div class="col-sm-9">';
        switch($fieldDef['type']) {
            case 'TEXT':
                echo getTextField($fieldDef['name'], $fieldDef['label'], $fieldValue);
                break;
            case 'TEXTAREA':
                echo getTextareaField($fieldDef['name'], $fieldDef['label'], $fieldValue);
                break;
            case 'NUMBER':
            case 'DOUBLE':
                echo getNumberField($fieldDef['name'], $fieldDef['label'], $fieldValue);
                break;
            case 'DATE':
                echo getDateField($fieldDef['name'], $fieldDef['label'], $fieldValue);
                break;
            case 'SELECT':
                echo getSelectField($fieldDef['name'], $fieldDef['label'], $fieldDef['options'], $fieldValue);
                break;
        }
        echo '</div></div>';
    }

    echo "<div class=\"d-flex\">"
            ."<div class=\"ml-auto\">"
                ."<a href=\"$cancelLink\" class=\"btn btn-secondary ml-auto mr-1\">Anuluj</a>"
                ."<button type=\"submit\" class=\"btn btn-primary ml-auto\">Zapisz</button>"
            ."</div>"
        ."</div>";

    echo '</form>';
}

function printFormErrors($errors) {
    echo '<div class="alert alert-danger mb-4"><ul class="mb-0">';
    foreach($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul></div>";
}
