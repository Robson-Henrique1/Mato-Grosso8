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
            max-width: 400px;
            width: 100%;
            transition: transform 0.3s ease;
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
    <h1>Enviar Imagem</h1>
    <form id="form-upload" method="post" enctype="multipart/form-data">
        <input type="file" id="imagem" name="imagem" accept="image/*" required>
        <input type="hidden" name="matricula" value="<? echo $matricula; ?>">
        <button type="submit">Enviar</button>
    </form>
</div>

<div id="modal-confirmacao" class="modal">
    <div class="modal-content">
        <button id="btn-fechar" class="close">Fechar</button>
        <h2 id="confirmation-message"></h2>
    </div>
</div>

<script>
    const modal = document.getElementById('modal-confirmacao');
    const btnFechar = document.getElementById('btn-fechar');
    const formUpload = document.getElementById('form-upload');
    const confirmationMessage = document.getElementById('confirmation-message');

    formUpload.addEventListener('submit', function(event) {
        alert('here');
        event.preventDefault();
        const file = document.getElementById('imagem').files[0];
        
        if (file) {
            alert('file');
            const formData = new FormData(this);

            fetch('<?= base_url('salvarimagem') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response from the server
                console.log(data);
                alert(data.cod);
                confirmationMessage.textContent = `Imagem enviada com sucesso! O código de confirmação é ${data.cod}.`;
                modal.style.display = "block";
            })
            .catch(error => {
                alert(data);
                // Handle any errors that occur during the request
                console.error(error);
            });
        }
    });

    btnFechar.addEventListener('click', function() {
        modal.style.display = "none";
    });
</script>
</body>
</html>
