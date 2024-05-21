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
    <h2>Formulário</h2>
    <form id="form" action="<?= base_url('salvardocumento') ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="matricula" id="matricula" value="<?php echo $matricula; ?>">
        <div class="form-group">
            <label for="nome">Nome:*</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= isset($protocolo) ? $protocolo->protocol_nome : $nome; ?>" required readonly>
        </div>
        <div class="form-group">
            <label for="email">Email:*</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= isset($protocolo) ? $protocolo->protocol_email : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="telefone">Telefone com DDD:* </label>
            <input type="tel" class="form-control" id="telefone" name="telefone"  value="<?= isset($protocolo) ? $protocolo->protocol_telefone : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="civil">Estado Civil:*</label>
            <select class="form-control" id="civil" name="civil" required>
            <option value="">Selecione</option>
            <option value="Solteiro" <?php echo isset($protocolo) && $protocolo->protocol_estadocivil == 'Solteiro' ? 'selected' : ''; ?>>Solteiro</option>
            <option value="Casado" <?php echo isset($protocolo) && $protocolo->protocol_estadocivil == 'Casado' ? 'selected' : ''; ?>>Casado</option>
            <option value="Divorciado" <?php echo isset($protocolo) && $protocolo->protocol_estadocivil == 'Divorciado' ? 'selected' : ''; ?>>Divorciado</option>
            <option value="Viúvo" <?php echo isset($protocolo) && $protocolo->protocol_estadocivil == 'Viúvo' ? 'selected' : ''; ?>>Viúvo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="rg">RG:*</label>
            <input type="text" class="form-control" id="rg" name="rg" value="<?= isset($protocolo) ? $protocolo->protocol_identidade : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="exp">Orgão Expedidor:*</label>
            <input type="text" class="form-control" id="exp" name="exp" value="<?= isset($protocolo) ? $protocolo->protocol_orgaoexped : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="cpf">CPF:*</label>
            <input type="text" class="form-control" id="cpf" name="cpf" value="<?= isset($protocolo) ? $protocolo->protocol_cpf : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="cep">CEP:*</label>
            <input type="text" class="form-control" id="cep" name="cep" value="<?= isset($protocolo) ? $protocolo->protocol_cep : ''; ?>" required>
        </div>
        <div id="endereco">
            <div class="form-group">
                <label for="logradouro">Endereço/Logradouro:*</label>
                <input type="text" class="form-control" id="logradouro" name="logradouro" value="<?= isset($protocolo) ? $protocolo->protocol_endereco : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="numero">Número:*</label>
                <input type="text" class="form-control" id="numero" name="numero" value="<?= isset($protocolo) ? $protocolo->protocol_numero : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="complemento">Complemento:</label>
                <input type="text" class="form-control" id="complemento" name="complemento" value="<?= isset($protocolo) ? $protocolo->protocol_complemento : ''; ?>" >
            </div>
            <div class="form-group">
                <label for="bairro">Bairro:*</label>
                <input type="text" class="form-control" id="bairro" name="bairro" value="<?= isset($protocolo) ? $protocolo->protocol_bairro : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="cidade">Cidade:*</label>
                <input type="text" class="form-control" id="cidade" name="cidade" value="<?= isset($protocolo) ? $protocolo->protocol_cidade : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="estado">UF:*</label>
                <input type="text" class="form-control" id="estado" name="estado" value="<?= isset($protocolo) ? $protocolo->protocol_estado : ''; ?>" required>
            </div>
        </div>
        <div class="form-group">
                <label for="estado">Banco:*</label>
                <input type="text" class="form-control" id="banco" name="banco" value="<?= isset($protocolo) ? $protocolo->protocol_banco : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="estado">Agência:*</label>
                <input type="text" class="form-control" id="agencia" name="agencia" value="<?= isset($protocolo) ? $protocolo->protocol_agencia : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="estado">Operação:*</label>
                <input type="text" class="form-control" id="operacao" name="operacao" value="<?= isset($protocolo) ? $protocolo->protocol_operacao : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="estado">Conta com dígito:*</label>
                <input type="text" class="form-control" id="contadigito" name="contadigito" value="<?= isset($protocolo) ? $protocolo->protocol_contadigito : ''; ?>" required>
            </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="declaracao" name="declaracao" required>
            <label class="form-check-label" for="declaracao">Declaro que não possuo processo em curso com a cobrança de 1/3 de férias e caso haja a entidade, seja condenada por litigância as despesa correrão por conta.</label>
        </div>
        <input type="hidden" name="ehupdate" id="ehupdate" value="<?= isset($protocolo) ? 'sim' : 'nao'; ?>">
        <button type="submit" class="btn btn-primary btn-block" >Avançar</button>
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
