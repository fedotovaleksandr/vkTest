<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 02.01.2016
 * Time: 20:20
 */
include_once('../config.php');
$testData = [
    'name' => [
        'chocolate', 'orange', 'coca-cola', 'fanta', 'chips',
        'mouse', 'book', 'skateboard', 'cake', 'cheese',
        'cream', 'egg', 'milk', 'olives', 'pepper',
        'sweets', 'honey', 'pie', 'ham', 'loaf'
    ],
    'price' => [
        10, 20, 30, 40, 50,
        100, 200, 300, 400, 500,
        0.1, 0.2, 0.3, 0.4, 0.5,
        1, 2, 3, 4, 5
    ],
    'description' => [
        'Best product', 'Bad product', 'Sweety', 'It is amazing product',
        'cool! it is future', 'U must take it', 'Just do it', 'Use it every day',
        'for the most intelligent', 'With it flying to space', 'Community choose this!'
    ],
    'url' => [
        'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRnWJt68o4WKItcJgce5bn-jyrSlTeK49CZoojG2RICmd1B_Fkx2Q',
        'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcTfCq1AaCyW-O841tAelRTFhrJmgSWzgc25bzF186fiioFYkE9Mhg',
        'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcSKhmL2BS4Zs5CX2GndFCFClq6ibvH7U5gLamCrbmTLMDSUtJiT',
        'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcRuke28RSwbM_A3kXvFx5R6WETOeaWdF6nGm8_VHkivE6Rk9lF2',
        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThJ4c-3nEQPiTnqZTUxnHXcC_I7c15maOfjfrDtE-0v5UDUGjQ',
        'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcTW0wtmXRNgtDYbrWTZ_Oqi8xdBjmQ3gfcTqcq-XgoG4ZDfxBtt7Q',
        'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTh6IQXVrTmLBdT2Q0Gjq1OcyXgV8bUfxngTGyHQvgE_Cg2uEZm',
        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbHga_X0e7tprKX_4990ROIMbgfzXsa_EZ4Dyi7TdviTyTeYrqjA',
        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRNMCUTMtNngCo34EgxqtuL9qkptPjn7LRD0uB-qxSIUpWXzv6fFw',
        'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcSj6zG155XS5XFgCWJuO2osIdmFrVegKPVzy66Pw3AZg95ywzShpg',
        'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcTVhWtGEVqZmW_ugPKeYMY5-7lNOkG29lDhdRqcEVO8P0RYpAmE0A',
        'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcS8Ar32rgQXtna8HTswngaOyYwydBdVkCDe-L0JxwFUDwbDcB0u8w',
        'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcScJUCfbhIHMWDXgPq-TTM8mhtCwUvvFkN05uUez-P3mMpx3OZEzg' .
        'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcTewPvWbwFJZ64pi3tiWvmedE8d6ktCW0mieX8kvBVbPlKiuBBS',
        'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcTp5FGw0cknyPePbTW5aaXlFHxLp58oLXbvCueGMq9wNBHouoyM',
        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTpReMyWKTySif6mH-dBZwrFkZeX8PYssmT5p9ezwJGNnhtcf7rdw',
        'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcT9LFE1pfK5Uhe72RoFAnXi7EBBofxx0EXe-bUTUWhj6tz30K78',
        'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcSnkKwDQLWjGwzZ4vjt2BlwvrmXJ3NVx75pCqQVCr-b_70siAJj',
        'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcRgdtmlVJ1t4mIuwJLyrTvekEvqW-7S1UWq2RMy9je0TJUgW6iNNw'
    ]

];
function generateTestItem($testData)
{

    $randomField = function ($name) use ($testData) {

        $count = count($testData[$name]);
        return $testData[$name][rand(0, $count - 1)];
    };

    $item = [
        'name' => "'" . $randomField('name') . "'",
        'price' => $randomField('price'),
        'description' => "'" . $randomField('description') . "'",
        'url' => "'" . $randomField('url') . "'",
    ];
    return $item;
}

;

$dbName = 'db_vktest';
$dbParam = $config['databases'][$dbName];

$mysqli = mysqli_connect($dbParam['host'], $dbParam['user'], $dbParam['password'], $dbName, $dbParam['port']);
if (mysqli_connect_errno()) {
    echo "Can't connect to MySQL: " . mysqli_connect_error();
    exit();
}
for ($i = 0 ; $i < 1000000; $i++)
{
    $testItem = generateTestItem($testData);
    mysqli_query($mysqli, "INSERT INTO item (name,description,price,url) VALUES ({$testItem['name']},{$testItem['description']},{$testItem['price']},{$testItem['url']})");
    mysqli_query($mysqli, "UPDATE store SET countitems = countitems + 1 WHERE idstore = 1");
    echo("row : {$i}\n");
}
mysqli_close($mysqli);


