<?php

namespace App\Controllers;

use App\Models\Grid_Model;;
use CodeIgniter\Controller;

class Grid_Controller extends Controller {

    public function index() {
        $gridModel = new Grid_Model();
        $data['protocolosrecebidos'] = $gridModel->getAllProtocolos();
        return view("Grid",$data);
    }

    public function delete($id)
    {
        $protocoloModel = new Grid_Model();
        $protocoloModel->deleteProtocolo($id);
        return redirect()->back()->with("status", "O Protocolo foi deletado");
    }

}
