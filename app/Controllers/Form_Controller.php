<?php

namespace App\Controllers;

use App\Models\Autor_Model;
use CodeIgniter\Controller;

class Form_Controller extends Controller {

    public function index() {
        return view("FormConsultaNome");
    }

    public function baixardocumento() {
        $nome = $this->request->getPost('nome');
        $model = new Autor_Model();
        $usuario = $model->verificarUsuario($nome);
        if ($usuario->autor_statusdocumentos != "NULL") {
            $protocolo = $model->getProtocolo($nome);
            return view('FormAddDados', ['protocolo' => $protocolo]);
        }
        return view("FormAddDados", ['nome' => $nome]);
    }

    public function verificar()
    {
        $nome = $this->request->getPost('nome');
        $model = new Autor_Model();
        $usuario = $model->verificarUsuario($nome);
        if (!$usuario) {
            return view('FormConsultaNome', ['erro' => 'Prezado(a), 
            O seu nome não consta na listagem dos autores do processo de 1/3 de férias. 
            Favor entrar em contato com o departamento jurídico do Sindicato pelo telefone (99)9999-9999 falar com Xxxx']);
        } else if ($usuario->autor_statusdocumentos != "NULL") {
            return view("FormBaixarDocumento", ['nome' => $nome]);
        }
        return view('FormBaixarDocumento', ['nome' => $nome]);
    }

    public function salvardocumento()
    {   
        $nome = $this->request->getPost('nome');
        $email = $this->request->getPost('email');
        $telefone = $this->request->getPost('telefone');
        $cpf = str_replace(['.', '-'], '', $this->request->getPost('cpf'));
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

        $ehupdate = $this->request->getPost('ehupdate');

        if($ehupdate == "sim"){
            $ehupdate = true;
            $model = new Autor_Model();
            $model->atualizarProtocolo($nome, $email, $telefone, $cpf, $cep, $logradouro, $cidade, $bairro, $estado, $complemento, $ip,$rg,$exp,$civil,$numero);
        } else {
            $ehupdate = false;
            $model = new Autor_Model();
            $model->criarProtocolo($nome, $email, $telefone, $cpf, $cep, $logradouro, $cidade, $bairro, $estado, $complemento, $ip,$rg,$exp,$civil,$numero);    
        }
       
        $model = new Autor_Model();
        $matricula = $model->getMatricula($nome);

        return view('FormUploadImage', ['matricula' => $matricula, 'nome' => $nome, 'ehupdate' => $ehupdate]);
    }

    public function salvarimagem()
    {
        $ehupdate = $this->request->getPost('ehupdate');
        $matricula = $this->request->getPost('matricula');

        // Initialize the variable
        if ($ehupdate == "sim") {
            // Update existing files
            $matriculaFolder = '/path/to/folder/' . $matricula;
            if (is_dir($matriculaFolder)) {
                // Remove existing files
                unlink($matriculaFolder . '/identificacao.pdf');
                unlink($matriculaFolder . '/residencia.pdf');
                unlink($matriculaFolder . '/contrato.png');
            }

            // Add the updated files
            move_uploaded_file($_FILES['pdfId']['tmp_name'], $matriculaFolder . '/identificacao.pdf');
            move_uploaded_file($_FILES['pdfComprovante']['tmp_name'], $matriculaFolder . '/residencia.pdf');
            move_uploaded_file($_FILES['imgContrato']['tmp_name'], $matriculaFolder . '/contrato.png');
        } else {
            // Create a new folder with the value of matricula
            $matriculaFolder = '/path/to/folder/' . $matricula;
            if (!is_dir($matriculaFolder)) {
                mkdir($matriculaFolder, 0777, true);
            }

            // Add the files
            move_uploaded_file($_FILES['pdfId']['tmp_name'], $matriculaFolder . '/identificacao.pdf');
            move_uploaded_file($_FILES['pdfComprovante']['tmp_name'], $matriculaFolder . '/residencia.pdf');
            move_uploaded_file($_FILES['imgContrato']['tmp_name'], $matriculaFolder . '/contrato.png');
        }

        $model = new Autor_Model();
        $protocolo = $model->getProtocoloMatricula($matricula);



        $codigo = $protocolo->protocol_anoprotocolo.'-'.$protocolo->protocol_id;
        $model->setCodigo($matricula, $codigo);
        return view('FormUploadImage', ['codigo' => $codigo,'matricula' => $matricula, 'ehupdate' => $ehupdate]);

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
