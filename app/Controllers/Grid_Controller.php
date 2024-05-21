<?php

namespace App\Controllers;

use App\Models\Grid_Model;

use CodeIgniter\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $authorMatricula = $this->request->getPost('author_matricula');
        $newStatus = $this->request->getPost('new_status');
        //dd($authorName,$newStatus);
        $model = new Grid_Model();
        $result = $model->updateStatus($authorMatricula, $newStatus);

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
        return $this->response->setJSON(['success' => false, 'message' => 'A pasta não existe.']);
    }

    $upload_dir = FCPATH . 'uploads/' . $matricula;

    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Não foi possível criar o diretório de uploads.']);
        }
    }

    $zip_path = $upload_dir . "/" . $matricula . '.zip';
    
    if (!$this->is_dir_empty($pasta_path)) {
        $zip = new \ZipArchive();
        if ($zip->open($zip_path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
            return $this->response->setJSON(['success' => false, 'message' => 'Não foi possível criar o arquivo ZIP.']);
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
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'A pasta está vazia.']);
    }

    if (!file_exists($zip_path)) {
        return $this->response->setJSON(['success' => false, 'message' => 'O arquivo ZIP não foi encontrado.']);
    }

    // Atualiza o status no banco de dados
    $autorModel = new Grid_Model();
    $autorModel->updateStatusByMatricula($matricula, 'BAIXADO');

    $download_url = base_url('uploads/' . $matricula . '/' . $matricula . '.zip');

    return $this->response->setJSON(['success' => true, 'message' => 'Arquivo baixado com sucesso.', 'download_url' => $download_url]);
}


    public function download_todas_pastas()
    {
        $pasta_path = FCPATH . 'assets';
        
        if (!is_dir($pasta_path)) {
            return redirect()->back()->with('error', 'A pasta não existe.');
        }
    
        $upload_dir = WRITEPATH . 'uploads';
        
        // Verifica se o diretório de uploads existe, se não, tenta criar
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                return redirect()->back()->with('error', 'Não foi possível criar o diretório de uploads.');
            }
        }
    
        $zip_path = $upload_dir . '/assets.zip'; // Caminho onde o arquivo ZIP será criado
        
        // Verifica se a pasta está vazia
        if (!$this->is_dir_empty($pasta_path)) {
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
        } else {
            return redirect()->back()->with('error', 'A pasta está vazia.');
        }
    
        if (!file_exists($zip_path)) {
            return redirect()->back()->with('error', 'O arquivo ZIP não foi encontrado.');
        }
    
        return $this->response->download($zip_path, null)->setFileName('Documentos.zip');
    }
    
    // Função para verificar se um diretório está vazio
    protected function is_dir_empty($dir) {
        if (!is_readable($dir)) return NULL;
        return (count(scandir($dir)) == 2);
    }
    
    public function pegar_protocolo_detalhes()
    {
        $id = $this->request->getPost('id');
        $gridModel = new Grid_Model();
        $data = $gridModel->find($id);

        if ($data) {
            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Dados não encontrados.']);
        }
    }

    public function exportar_excel()
    {
        $model = new Grid_Model();
        $protocolos = $model->getAllProtocolos();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Definir os cabeçalhos
        $sheet->setCellValue('A1', 'Ano');
        $sheet->setCellValue('B1', 'Matricula');
        $sheet->setCellValue('C1', 'Nome');
        $sheet->setCellValue('D1', 'CPF');
        $sheet->setCellValue('E1', 'Situação');
        $sheet->setCellValue('F1', 'Tipo Categoria');
        $sheet->setCellValue('G1', 'Valor');
        $sheet->setCellValue('H1', 'Identidade');
        $sheet->setCellValue('I1', 'Orgao Emissor');
        $sheet->setCellValue('J1', 'Estado Civil');
        $sheet->setCellValue('K1', 'Endereco');
        $sheet->setCellValue('L1', 'Numero');
        $sheet->setCellValue('M1', 'Bairro');
        $sheet->setCellValue('N1', 'Cidade');
        $sheet->setCellValue('O1', 'Estado');
        $sheet->setCellValue('P1', 'Cep');
        $sheet->setCellValue('Q1', 'Telefone');
        $sheet->setCellValue('R1', 'Celular');
        $sheet->setCellValue('S1', 'E-mail');
        $sheet->setCellValue('T1', 'Data e Hora Envio');
        $sheet->setCellValue('U1', 'Ip');
        $sheet->setCellValue('V1', 'Complemento');
        $sheet->setCellValue('W1', 'Codigo');
        $sheet->setCellValue('X1', 'Banco');
        $sheet->setCellValue('Y1', 'Agência');
        $sheet->setCellValue('Z1', 'Operação');
        $sheet->setCellValue('AA1', 'Conta com dígito');


        // Adicionar os dados
        $row = 2;
        foreach ($protocolos as $protocolo) {
            $sheet->setCellValue('A' . $row, $protocolo['protocol_anoprotocolo']);
            $sheet->setCellValue('B' . $row, $protocolo['protocol_matricula']);
            $sheet->setCellValue('C' . $row, $protocolo['protocol_nome']);
            $sheet->setCellValue('D' . $row, $protocolo['protocol_cpf']);
            $sheet->setCellValue('E' . $row, $protocolo['protocol_situacaoprofissional']);
            $sheet->setCellValue('F' . $row, $protocolo['protocol_tipocategoria']);
            $sheet->setCellValue('G' . $row, $protocolo['protocol_valor']);
            $sheet->setCellValue('H' . $row, $protocolo['protocol_identidade']);
            $sheet->setCellValue('I' . $row, $protocolo['protocol_orgaoexped']);
            $sheet->setCellValue('J' . $row, $protocolo['protocol_estadocivil']);
            $sheet->setCellValue('K' . $row, $protocolo['protocol_endereco']);
            $sheet->setCellValue('L' . $row, $protocolo['protocol_numero']);
            $sheet->setCellValue('M' . $row, $protocolo['protocol_bairro']);
            $sheet->setCellValue('N' . $row, $protocolo['protocol_cidade']);
            $sheet->setCellValue('O' . $row, $protocolo['protocol_estado']);
            $sheet->setCellValue('P' . $row, $protocolo['protocol_cep']);
            $sheet->setCellValue('Q' . $row, $protocolo['protocol_telefone']);
            $sheet->setCellValue('R' . $row, $protocolo['protocol_celular']);
            $sheet->setCellValue('S' . $row, $protocolo['protocol_email']);
            $sheet->setCellValue('T' . $row, $protocolo['protocol_datahoraenvio']);
            $sheet->setCellValue('U' . $row, $protocolo['protocol_ipmaquina']);
            $sheet->setCellValue('V' . $row, $protocolo['protocol_complemento']);
            $sheet->setCellValue('W' . $row, $protocolo['protocol_codigo']);
            $sheet->setCellValue('X' . $row, $protocolo['protocol_banco']);
            $sheet->setCellValue('Y' . $row, $protocolo['protocol_agencia']);
            $sheet->setCellValue('Z' . $row, $protocolo['protocol_operacao']);
            $sheet->setCellValue('AA' . $row, $protocolo['protocol_contadigito']);


            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'protocolos.xlsx';

        // Redefinir cabeçalhos para download do arquivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    // public function delete($id)
    // {
    //     $protocoloModel = new Grid_Model();
    //     $protocoloModel->deleteProtocolo($id);
    //     return redirect()->back()->with("status", "O Protocolo foi deletado");
    // }

}
