<?php

require 'pdo.php';

$pdo = getPdo();

$faker = Faker\Factory::create();

$stmt = $pdo->prepare("
    INSERT INTO product (name, description, price, image_url)
    VALUES (:name, :description, :price, :image_url)
");

for ($i = 0; $i < 500; $i++) {
    $stmt->execute([
        ':name' => $faker->word,
        ':description' => $faker->sentence,
        ':price' => $faker->randomFloat(1, 5, 50),
        ':image_url' => $faker->imageUrl(640, 480, 'products', true)
    ]);
}

echo 'Produits insérés avec succès.' . PHP_EOL;