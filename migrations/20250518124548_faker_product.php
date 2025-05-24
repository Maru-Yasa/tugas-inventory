<?php

require __DIR__ . '/../vendor/autoload.php';


return function ($db) {
    $faker = Faker\Factory::create('id_ID');

    for ($i=0; $i < 100; $i++) { 
        $db->insert('tb_inventory', [
            'kode_barang'    => strtoupper('BRG' . $faker->unique()->numerify('####')),
            'nama_barang'    => $faker->words(3, true),
            'jumlah_barang'  => $faker->numberBetween(1, 100),
            'satuan_barang'  => $faker->randomElement(['pcs', 'dus', 'pak', 'kg']),
            'harga_beli'     => $faker->randomFloat(2, 1000, 500000),
            'status_barang'  => true
        ]);
    }

};