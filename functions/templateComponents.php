<?php


function printTable($addLink, $selectable, $columnDefs, $rows) { ?>
    <div class="card">
        <div class="card-header d-flex align-items-baseline justify-content-between">
            <div>Liczba rekordów: <?=count($rows)?></div>
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
