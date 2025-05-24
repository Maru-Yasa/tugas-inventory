<?php

return function ($db) {
    $db->query("
        CREATE TABLE tb_invoices (
            id SERIAL PRIMARY KEY,
            kode_invoice VARCHAR(20) NOT NULL UNIQUE,
            total DOUBLE PRECISION
        );
    ");

    $db->query("
        CREATE TABLE tb_invoice_items (
            id SERIAL PRIMARY KEY,
            invoice_id INTEGER NOT NULL REFERENCES tb_invoices(id) ON DELETE CASCADE,
            items_id INTEGER NOT NULL REFERENCES tb_inventory(id) ON DELETE CASCADE,
            item_name VARCHAR(255) NOT NULL,
            quantity INTEGER NOT NULL CHECK (quantity > 0),
            price DOUBLE PRECISION NOT NULL CHECK (price >= 0),
            subtotal DOUBLE PRECISION GENERATED ALWAYS AS (quantity * price) STORED
        );
    ");
};