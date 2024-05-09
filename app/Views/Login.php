<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .logout-message {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #28a745;
        color: #fff;
        font-size: 16px;
        display: none;
        z-index: 1000;
    }

        .login-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 30px;
            color: #333;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-container button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .login-container button:hover {
            background-color: #45a049;
        }

        .login-container .forgot-password {
            color: #666;
            font-size: 14px;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }

        .error-message {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Exibir a mensagem de logout, se existir -->
        <div id="logoutMessage" class="logout-message"></div>


        <!-- Conteúdo do menu -->
    </div>
    <div class="login-container">
        <h2>Login</h2>
        <form action="<?= base_url('login/verificar') ?>" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error_message)) : ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php endif; ?>
    </div>
</body>

<script>
    // Função para mostrar a mensagem de logout
    function showLogoutMessage(message) {
        var logoutMessage = document.getElementById('logoutMessage');
        logoutMessage.innerHTML = message;
        logoutMessage.style.display = 'block';

        // Esconde a mensagem após 7 segundos
        setTimeout(function() {
            logoutMessage.style.display = 'none';
        }, 7000);
    }

    // Exemplo de uso
    <?php if (isset($logout_message)) : ?>
        showLogoutMessage('<?= $logout_message ?>');
    <?php endif; ?>
</script>

</html>