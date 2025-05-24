<?php
namespace Maru\Inventory\Controllers;

use Maru\Inventory\Core\Controller;
use Maru\Inventory\Core\DB;
use Maru\Inventory\Core\Request;

class IndexController extends Controller
{
    protected function getDataTable()
    {
        return DB::make()
            ->select('tb_inventory', '*', [
                "ORDER" => [
                    'id' => 'DESC'
                ]
            ]);
    }

    public function index()
    {            
        return $this->render('pages.inventory', [
            'data' => $this->getDataTable(),
            'state' => 'list'
        ]);
    }

    public function create()
    {
        $request = new Request();

        if ($request->isMethod('POST')) {
            $data = $request->all();
            unset($data['id']);

            DB::make()
                ->insert('tb_inventory', $data);

            $request->redirect('/inventory');
        }

        return $this->render('pages.inventory', [
            'data' => $this->getDataTable(),
            'state' => 'create'
        ]);
    }  

    public function edit()
    {
        $request = new Request();
        
        if (!$request->has('id')) {
            $request->redirect('/inventory');
        }

        if ($request->isMethod('POST')) {
            $data = $request->all();

            if ((!(bool) $data['status_barang']) && $data['jumlah_barang'] > 0) {
                $data['status_barang'] = true;
            }
            
            DB::make()
                ->update('tb_inventory', $data, ['id' => $data['id']]);
            $request->redirect('/inventory');
        }

        return $this->render('pages.inventory', [
            'data' => $this->getDataTable(),
            'state' => 'edit',
            'edit' => $request->all()['id']
        ]);
    }

    public function destroy()
    {
        $request = new Request();
        if (!$request->has('id')) {
            $request->redirect('/inventory');
        }

        DB::make()
            ->delete('tb_inventory', ['id' => $request->all()['id']]);

        $request->redirect('/inventory');
    }
}
