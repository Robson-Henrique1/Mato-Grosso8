<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Imagem e Confirmação</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .upload-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
            transition: transform 0.3s ease;
            margin: 20px auto;
        }

        .upload-form:hover {
            transform: translateY(-5px);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="file"] {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            width: 70%;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            transition: color 0.3s ease;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        #btn-fechar {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #btn-fechar:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body><div class="upload-form">
    <h1>Enviar Documentos</h1>
    <form id="form-upload" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="pdfCpf">Anexar Documento de identificação [CPF|RG|CNH] (PDF):*</label>
            <br>
            <?php if (isset($ehupdate)):
                echo '<a href="' . 'assets/'.$matricula.'/identificacao.pdf' . '" target="_blank">identificacao.pdf</a>';
             endif; ?>
            <input type="file" class="form-control-file" id="pdfId" name="pdfId" accept="application/pdf" <?= isset($ehupdate) ? '' : 'required'; ?> >
        <div class="form-group">
            <label for="pdfComprovante">Anexar Comprovante de Residência (PDF):*</label>
            <?php if (isset($ehupdate)):
                echo '<a href="' . 'assets/'.$matricula.'/residencia.pdf' . '" target="_blank">residencia.pdf</a>';
             endif; ?>
            <input type="file" class="form-control-file" id="pdfComprovante" name="pdfComprovante" accept="application/pdf" <?= isset($ehupdate) ? '' : 'required'; ?> >
        </div>
        <div class="form-group">
            <label for="pdfContrato">Anexar Contrato/Procuração Preenchida (img):*</label>
            <?php if (isset($ehupdate)):
                echo '<a href="' . 'assets/'.$matricula.'/contrato.png' . '" target="_blank">contrato imagem</a>';
             endif; ?>
            <input type="file" class="form-control-file" id="imgContrato" name="imgContrato" accept="image/*" <?= isset($ehupdate) ? '' : 'required'; ?> >
        </div>
        <input type="hidden" name="matricula" id="matricula" value="<?=$matricula; ?>">
        <input type="hidden" name="ehupdate" id="ehupdate" value="<?=$ehupdate; ?>">
        <button type="submit">Enviar</button>
    </form>
</div>        

<div id="modal-confirmacao" class="modal">
    <div class="modal-content">
        <button id="btn-fechar" class="close">Fechar</button>
        <h2 id="confirmation-message"></h2>
        <script>
            const btnFechar = document.getElementById('btn-fechar');
            btnFechar.addEventListener('click', function() {
            window.location.href = '<?= base_url('form') ?>';
            });
        </script>
    </div>
</div>

<script>
    const modal = document.getElementById('modal-confirmacao');
    const formUpload = document.getElementById('form-upload');
    const confirmationMessage = document.getElementById('confirmation-message');

    formUpload.addEventListener('submit', function(event) {
        event.preventDefault();
        const pdfId = document.getElementById('pdfId').files[0];
        const pdfComprovante = document.getElementById('pdfComprovante').files[0];
        const imgContrato = document.getElementById('imgContrato').files[0];
        const formData = new FormData();
        
        if (pdfId) {
            formData.append('pdfId', pdfId);
        }
        if (pdfComprovante) {
            formData.append('pdfComprovante', pdfComprovante);
        }
        if (imgContrato) {
            formData.append('imgContrato', imgContrato);
        }
        formData.append('matricula', document.getElementById('matricula').value);
        formData.append('ehupdate', document.getElementById('ehupdate').value);

        fetch('<?= base_url('salvarimagem') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response from the server
            console.log(data);
            confirmationMessage.textContent = `Imagem enviada com sucesso! O código de confirmação é ${data.codigo}.`;
            modal.style.display = "block";
        })
        .catch(error => {
            console.log(response);
            console.log(data);
            // Handle any errors that occur during the request
            console.error(error);
        });
    });

    btnFechar.addEventListener('click', function() {
        modal.style.display = "none";
    });
</script>
</body>
</html>
