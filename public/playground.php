<?php

use \Illuminate\Support\Collection;

require __DIR__ . "/../vendor/autoload.php";

$nums = new Collection([
    1, 2, 3, 4, 5, 6, 7, 8, 9, 10
]);

if ($nums->contains(10)) {
    die("It contains 10");
}

$nums->filter()