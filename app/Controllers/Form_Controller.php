<?php

namespace App\Controllers;

use App\Models\Autor_Model;
use CodeIgniter\Controller;

class Form_Controller extends Controller {

    public function index() {
        return view("FormConsultaNome");
    }

    public function upload() {
        return view("FormAddDados");
    }

    public function image() {
        return view("FormUploadImage");
    }

    public function verificar()
    {
        $nome = $this->request->getPost('nome');

        $model = new Autor_Model();
        $usuario = $model->verificarUsuario($nome);

        if (!$usuario) {
            return view('FormConsultaNome', ['erro' => 'Usuário inexistente!']);
        } else if ($usuario->autor_statusdocumentos == 'RECEBIDO') {
            return view('FormConsultaNome', ['erro' => 'Documentos já recebidos!']);
        }

        return view('FormAddDados', ['nome' => $nome]);
    }

    public function salvardocumento()
    {   
        $nome = $this->request->getPost('nome');
        $email = $this->request->getPost('email');
        $telefone = $this->request->getPost('telefone');
        $cpf = $this->request->getPost('cpf');
        $cep = str_replace('-', '', $this->request->getPost('cep'));
        $logradouro = $this->request->getPost('logradouro');
        $cidade = $this->request->getPost('cidade');
        $bairro = $this->request->getPost('bairro');
        $estado = $this->request->getPost('estado');
        $complemento = $this->request->getPost('complemento');
        $numero = $this->request->getPost('numero');
        $ip = $this->get_client_ip();
        $rg = $this->request->getPost('rg');
        $exp = $this->request->getPost('exp');
        $civil = $this->request->getPost('civil');

        $model = new Autor_Model();
        $model->criarProtocolo($nome, $email, $telefone, $cpf, $cep, $logradouro, $cidade, $bairro, $estado, $complemento, $ip,$rg,$exp,$civil,$numero);

        $model = new Autor_Model();
        $matricula = $model->getMatricula($nome);
        $subfolder = $matricula;
        $subfolderPath = FCPATH . "assets/" . $subfolder;
        if (!is_dir($subfolderPath)) {
            mkdir($subfolderPath, 0777, true);
        }

        //salva documentos na pasta
        $targetFile = $subfolderPath . '/' . $_FILES['pdfCpf']['name'];
        move_uploaded_file($_FILES["pdfCpf"]["tmp_name"], $targetFile);
        $targetFile = $subfolderPath . '/' . $_FILES['pdfComprovante']['name'];
        move_uploaded_file($_FILES["pdfComprovante"]["tmp_name"], $targetFile);
        $targetFile = $subfolderPath . '/' . $_FILES['pdfContrato']['name'];
        move_uploaded_file($_FILES["pdfContrato"]["tmp_name"], $targetFile);

        return view('FormUploadImage', ['matricula' => $matricula]);
    }

    public function salvarimagem()
    {
        $matricula = $this->request->getPost('matricula');
        $subfolder = $matricula;
        $subfolderPath = FCPATH . "assets/" . $subfolder;
        if (!is_dir($subfolderPath)) {
            mkdir($subfolderPath, 0777, true);
        }

        $targetFile = $subfolderPath . '/' . $_FILES['imagem']['name'];
        move_uploaded_file($_FILES["imagem"]["tmp_name"], $targetFile);

        $codigo = '1234';
        $model = new Autor_Model();
        do {
            $codigo = rand(100000, 999999);
        } while ($model->checkCodigoExists($codigo));

        $model->setCodigo($matricula, $codigo);

        return $codigo;

        return view('FormUploadImage', ['codigo' => $codigo,'matricula' => $matricula]);
    }

    function get_client_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
