<?php

require_once('./common/bootstrap.php');

require_once('templates/header.php');

printform('vehicles.php' ,[
    getTextField('name', 'Nazwa'),
    getTextField('model', 'Model'),
    getTextareaField('describtion', 'Opis'),
    getDateField('production_date', 'Data produkcji'),
    getDateField('first_registration_date', 'Data pierwszej rejestracji'),
    getSelectField('color', 'Kolor', COLORS),
    getNumberField('doors_count', 'Ilość drzwi'),
    getNumberField('engine_displacement', 'Pojemność skokowa'),
    getSelectField('fuel_type', 'Rodzaj paliwa', PETROL_TYPES),
]);

require_once('templates/footer.php');
