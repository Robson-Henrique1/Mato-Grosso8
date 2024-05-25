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

    // Caminho para o template do arquivo Word
    // $templatePath = FCPATH . 'template/procuracao_e_declaracao_hipossuficiencia.docx';
    // Caminho para salvar o arquivo gerado
    // $savePath = WRITEPATH . 'uploads/' . date('YmdHis') . '.docx';

    // Crie uma nova instância do TemplateProcessor
    // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

    // Substitua as variáveis no template
    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'pt_BR.utf8');
    // $templateProcessor->setValue('nome', $protocolo->protocol_nome);
    // $templateProcessor->setValue('estado_civil', $protocolo->protocol_estadocivil);
    // $templateProcessor->setValue('cargo', $protocolo->protocol_situacaoprofissional);
    // $templateProcessor->setValue('matricula', $protocolo->protocol_matricula);
    // $templateProcessor->setValue('cpf', $protocolo->protocol_cpf);
    // $templateProcessor->setValue('rg', $protocolo->protocol_identidade);
    // $templateProcessor->setValue('orgao_expedidor', $protocolo->protocol_orgaoexped);
    // $templateProcessor->setValue('endereco', $protocolo->protocol_endereco);
    // $templateProcessor->setValue('numero', $protocolo->protocol_numero);
    // $templateProcessor->setValue('complemento', $protocolo->protocol_complemento ?? ''); // Verifica se é null
    // $templateProcessor->setValue('bairro', $protocolo->protocol_bairro);
    // $templateProcessor->setValue('cidade', $protocolo->protocol_cidade);
    // $templateProcessor->setValue('uf', $protocolo->protocol_estado);
    // $templateProcessor->setValue('cep', $protocolo->protocol_cep);
    // $templateProcessor->setValue('telefone', $protocolo->protocol_telefone);
    // $templateProcessor->setValue('email', $protocolo->protocol_email);

    // Formate a data em português brasileiro
    $dataFormatada = $this->formatarDataEmPortugues(date('Y-m-d'));
    // $templateProcessor->setValue('data', $dataFormatada);

    // Salve o arquivo gerado como DOCX
    // $templateProcessor->saveAs($savePath);

    // Converter DOCX para HTML
    // $phpWord = \PhpOffice\PhpWord\IOFactory::load($savePath);
    // $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
    // $htmlContent = $htmlWriter->getContent();

    // Adicionar estilo CSS para diminuir o tamanho da fonte
    $htmlContent = '
    <html>
    <head>
    <style>
    body {
        font-size: 15px; /* Aumente o tamanho da fonte aqui */
        line-height: 1.6;
        text-align: justify;
    }
    h1, h2, h3, h4, h5, h6 {
        text-align: center;
        font-weight: bold;
    }
    .page-break {
        page-break-before: always;
    }
