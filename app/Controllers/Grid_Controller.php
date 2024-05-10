<?php

namespace App\Controllers;

use App\Models\Grid_Model;;

use CodeIgniter\Controller;

class Grid_Controller extends Controller
{

    public function index()
    {
        $gridModel = new Grid_Model();
        $data['protocolosrecebidos'] = $gridModel->getAllProtocolos();
        return view("Grid", $data);
    }

    public function atualizarStatus()
    {
        $authorName = $this->request->getPost('author_name');
        $newStatus = $this->request->getPost('new_status');
        //dd($authorName,$newStatus);
        $model = new Grid_Model();
        $result = $model->updateStatus($authorName, $newStatus);

        if ($result) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }

    public function download_pasta($matricula)
    {
        $pasta_path = FCPATH . 'assets/' . $matricula;
        
        if (!is_dir($pasta_path)) {

            return redirect()->back()->with('error', 'A pasta não existe.');
        }

        $zip_path = FCPATH . 'assets/' . $matricula . '.zip';
        $zip = new \ZipArchive();
        if ($zip->open($zip_path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
            return redirect()->back()->with('error', 'Não foi possível criar o arquivo ZIP.');
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($pasta_path),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($pasta_path) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();

        return $this->response->download($zip_path, null)->setFileName($matricula . '.zip');
    }

    // public function delete($id)
    // {
    //     $protocoloModel = new Grid_Model();
    //     $protocoloModel->deleteProtocolo($id);
    //     return redirect()->back()->with("status", "O Protocolo foi deletado");
    // }

}
