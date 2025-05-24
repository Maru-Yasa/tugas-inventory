<?php

return function ($db) {
    $db->query('
        CREATE TABLE tb_inventory (
            id SERIAL PRIMARY KEY,
            kode_barang VARCHAR(20) NOT NULL,
            nama_barang VARCHAR(50) NOT NULL,
            jumlah_barang INTEGER DEFAULT 0,
            satuan_barang VARCHAR(20),
            harga_beli DOUBLE PRECISION,
            status_barang BOOLEAN DEFAULT true
        );
    ');
};