<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Product;
use App\PriceDescription;
use App\UnitType;
use App\ProductGroup;
use App\FileTag;
use App\File;
use App\Supplier;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        'code' => $faker->isbn10,
        'ean' => $faker->ean13,
        'name' => $faker->word,
        'description' => $faker->paragraph(3),
        'product_group_id' => function() {
            return factory('App\ProductGroup')->create()->id;
        },
        'image_file_id' => function() {
            return factory('App\File')->create()->id;
        },
        'supplier_id' => function() {
            return factory('App\Supplier')->create()->id;
        }
    ];
});

$factory->define(UnitType::class, function (Faker $faker) {
    /*
    $unitTypes = [
        ['name' => 'm2',    'order' => 0],
        ['name' => 'stk',   'order' => 1],
        ['name' => 'm',     'order' => 2],
        ['name' => 'rs',    'order' => 3],
        ['name' => 'pl',    'order' => 4],
        ['name' => 'pk',    'order' => 5],
        ['name' => 'tim',   'order' => 6],
        ['name' => 'mm',    'order' => 7],
        ['name' => 'm3',    'order' => 8],
        ['name' => 'cm2',    'order' => 9],
        ['name' => 'mm2',    'order' => 10],
        ['name' => 'cm3',    'order' => 11],
    ];

    $randomIndex = array_rand($unitTypes);

    return [
        'name' => $unitTypes[$randomIndex]['name'],
        'description' => $faker->paragraph(2)
    ];*/

    return [
        'name' => $faker->lexify('??'),
        'description' => $faker->paragraph(2)
    ];
});

$factory->define(ProductGroup::class, function (Faker $faker) {
    return [
        'code' => $faker->isbn10,
        'name' => $faker->word,
        'description' => $faker->paragraph(2)
    ];
});

$factory->define(FileTag::class, function (Faker $faker) {
    return [
        'name' => 'File tag '.$faker->word,
        'description' => $faker->paragraph(2)
    ];
});

$factory->define(PriceDescription::class, function (Faker $faker) {
    return [
        'product_id' => function() {
            return factory('App\Product')->create()->id;
        },
        'unit_type_id' => function() {
            return factory('App\UnitType')->create()->id;
        },
        'unit_price' => $faker->randomFloat(2, 0.0, 100000.0),
        'is_historic' => $faker->boolean
    ];
});

$factory->define(File::class, function (Faker $faker) {
    return [
        'file_tag_id' => function() {
            return factory('App\FileTag')->create()->id;
        },
        'name' => $faker->colorName,
        'uri' => $faker->imageUrl(200, 200),
        'ext' => $faker->fileExtension
    ];
});

$factory->define(Supplier::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->companyEmail,
        'phone' => $faker->phoneNumber
    ];
});