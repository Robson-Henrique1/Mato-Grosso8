<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Protocolos Recebidos</title>
    <!-- Inclua o CSS do DataTables e do Bootstrap -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Adicione os estilos do SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Estilos personalizados */
        body {
            background-color: #f0f0f0;
            background-size: cover;
            background-position: center;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }
        .table {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        th, td {
            text-align: center;
            color: #000;
        }
        .btn-add {
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-add:hover {
            background-color: #218838;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .fade-in {
            animation: fadeIn 1s ease forwards;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .btn-action {
            padding: 5px;
            margin: 0 5px;
            font-size: 18px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-view {
            background-color: #007bff;
        }
        .btn-download {
            background-color: #28a745;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }
        #successMessage {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            width: 300px;
            padding: 15px;
            border-radius: 5px;
            background-color: #4caf50; /* Cor verde vibrante */
            color: #fff;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            animation: slideInRight 0.5s ease forwards, fadeOut 0.5s ease 5s forwards;
        }

        #successMessage span {
            margin-right: 10px;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Protocolos</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Olá, <?= session('usuario_nome') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link logout" href="<?= base_url('login/logout') ?>">Deslogar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php if(session()->getFlashdata('status')): ?>
    <div id="successMessage" class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Sucesso!</strong> <?= session()->getFlashdata('status') ?>
            </div>
        </div>
    </div>
<?php endif; ?>


<div class="container mt-5 fade-in">
    <h1 class="mb-4 text-center">Lista de Protocolos Recebidos</h1>
    <button class="btn btn-add btn-download-all">Baixar Tudo</button>
    <table id="protocolos_table" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Matricula</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Situação</th>
            <th>Ações</th> <!-- Nova coluna para as ações -->
        </tr>
        </thead>
        <tbody>
        <?php foreach ($protocolosrecebidos as $protocolo): ?>
            <tr>
                <td><?= $protocolo['protocol_matricula'] ?></td>
                <td><?= $protocolo['protocol_nome'] ?></td>
                <td><?= $protocolo['protocol_cpf'] ?></td>
                <td><?= $protocolo['protocol_situacaoprofissional'] ?></td>
                
                <td>
                    <button class="btn btn-action btn-view"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-action btn-download"><i class="fas fa-download"></i></button>
                    <!-- Adicionando a classe "delete-protocol" e o data-id com o ID do protocolo -->
                    <a href="<?=base_url('login/delete/'.$protocolo['protocol_id']) ?>" class="btn btn-action btn-delete delete-protocol"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Inclua o JavaScript do jQuery, do DataTables e do Bootstrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<!-- Inclua o script do SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#protocolos_table').DataTable({
            "pagingType": "simple_numbers",
            "ordering": true,
            "searching": true,
            "info": false,
            "lengthChange" : false,
            "pageLength": 50,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nenhum registro encontrado",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros totais)",
                "search": "Pesquisar:",
                "paginate": {
                    "first": "Primeira",
                    "last": "Última",
                    "next": "Próxima",
                    "previous": "Anterior"
                }
            }
        });

        // Adiciona um efeito de pulso ao clicar no botão "Adicionar Protocolo"
        $('.delete-protocol').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Tem certeza?',
                text: "Você realmente deseja excluir este protocolo?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Se confirmado, redirecione para a URL de exclusão
                    window.location.href = $(this).attr('href');
                }
            });
        });

        $('.logout').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Tem certeza?',
                text: "Você realmente deseja sair do sistema?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Se confirmado, redirecione para a URL de exclusão
                    window.location.href = $(this).attr('href');
                }
            });
        });
    });
</script>
</body>
</html>
