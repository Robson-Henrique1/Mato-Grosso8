<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulário</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }
    .container {
        max-width: 600px;
        margin: 50px auto;
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
    }
    .form-group {
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    label {
        font-weight: bold;
        transition: all 0.3s ease;
    }
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    select {
        transition: all 0.3s ease;
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 10px;
        width: 100%;
    }
    input[type="file"] {
        transition: all 0.3s ease;
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 10px;
        width: 100%;
    }
    input[type="submit"] {
        transition: all 0.3s ease;
        border-radius: 5px;
        border: none;
        padding: 12px 20px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        width: 100%;
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
    #endereco {
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        margin-top: 20px;
        transition: all 0.3s ease;
    }
    h1, h2 {
        text-align: center;
        margin-bottom: 30px;
    }
    .download-button {
        transition: all 0.3s ease;
        border-radius: 5px;
        border: none;
        padding: 12px 20px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        width: 100%;
    }
    .download-button:hover {
        background-color: #0056b3;
    }
    .container .download-button + .download-button {
        margin-top: 10px;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Baixe a ficha de procuração, preencha-a para uso posterior</h2>
    <div class="row">
        <div class="col">
            <a id="btn-download-2" class="download-button" href="./cv_Paula_Araujo.pdf" download><i class="fas fa-file-pdf"></i> SINDICALIZADO</a>
        </div>
        <div class="col">
            <a id="btn-download-2" class="download-button" href="./cv_Paula_Araujo.pdf" download><i class="fas fa-file-pdf"></i> NÃO SINDICALIZADO</a>
        </div>
    </div>
</div>
<div class="container">
    <h2>Formulário</h2>
    <form id="form" action="<?= base_url('salvardocumento') ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= $nome; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="telefone">Telefone com DDD:</label>
            <input type="tel" class="form-control" id="telefone" name="telefone" required>
        </div>
        <div class="form-group">
            <label for="civil">Estado Civil:</label>
            <select class="form-control" id="civil" name="civil" required>
            <option value="">Selecione</option>
            <option value="Solteiro">Solteiro</option>
            <option value="Casado">Casado</option>
            <option value="Divorciado">Divorciado</option>
            <option value="Viúvo">Viúvo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="rg">RG:</label>
            <input type="text" class="form-control" id="rg" name="rg" required>
        </div>
        <div class="form-group">
            <label for="exp">Orgão Expedidor:</label>
            <input type="text" class="form-control" id="exp" name="exp" required>
        </div>
        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" class="form-control" id="cpf" name="cpf" required>
        </div>
        <div class="form-group">
            <label for="cep">CEP:</label>
            <input type="text" class="form-control" id="cep" name="cep" required>
        </div>
        <div id="endereco">
            <div class="form-group">
                <label for="logradouro">Logradouro:</label>
                <input type="text" class="form-control" id="logradouro" name="logradouro" required>
            </div>
            <div class="form-group">
                <label for="cidade">Cidade:</label>
                <input type="text" class="form-control" id="cidade" name="cidade" required>
            </div>
            <div class="form-group">
                <label for="bairro">Bairro:</label>
                <input type="text" class="form-control" id="bairro" name="bairro" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <input type="text" class="form-control" id="estado" name="estado" required>
            </div>
            <div class="form-group">
                <label for="complemento">Complemento:</label>
                <input type="text" class="form-control" id="complemento" name="complemento">
            </div>
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" class="form-control" id="numero" name="numero" required>
            </div>
        </div>
        <div class="form-group">
            <label for="pdfCpf">Anexar CPF (PDF):</label>
            <input type="file" class="form-control-file" id="pdfCpf" name="pdfCpf" accept="application/pdf" required>
        </div>
        <div class="form-group">
            <label for="pdfComprovante">Anexar Comprovante de Residência (PDF):</label>
            <input type="file" class="form-control-file" id="pdfComprovante" name="pdfComprovante" accept="application/pdf" required>
        </div>
        <div class="form-group">
            <label for="pdfContrato">Anexar Contrato (PDF):</label>
            <input type="file" class="form-control-file" id="pdfContrato" name="pdfContrato" accept="application/pdf" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="declaracao" name="declaracao" required>
            <label class="form-check-label" for="declaracao">Declaro que não possuo processo em curso com a cobrança de 1/3 de férias e caso haja a entidade, seja condenada por litigância as despesa correrão por conta.</label>
        </div>
        <button type="submit" class="btn btn-primary btn-block" >Enviar</button>
    </form>
</div>

<script>

$(document).ready(function($){
        // Máscara para CPF
        $('#cpf').mask('000.000.000-00');

        // Máscara para CEP
        $('#cep').mask('00000-000');

        // Máscara para Telefone com DDD
        $('#telefone').mask('(00) 00000-0000');

        // Máscara para RG 
        $('#rg').mask('99.999.999-9');
    });

    // Function to fill address fields using ViaCEP API
    function fillAddressFields() {
        var cep = $('#cep').val();
        if (cep.length === 9) {
            $.ajax({
                url: 'https://viacep.com.br/ws/' + cep + '/json/',
                dataType: 'json',
                success: function(data) {
                    if (!data.erro) {
                        $('#logradouro').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                    }
                }
            });
        }
    }

    // Event listener for CEP field
    $('#cep').on('blur', function() {
        fillAddressFields();
    });

    
</script>
</body>
</html>
