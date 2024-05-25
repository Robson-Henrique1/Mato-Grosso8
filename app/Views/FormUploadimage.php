<!DOCTYPE html>
<html lang="pt-BR">
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

        button[disabled] {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        button.loading::after {
            content: "";
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            width: 50%;
            text-align: center;
            position: relative;
        }

        .close {
            color: #aaa;
            float: none;
            font-size: 28px;
            font-weight: bold;
            transition: color 0.3s ease;
            cursor: pointer;
            right: 20px;
            top: 10px;
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
            margin-top: 0px;
            text-align: center;
        }

        #btn-fechar:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <div class="upload-form">
        <h1>Envio dos Documentos (APENAS EM FORMATO PDF)</h1>
        <form id="form-upload" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="pdfCpf">Anexar Documento de identificação válido e legível, que podem ser: Identidade com CPF, Registro Profissional, CNH, Passaporte, etc:*</label>
                <br>
                <?php if (isset($ehupdate)): ?>
                    <a href="<?= 'assets/' . $matricula . '/identificacao.pdf' ?>" target="_blank"></a>
                <?php endif; ?>
                <input type="file" class="form-control-file" id="pdfId" name="pdfId" accept="application/pdf" required>
            </div>
            <div class="form-group">
                <label for="pdfComprovante">Anexar Comprovante de Residência Válido que são apenas Conta de Luz ou Conta de Água (PDF):*</label><br>
                <?php if (isset($ehupdate)): ?>
                    <a href="<?= 'assets/' . $matricula . '/residencia.pdf' ?>" target="_blank"></a>
                <?php endif; ?>
                <input type="file" class="form-control-file" id="pdfComprovante" name="pdfComprovante" accept="application/pdf" required>
            </div>
            <div class="form-group">
                <label for="imgContrato">Anexar a Procuração que você baixou, imprimiu e assinou (PDF):*</label>
                <?php if (isset($ehupdate)): ?>
                    <a href="<?= 'assets/' . $matricula . '/contrato.pdf' ?>" target="_blank"></a>
                <?php endif; ?>
                <input type="file" class="form-control-file" id="imgContrato" name="imgContrato" accept="application/pdf" required>
            </div>
            <input type="hidden" name="matricula" id="matricula" value="<?= $matricula; ?>">
            <input type="hidden" name="ehupdate" id="ehupdate" value="<?= $ehupdate; ?>">
            <p>OS TRÊS DOCUMENTOS ACIMA SÃO OBRIGATÓRIOS E PRECISAM ESTAR LEGÍVEIS E APENAS EM PDF QUE É O ÚNICO FORMATO ACEITO PELA JUSTIÇA</p>
            <button type="submit" id="submit-btn">Enviar</button>
        </form>
    </div>

    <div id="modal-confirmacao" class="modal">
        <div class="modal-content">

            <h2 id="confirmation-message"></h2>
            <p>O seu cadastro e documentos foram enviados com sucesso! Os documentos vão ser verificados pela equipe do departamento jurídico e se estiver tudo certo, você receberá um e-mail com o número do protocolo.</p>
            <p id="confirmation-message2"></p>
            <button class="close" id="btn-fechar">Fechar</button>
            <script>
            const btnFechar = document.getElementById('btn-fechar');
            btnFechar.addEventListener('click', function() {
            window.location.href = '<?= base_url('form') ?>';
            });
        </script>
            </div>
            
        </div>
        
    </div>

    <script>
        const modal = document.getElementById('modal-confirmacao');
        const formUpload = document.getElementById('form-upload');
        const confirmationMessage = document.getElementById('confirmation-message');
        const confirmationMessage2 = document.getElementById('confirmation-message2');
        const submitBtn = document.getElementById('submit-btn');

        formUpload.addEventListener('submit', function(event) {
            event.preventDefault();
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');

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
                confirmationMessage2.textContent = `Quaisquer dúvidas, entrar em contato com o departamento jurídico informando o número ${data.codigo}.`;
                confirmationMessage.textContent = `Documentos enviados com sucesso! O código de confirmação é ${data.codigo}.`;
                modal.style.display = "block";
            })
            .catch(error => {
                console.error(error);
                confirmationMessage.textContent = 'Ocorreu um erro ao enviar a imagem. Por favor, tente novamente.';
                modal.style.display = "block";
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.classList.remove('loading');
            });
        });

        const closeModalElements = document.querySelectorAll('.close');
        closeModalElements.forEach(element => {
            element.addEventListener('click', function() {
                modal.style.display = "none";
            });
        });
    </script>
</body>
</html>
