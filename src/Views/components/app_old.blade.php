<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="https://unpkg.com/@sakun/system.css" />
</head>
<style>
    /* Applying system fonts */
    table {
        border-collapse: collapse;
        width: 100%;
        margin: 20px 0;
        background-color: #fff;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px 12px;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    /* Scrollbar customizations */
    table::-webkit-scrollbar {
        width: 16px;
        background-color: #fff;
    }

    table::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 8px;
    }

    table::-webkit-scrollbar-thumb:hover {
        background-color: #555;
    }

    table::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
</style>

<body>
    {{ $slot }}
</body>

</html>