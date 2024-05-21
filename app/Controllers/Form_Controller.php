<?php

namespace App\Controllers;

use App\Models\Autor_Model;
use CodeIgniter\Controller;

use PhpOffice\PhpWord\TemplateProcessor;
class Form_Controller extends Controller {

    public function index() {
        return view("FormConsultaNome");
    }

    public function baixardocumento() {
        $matricula = $this->request->getPost('matricula');
        $model = new Autor_Model();
        // dd($usuario);
        $protocolo = $model->getProtocolo($matricula);
        return view('FormUploadImage', ['matricula' => $matricula, 'nome' => $protocolo->protocol_nome, 'ehupdate' => isset($protocolo) ? 'sim' : 'nao']);
    }

    public function generateProcuracao()
    {
        $matricula = $this->request->getGet('matricula');
        $model = new Autor_Model();
        $protocolo = $model->getProtocolo($matricula);
        // dd($protocolo);
        // Caminho para o template do arquivo Word
        $templatePath = FCPATH . 'template/procuracao_e_declaracao_hipossuficiencia.docx';
        // Caminho para salvar o arquivo gerado
        $savePath = WRITEPATH . 'uploads/' . date('YmdHis') . '.docx';

        // Crie uma nova instância do TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);

        // Substitua as variáveis no template
        setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'pt_BR.utf8');

        // Substitua as variáveis no template com os dados do usuário
        $templateProcessor->setValue('nome', $protocolo->protocol_nome);
        $templateProcessor->setValue('estado_civil', $protocolo->protocol_estadocivil);
        $templateProcessor->setValue('cargo', $protocolo->protocol_situacaoprofissional);
        $templateProcessor->setValue('matricula', $protocolo->protocol_matricula);
        $templateProcessor->setValue('cpf', $protocolo->protocol_cpf);
        $templateProcessor->setValue('rg', $protocolo->protocol_identidade);
        $templateProcessor->setValue('orgao_expedidor', $protocolo->protocol_orgaoexped);
        $templateProcessor->setValue('endereco', $protocolo->protocol_endereco);
        $templateProcessor->setValue('numero', $protocolo->protocol_numero);
        $templateProcessor->setValue('complemento', $protocolo->protocol_complemento ?? ''); // Verifica se é null
        $templateProcessor->setValue('bairro', $protocolo->protocol_bairro);
        $templateProcessor->setValue('cidade', $protocolo->protocol_cidade);
        $templateProcessor->setValue('uf', $protocolo->protocol_estado);
        $templateProcessor->setValue('cep', $protocolo->protocol_cep);
        $templateProcessor->setValue('telefone', $protocolo->protocol_telefone);
        $templateProcessor->setValue('email', $protocolo->protocol_email);
    
        // Formate a data em português brasileiro
        $dataFormatada = $this->formatarDataEmPortugues(date('Y-m-d'));
    $templateProcessor->setValue('data', $dataFormatada);
        // Salve o arquivo gerado
        $templateProcessor->saveAs($savePath);

        return $this->response->download($savePath, null)->setFileName('procuracao_e_declaracao_hipossuficiencia.docx');
    }

    private function formatarDataEmPortugues($data) {
        $meses = [
            '01' => 'janeiro',
            '02' => 'fevereiro',
            '03' => 'março',
            '04' => 'abril',
            '05' => 'maio',
            '06' => 'junho',
            '07' => 'julho',
            '08' => 'agosto',
            '09' => 'setembro',
            '10' => 'outubro',
            '11' => 'novembro',
            '12' => 'dezembro'
        ];
    
        $dia = date('d', strtotime($data));
        $mes = $meses[date('m', strtotime($data))];
        $ano = date('Y', strtotime($data));
    
        return " {$dia} de {$mes} de {$ano}";
    }

    public function verificar()
    {
        $matricula = $this->request->getPost('matricula');
        $model = new Autor_Model();
        $usuario = $model->verificarUsuario($matricula);
        if (!$usuario) {
            return view('FormConsultaNome', ['erro' => 'Prezado(a), 
            A sua matricula não consta na listagem dos autores do processo de 1/3 de férias. 
            Favor entrar em contato com o departamento jurídico do Sindicato pelo telefone (99)9999-9999 falar com Xxxx']);
        } else if ($usuario->autor_statusdocumentos != "NULL") {
            $protocolo = $model->getProtocolo($matricula);
            // dd($protocolo);
            return view('FormAddDados', ['protocolo' => $protocolo, 'nome' => $usuario->autor_nome,'matricula' => $matricula]);
        }
        return view("FormAddDados", ['nome' => $usuario->autor_nome, 'matricula' => $matricula]);
    }

    public function salvardocumento()
    {   
        $matricula = $this->request->getPost('matricula');
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
        $banco = $this->request->getPost('banco');
        $agencia = $this->request->getPost('agencia');
        $operacao = $this->request->getPost('operacao');
        $contadigito = $this->request->getPost('contadigito');

        $ehupdate = $this->request->getPost('ehupdate');

        if($ehupdate == "sim"){
            $ehupdate = true;
            $model = new Autor_Model();
            $model->atualizarProtocolo($matricula,$nome, $email, $telefone, $cpf, $cep, $logradouro, $cidade, $bairro, $estado, $complemento, $ip,$rg,$exp,$civil,$numero,$banco,$agencia,$operacao,$contadigito);
        } else {
            $ehupdate = null;
            $model = new Autor_Model();
            $model->criarProtocolo($matricula,$nome, $email, $telefone, $cpf, $cep, $logradouro, $cidade, $bairro, $estado, $complemento, $ip,$rg,$exp,$civil,$numero,$banco,$agencia,$operacao,$contadigito);    
        }
       
        $model = new Autor_Model();
        $usuario = $model->verificarUsuario($matricula);
        $matricula = $usuario->autor_matricula;

        return view('FormBaixarDocumento', ['matricula' => $matricula]);
    }

    public function salvarimagem()
    {
        $ehupdate = $this->request->getPost('ehupdate');
        $matricula = $this->request->getPost('matricula');
        //var_dump($_POST);dd($_FILES);
        // Initialize the variable
        if ($ehupdate == "1") {
            $matriculaFolder = FCPATH.'assets/'. $matricula;
            
            if(isset($_FILES['pdfId']['tmp_name'])){
                if (is_dir($matriculaFolder)) {
                    // Remove existing files
                    unlink($matriculaFolder . '/identificacao.pdf');
                }
                move_uploaded_file($_FILES['pdfId']['tmp_name'], $matriculaFolder . '/identificacao.pdf');
            }

            if(isset($_FILES['pdfComprovante']['tmp_name'])){
                if (is_dir($matriculaFolder)) {
                    // Remove existing files
                    unlink($matriculaFolder . '/residencia.pdf');
                }
                move_uploaded_file($_FILES['pdfComprovante']['tmp_name'], $matriculaFolder . '/residencia.pdf');
            }

            if(isset($_FILES['imgContrato']['tmp_name'])){
                if (is_dir($matriculaFolder)) {
                    // Remove existing files
                    unlink($matriculaFolder . '/contrato.png');
                }
                move_uploaded_file($_FILES['imgContrato']['tmp_name'], $matriculaFolder . '/contrato.png');
            }
        } else {
            // Create a new folder with the value of matricula
            $matriculaFolder = FCPATH.'assets/'. $matricula;
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

        return $this->response->setJSON(['codigo' => $codigo]);

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
