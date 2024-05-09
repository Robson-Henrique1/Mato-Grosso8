<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Página de Exemplo</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-+Hv0GMC3wqYgMOT0jW6/5BL6eQp6k9z3ftmhSm06l2Dv3vXsW2hTqoYwpzlY57m2vF2bIoN+5TgNcrxIOJn3+A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f3f4f6;
  }
  .container {
    text-align: center;
    background-color: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    max-width: 600px; /* Limitando a largura para evitar quebra */
    width: 100%; /* Garantindo que o container ocupe a largura disponível */
  }
  h1 {
    color: #333;
    margin-bottom: 20px;
  }
  p {
    color: #666;
    margin-bottom: 40px;
  }
  .video-container {
    position: relative;
    overflow: hidden;
    margin-bottom: 40px;
    border-radius: 10px;
  }
  .video-container iframe {
    width: 100%;
    height: 300px;
  }
  .box {
    background-color: #f0f0f0;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  input[type="text"] {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 10px; /* Espaçamento entre o input e os botões */
    font-size: 16px;
    width: calc(100% - 50px); /* Ajustando a largura para considerar o tamanho dos botões */
  }
  button[type="submit"],
  button[type="reset"] {
    padding: 12px 30px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
    margin-left: 10px; /* Espaçamento entre os botões */
  }
  button[type="submit"] {
    background-color: #4caf50;
    color: white;
  }
  button[type="submit"]:hover {
    background-color: #45a049;
  }
  button[type="reset"] {
    background-color: #f44336;
    color: white;
  }
  button[type="reset"]:hover {
    background-color: #d32f2f;
  }
  .error-message {
    color: red;
    margin-top: 10px;
  }
</style>
</head>
<body>

<div class="container">
  <h1>Execução do 1/3 de Férias</h1>
  <p>Saiba se você tem o direito a execução do 1/3 de Férias referente aos processos 0000000-XX.20XX.8.11.0041 e 0000000-XX.20XX.8.11.0041</p>
  <div class="video-container">
    <iframe src="https://www.youtube.com/embed/FZzV5Ak2JK8" frameborder="0" allowfullscreen></iframe>
  </div>
  <div class="box">
    <h2 style="font-size: 24px;">Consulte aqui</h2>
    <form id="consultForm" action="<?= base_url('verificar') ?>" method="post">
      <input type="text" id="nome" name="nome" placeholder="Digite seu nome">
      <button type="submit"><i class="fas fa-search"></i> Consultar</button>
      <button type="reset"><i class="fas fa-sync-alt"></i> Limpar</button>
    </form>
    <?php if (isset($erro)): ?>
      <p class="error-message"><?= $erro ?></p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
