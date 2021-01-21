<?php

/**
 * DataGrid related stuff:
 */

function printTable($addLink, $selectable, $columnDefs, $rows) { ?>
    <div class="card">
        <div class="card-header d-flex align-items-baseline justify-content-between">
            <div>Liczba rekordów: <b><?=count($rows)?></b></div>
            <a href="<?=$addLink?>" class="btn btn-primary ml-auto">Dodaj</a>
        </div>
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <?php if($selectable): ?>
                            <th class="w-01 align-top">
                                [x]
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
                                <td class="align-middle">[x]</td>
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
 * Form related stuff:
 */

function printform($cancelLink, $fields) { ?>
    <form action="" method="POST">
        <?php
        foreach ($fields as $field) {
            echo $field;
        }
        ?>
        <div class="d-flex">
            <div class="ml-auto">
                <a href="<?=$cancelLink?>" class="btn btn-secondary ml-auto mr-1">Anuluj</a>
                <button type="submit" class="btn btn-primary ml-auto">Zapisz</button>
            </div>
        </div>
    </form>
<?php }


function getTextField($name, $label, $value = '') {
    return "
        <div class=\"form-group row mb-3\">
            <label for=\"$name\" class=\"col-sm-3 col-form-label\">$label</label>
            <div class=\"col-sm-9\">
                <input type=\"text\" class=\"form-control\" id=\"$name\" nane=\"$name\" value=\"$value\">
            </div>
        </div>";
}

function getNumberField($name, $label, $value = '') {
    return "
        <div class=\"form-group row mb-3\">
            <label for=\"$name\" class=\"col-sm-3 col-form-label\">$label</label>
            <div class=\"col-sm-9\">
                <input type=\"number\" class=\"form-control\" id=\"$name\" nane=\"$name\" value=\"$value\">
            </div>
        </div>";
}

function getDateField($name, $label, $value = '') {
    return "
        <div class=\"form-group row mb-3\">
            <label for=\"$name\" class=\"col-sm-3 col-form-label\">$label</label>
            <div class=\"col-sm-9\">
                <input type=\"date\" class=\"form-control\" id=\"$name\" nane=\"$name\" value=\"$value\">
            </div>
        </div>";
}

function getSelectField($name, $label, $options, $value = '') {
    $result = "
        <div class=\"form-group row mb-3\">
            <label for=\"$name\" class=\"col-sm-3 col-form-label\">$label</label>
            <div class=\"col-sm-9\">
                <select class=\"custom-select\" id=\"$name\" nane=\"$name\">";

    foreach($options as $key => $value) {
        $result .= "<option value=\"$key\">$value</option>";
    }

    $result .= "</select></div></div>";

    return $result;
}

function getTextareaField($name, $label, $value = '') {
    return "
        <div class=\"form-group row mb-3\">
            <label for=\"$name\" class=\"col-sm-3 col-form-label\">$label</label>
            <div class=\"col-sm-9\">
                <textarea class=\"form-control\" id=\"$name\" nane=\"$name\" rows=\"3\"></textarea>
            </div>
        </div>";
}
