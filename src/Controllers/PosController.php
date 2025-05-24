<?php

namespace Maru\Inventory\Controllers;

use Maru\Inventory\Core\Controller;
use Maru\Inventory\Core\DB;
use Maru\Inventory\Core\Request;

class PosController extends Controller
{
    public function index()
    {
        $products = DB::make()
            ->select('tb_inventory', '*', [
                "ORDER" => [
                    'id' => 'DESC'
                ]
            ]);

        $this->render('pages.pos', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $request = new Request();

        if (!$request->has('cart_items')) {
            $this->index();
        }

        $items = json_decode($request->all()['cart_items'], true);
        $data = [];
        $total = 0;
        $products = [];
        foreach ($items as $item) {
            $actualItem = DB::make()->get('tb_inventory', '*', [
                'id' => $item['id']
            ]);

            $products[$actualItem['id']] = $actualItem;

            $subtotal = $actualItem['harga_beli'] * $item['qty'];
            $total += $subtotal;
            $data[] = [
                'items_id' => $item['id'],
                'item_name' => $actualItem['nama_barang'],
                'quantity' => $item['qty'],
                'price' => $actualItem['harga_beli'],
            ];
        }

        $db = DB::make();

        $db->insert('tb_invoices', [
                'kode_invoice' => substr(bin2hex(random_bytes(10)), 0, 20),
                'total' => $total
            ]);

        $invoiceId = $db->id();

        foreach ($data as $item) {
            $currentStock = $products[$item['items_id']]['jumlah_barang'] - $item['quantity'];

            DB::make()
                ->update('tb_inventory', [
                    'jumlah_barang' => $currentStock,
                    'status_barang' => !$currentStock <= 0
                ], ['id' => $item['items_id']]);

            DB::make()
                ->insert('tb_invoice_items', [
                    ...$item,
                    'invoice_id' => $invoiceId
                ])->queryString;
        }


        $request->redirect('/pos');
    }
}
