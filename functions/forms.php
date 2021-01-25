<?php

function getTypesString($fieldDefs) {
    $result = "";

    foreach ($fieldDefs as $fieldDef) {
        switch($fieldDef['type']) {
            case 'NUMBER':
                $result .= 'i';
                break;
            case 'DOUBLE':
                $result .= 'd';
                break;
            case 'TEXT':
            case 'TEXTAREA':
            case 'DATE':
            case 'SELECT':
                $result .= 's';
                break;
            case 'BOOLEAN':
                $result .= 'b';
                break;
            default:
                throw new Exception('unsupported data type passed to getTypesString');
        }
    }

    return $result;
}

function insertFormToTable($tableName, $fieldDefs, $params) {
    global $dbConnection;

    $quotations = substr(str_repeat("?, ", count($params)), 0, -2);
    $columns = join(', ', array_keys($params));
    $sqlToPrepare = "INSERT INTO $tableName ($columns) VALUES ($quotations)";
    $stmt = $dbConnection->prepare($sqlToPrepare);
    $typeString = getTypesString($fieldDefs);
    $statementValues = array_values($params);
    $stmt->bind_param($typeString, ...$statementValues);
    $stmt->execute();
}

function updatEentityInTable($tableName, $fieldDefs, $params, $id) {
    global $dbConnection;

    $keysToUpdate = [];
    foreach($fieldDefs as $fieldDef) {
        $keysToUpdate[] = $fieldDef['name'];
    }
    $sqSetPart = join('=?, ', $keysToUpdate).'=?';

    $sqlToPrepare = "UPDATE $tableName SET $sqSetPart WHERE id=?";
    $stmt = $dbConnection->prepare($sqlToPrepare);
    $typeString = getTypesString($fieldDefs).'i';
    $statementValues = array_merge(array_values($params), [$id]);
    var_export($statementValues);
    $stmt->bind_param($typeString, ...$statementValues);
    $stmt->execute();
}

function validateFormValues($fieldDefs, $formValues) {
    $errors = [];
    foreach($fieldDefs as $fieldDef) {
        $fieldName = $fieldDef['name'];
        $fieldLabel = $fieldDef['label'];
        if (isset($fieldDef['required']) && $fieldDef['required'] && $formValues[$fieldName] == "") {
            array_push($errors, "Pole <i>$fieldLabel</i> jest wymagane");
        }
    }
    return $errors;
}
