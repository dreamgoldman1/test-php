<?php

require "./ElectronicItem.php";
require "./ElectronicItems.php";

// Define constant types of articles
const ELECTRONIC_ITEM_TELEVISION = 'television';
const ELECTRONIC_ITEM_CONSOLE = 'console';
const ELECTRONIC_ITEM_MICROWAVE = 'microwave';
const ELECTRONIC_ITEM_CONTROLLER = 'controller';

// Items to be process by classes
$items = [
    [
        'productName' => 'Play Station 5',
        'price' => '3500000',
        'type' => ELECTRONIC_ITEM_CONSOLE,
        'extraItems' => [
            [
                'productName' => 'Wired Controller',
                'price' => '300000',
                'type' => ELECTRONIC_ITEM_CONTROLLER,
                'wired' => 1,
            ],
            [
                'productName' => 'Wired Controller',
                'price' => '300000',
                'type' => ELECTRONIC_ITEM_CONTROLLER,
                'wired' => 1,
            ],
            [
                'productName' => 'Remote Controller',
                'price' => '270000',
                'type' => ELECTRONIC_ITEM_CONTROLLER,
                'wired' => 0,
            ],
            [
                'productName' => 'Remote Controller',
                'price' => '270000',
                'type' => ELECTRONIC_ITEM_CONTROLLER,
                'wired' => 0,
            ],
        ],
    ],
    [
        'productName' => 'TV #1',
        'price' => '2000000',
        'type' => ELECTRONIC_ITEM_TELEVISION,
        'extraItems' => [
            [
                'productName' => 'Remote Controller',
                'price' => '100000',
                'type' => ELECTRONIC_ITEM_CONTROLLER,
                'wired' => 0,
            ],
            [
                'productName' => 'Remote Controller',
                'price' => '100000',
                'type' => ELECTRONIC_ITEM_CONTROLLER,
                'wired' => 0,
            ],
        ],
    ],
    [
        'productName' => 'TV #2',
        'price' => '2800000',
        'type' => ELECTRONIC_ITEM_TELEVISION,
        'extraItems' => [
            [
                'productName' => 'Remote Controller',
                'price' => '100000',
                'type' => ELECTRONIC_ITEM_CONTROLLER,
                'wired' => 0,
            ],
        ],
    ],
    [
        'productName' => 'MICROWAVE #1',
        'price' => '300000',
        'type' => ELECTRONIC_ITEM_MICROWAVE,
    ],
];

// Instance of ElectronicItems to create list of Items
$itemsClass = new ElectronicItems();

// Loop to read the $items array
foreach ($items as $item) {
    if (!empty($item['extraItems'])) {
        // Loop for instance of ElectronicItem to create Extra Items of Item
        foreach ($item['extraItems'] as $controller) {
            $item['extra'][] = new ElectronicItem($controller);
        }
    }
    // Instance of ElectronicItem to create each Item
    $itemClass = new ElectronicItem($item);
    // Add new Item to ElectronicItems
    $itemsClass->addItem($itemClass);
}

/**
 * BUILDING HTML
 */
// HTML Template
$template = file_get_contents("./views/index.html");

// Cretate an HTML to complete the table with the Items
$list = '';
$itemsList = $itemsClass->getSortItems();
foreach ($itemsList as $itemList){
    $list .= '<tr>
        <td>' . $itemList->getProductName() . '</td>
        <td>' . $itemList->getType() . '</td>
        <td>No</td>
        <td>' . $itemList->getWired() . '</td>
        <td>$' . number_format($itemList->getPrice(), 0, ',', '.') . '</td>
    </tr>';
    $extras = $itemList->getExtra();
    if (!empty($extras)){
        foreach ($extras as $extra){
            $list .= '<tr>
                <td>- ' . $extra->getProductName() . '</td>
                <td>' . $extra->getType() . '</td>
                <td>Yes</td>
                <td>' . $extra->getWired() . '</td>
                <td>$' . number_format($extra->getPrice(), 0, ',', '.') . '</td>
            </tr>';
        }
    }
}

$template = str_replace('{items-list}', $list, $template);

// Cretate an HTML to complete the table with the Total Price of Items
// Sum of item price and item's extra price
$totalAmount = '<tr class="table-total">
                <td colspan="4">TOTAL</td>
                <td>$' . number_format($itemsClass->getTotalPrice(), 0, ',', '.') . '</td>
            </tr>';

$template = str_replace('{total-amount}', $totalAmount, $template);

// Cretate an HTML to complete the table with the Items filter by type (CONSOLE)
$list = '';
$consoleItems = $itemsClass->getItemsByType(ELECTRONIC_ITEM_CONSOLE);
foreach ($consoleItems as $consoleItem){
    $list .= '<tr>
        <td>' . $consoleItem->getProductName() . '</td>
        <td>' . $consoleItem->getType() . '</td>
        <td>No</td>
        <td>' . $consoleItem->getWired() . '</td>
        <td>$' . number_format($consoleItem->getPrice(), 0, ',', '.') . '</td>
    </tr>';
    $extras = $consoleItem->getExtra();
    if (!empty($extras)){
        foreach ($extras as $extra){
            $list .= '<tr>
                <td>- ' . $extra->getProductName() . '</td>
                <td>' . $extra->getType() . '</td>
                <td>Yes</td>
                <td>' . $extra->getWired() . '</td>
                <td>$' . number_format($extra->getPrice(), 0, ',', '.') . '</td>
            </tr>';
        }
    }
}

$template = str_replace('{items-list-console}', $list, $template);

// Cretate an HTML to complete the table with the Total Price of Items by type (CONSOLE)
// Sum of item price and item's extra price
$totalAmount = '<tr class="table-total">
                <td colspan="4">TOTAL</td>
                <td>$' . number_format($itemsClass->getTotalPriceByType(ELECTRONIC_ITEM_CONSOLE), 0, ',', '.') . '</td>
            </tr>';

$template = str_replace('{total-amount-console}', $totalAmount, $template);

// Print the final HTML
echo $template;

?>