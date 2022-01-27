<?php

require_once 'vendor/autoload.php';
$faker = Faker\Factory::create();
$faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));


for($i = 0; $i < 10; $i++) {
    echo $faker->productName . ", " . $faker->numberBetween(200000, 2000000) . PHP_EOL;
}