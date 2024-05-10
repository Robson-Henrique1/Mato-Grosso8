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
<form id="form" action="<?= base_url('baixardocumento'); ?>" method="post" enctype="multipart/form-data">        <h2>Baixe a ficha de procuração, preencha-a para uso posterior</h2>
        <div class="form-group" style="text-align: center;"></div>
            <a id="btn-download-2" style="text-align: center;" class="download-button" href="../public/procuracao_e_declaracao_hipossuficiencia.pdf" download><i class="fas fa-file-pdf"></i> Baixar Ficha de Procuração</a>
        <br>
    <p> <input type="hidden" name="nome" id="nome" value="<?php echo $nome; ?>"></p>
        <button type="submit" class="btn btn-primary btn-block" disabled>Avançar</button>
    </form>
 

    <script>
        document.getElementById('btn-download-2').addEventListener('click', function() {
            document.querySelector('button[type="submit"]').removeAttribute('disabled');
        });
    </script>
</div>
</body>
</html>