</style>
    </head>
    <body>
    <h1>PROCURAÇÃO E PACTUAÇÃO DE HONORÁRIOS ADVOCATÍCIOS</h1>
    <p>OUTORGANTE:<br>
     Eu, ' . $protocolo->protocol_nome . ', brasileiro(a)
    ' . $protocolo->protocol_estadocivil . ', ' . $protocolo->protocol_situacaoprofissional . ',
    de Matrícula ' . $protocolo->protocol_matricula . ' inscrito(a) no CPF sob o n.º ' . $protocolo->protocol_cpf . ' e portador(a) da RG
    ' . $protocolo->protocol_identidade . ', expedida pelo(a) ' . $protocolo->protocol_orgaoexped . ',
    residente e domiciliado(a)  ' . $protocolo->protocol_endereco . ', ' . $protocolo->protocol_numero . ', ' . ($protocolo->protocol_complemento ?? '')  . $protocolo->protocol_bairro . ', ' . $protocolo->protocol_cidade . ', ' . $protocolo->protocol_estado . '.  
    CEP: ' . $protocolo->protocol_cep . '    Telefone: ' . $protocolo->protocol_telefone . '.
    de E-mail ' . $protocolo->protocol_email . '.

    
    <h2>PROCURAÇÃO</h2>
    <p>Por este instrumento particular o(a) outorgante acima qualificado(a) nomeia e
    constitui como bastante procuradoras: IGNEZ MARIA MENDES LINHARES, inscrita na
    OAB/MT nº 4979-O; IGNEZ LINHARES – SOCIEDADE INDIVIDUAL DE ADVOCACIA,
    inscrita no CNPJ Nº 51.738.218/001-89 e registrada na OAB/MT sob o número 3453,
    com endereço à Rua Doze, Quadra 17, n. 15, Morada do Ouro (St. Morada do Ouro
    II), Cuiabá-MT, CEP 78.053-731; LEILE DAYANE OLIVEIRA LELIS, inscrita na
    OAB/MT nº 19.646-O; LEILE LELIS SOCIEDADE INDIVIDUAL DE ADVOCACIA, inscrita
    no CNPJ N° 51.288.313/0001-28 e registrada na OAB/MT sob o número 3452, com
    endereço à Avenida Brasil, 1000, Condomínio Villa Universia, Bloco 2, apartamento
    1006, Cristo Rei, Várzea Grande.</p>
    <p>A quem são conferidos os amplos poderes da CLÁUSULA AD JUDICIA e poderes especiais para ação de cobrança de diferenças salariais, podendo atuar em qualquer instância ou Tribunal, conferindo poderes especiais para conciliar, transigir, assinar documentos, retirar alvarás, receber e dar quitação, podendo, inclusive, substabelecer com ou sem reserva de poderes, dando tudo por certo, bom e valioso.</p>

    <h2>HONORÁRIOS ADVOCATÍCIOS</h2>
    <p>(SOMENTE PARA NÃO SINDICALIZADOS(AS))</p>
    <p>Ficam ajustados honorários advocatícios contratuais quota litis em 20% do proveito
    econômico, mediante retenção, por via de alvará judicial ou qualquer outra forma de
    recebimento, sem prejuízo dos honorários sucumbenciais. Os honorários contratuais
    serão devidos por não sindicalizados(as), inclusive em casos de acordo, desistência
    ou revogação dos poderes sem justo motivo. Não se considera justo motivo a demora
    na tramitação do feito.</p>
    <p>Cuiabá, ' . $dataFormatada . '</p><br>
    <p>________________________________________<br>Assinatura</p>

    <div class="page-break"></div>
    <h1>DECLARAÇÃO DE HIPOSSUFICIÊNCIA</h1>
    <p>Eu, ' . $protocolo->protocol_nome . ', brasileiro(a), estado civil: ' . $protocolo->protocol_estadocivil . ', função: ' . $protocolo->protocol_situacaoprofissional . ', inscrito(a) no CPF sob o n.º ' . $protocolo->protocol_cpf . ' e portador(a) da RG ' . $protocolo->protocol_identidade . ', residente e domiciliado(a) à ' . $protocolo->protocol_endereco . ', ' . $protocolo->protocol_numero . ', ' . ($protocolo->protocol_complemento ?? '') . $protocolo->protocol_bairro . ', ' . $protocolo->protocol_cidade . ', ' . $protocolo->protocol_estado . ', CEP: ' . $protocolo->protocol_cep . ', declaro para os devidos fins e a quem possa interessar que não possuo condições financeiras para arcar com as custas processuais da presente demanda sem acarretar prejuízo ao meu sustento e ao de minha família.</p>
    <p>Declaro ser hipossuficiente e para tanto protesto pelos benefícios da gratuidade na presente demanda judicial.</p>
    <p>Sem mais, é o que declaro.</p>
    <p>Cuiabá, ' . $dataFormatada . '</p><br>
    <p>_________________________________________<br>Assinatura</p>
    </body>
    </html>';

    // Salvar o HTML temporariamente
    $htmlPath = WRITEPATH . 'uploads/' . date('YmdHis') . '.html';
    file_put_contents($htmlPath, $htmlContent);

    // Converter HTML para PDF usando DomPDF
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($htmlContent);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $pdfOutput = $dompdf->output();
    $pdfPath = WRITEPATH . 'uploads/' . date('YmdHis') . '.pdf';
    file_put_contents($pdfPath, $pdfOutput);

    // Retornar o PDF para download
    return $this->response->download($pdfPath, null)->setFileName('procuracao_e_declaracao_hipossuficiencia.pdf');
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
                    unlink($matriculaFolder . '/contrato.pdf');
                }
                move_uploaded_file($_FILES['imgContrato']['tmp_name'], $matriculaFolder . '/contrato.pdf');
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
            move_uploaded_file($_FILES['imgContrato']['tmp_name'], $matriculaFolder . '/contrato.pdf');
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
